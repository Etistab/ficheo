<?php
require_once('model/users.php');
require_once('model/sheets.php');
require_once('model/quiz.php');
require_once('model/notifications.php');
require_once('model/comment.php');
require_once('controller/header.php');

function printInactiveSheets(){
    $inactiveCards = getInactiveSheets();

    if($inactiveCards == false){
        echo 'Aucune fiche à activer';
    }
    else {
        while($card = $inactiveCards->fetch()) {
            echo '<a href="index.php?page=user&section=admin&action=sheetActivation&id='.$card['id'].'">'.$card['title'].'</a><br/>';
        }
    }
}
function printInactiveQuiz(){
  $inactiveQuiz = getInactiveQuiz();

  if($inactiveQuiz == false){
      echo 'Aucun Quiz à activer';
  }
  else {
      while($Quiz = $inactiveQuiz->fetch()) {
          echo '<a href="index.php?page=user&section=admin&action=quizActivation&id='.$Quiz['id'].'">'.$Quiz['title'].'</a><br/>';
      }
  }
}
function printModifQuiz(){
  $modifQuiz = getModifQuiz();
  if($modifQuiz == false){
    echo "Aucun Quiz possède une demande de modification";
  }
  else {
    while ($quiz = $modifQuiz->fetch()) {
        echo '<a href="index.php?page=user&section=admin&action=quizModification&id='.$quiz['id'].'">'.$quiz['title'].'</a><br/>';
    }
  }
}
function getTotalViews(){
    $viewsLog = fopen('public/logs/views.log', 'r');

    return fgets($viewsLog);
}

function resetViews(){
    $viewsLog = fopen('public/logs/views.log', 'r+');
    ftruncate($viewsLog, 0);
    fputs($viewsLog, 0);
}

function printSheets(){

    $sheets = getSheets();

    $count = 0;
        foreach ($sheets as $sheet) {
            if($sheet['active'] == 1){
                $active = '<span style="color: green">Oui</span>';
            }
            else{
                $active = '<span style="color: red">Non</span>';
            }
            echo "<tr>";
            echo "<td>" . $sheet["id"] . "</td>";
            echo "<td><a href='index.php?page=sheet&id=" .$sheet['id']. "'>" . $sheet["title"] . "</a></td>";
            echo "<td>" . $sheet["author"] . "</td>";
            echo "<td>" . $sheet["category"] . "</td>";
            echo "<td>" . $active . "</td>";
            echo "<td>" . $sheet['date_creation'] . "</td>";
            if($sheet['active'] == 1)   echo "<td><a href='index.php?page=user&section=admin&action=desactSheet&id=" . $sheet["id"] . "'> Désactiver </a></td>";
            else echo '<td></td>';
            echo "<td><a onclick='alert_delete_sheet(".$sheet["id"].")'> Supprimer </a></td>";

            $count++;
    }
}
function printQuizTable(){
  $quizz = getAllQuiz();
  $count = 0;
  foreach($quizz as $quiz){
    if($quiz['active'] == 1){
        $active = '<span style="color: green">Oui</span>';
    }
    else{
        $active = '<span style="color: red">Non</span>';
    }
    echo "<tr>";
    echo "<td>".$quiz['id']."</td>";
    echo "<td><a href='index.php?page=quiz&id=".$quiz['id']."'>".$quiz['title']."</a></td>";
    echo "<td>".$quiz["author"]."</td>";
    echo "<td>".$active."</td>";
    echo "<td>".$quiz['date_creation']."</td>";
    if($quiz['active'] == 1)   echo "<td><a href='index.php?page=user&section=admin&action=desactQuiz&id=" . $quiz["id"] . "'> Désactiver </a></td>";
    else echo '<td></td>';
    echo "<td><a onclick='alert_delete_quiz(".$quiz["id"].")'> Supprimer </a></td>";

    $count++;
  }

}
function printQuestion($id,$modif){
  $number = countQuestions($id,$modif);
  $id_question = getFirstQuestionsId($id,$modif);
  for ($i = 0;$i<$number[0];$i++){
    $question = getQuestions($id_question);
      echo "<p class='secret' name='question' id='question_".($i+1)."'>".$question["question"]."</p>";
      echo "<p class='secret' id='reponse_".($i+1)."'>".$question["answer"]."</p>";
      echo "<p class='secret' id='choix2_".($i+1)."'>".$question["choice1"]."</p>";
      echo "<p class='secret' id='choix3_".($i+1)."'>".$question["choice2"]."</p>";
      echo "<p class='secret' id='choix4_".($i+1)."'>".$question["choice3"]."</p>";
      $id_question = $id_question + 1;
    }


}
function isCreator(){
  $creator = getQuizInfo('auteur',$_GET['id']);
  if(isset($_SESSION['id'])){
    if(isset($_SESSION['id']) == $creator){
      echo "<p> <a href='index.php?page=modifQuiz&id=".$_GET['id']."'><button type='button' class='btn btn-primary'>Modifier</button></a></p> ";
    }
  }
}
function printMarks(){
  if (isset($_SESSION['id'])) {
    if (getMarks($_SESSION['id'],$_GET['id']) != NULL) {
      echo "Tu avais ".getMarks($_SESSION['id'],$_GET['id'])[0]." bonne(s) réponse(s) sur ".countQuestions($_GET['id'])[0]." question(s) la dernière fois";
      if (getMarks($_SESSION['id'],$_GET['id'])[0] == countQuestions($_GET['id'])[0]) {
        echo "<br><br>BRAVO tu as la note maximal !";
      }else {
        echo "<br><br>Courage ! tu peux mieux faire !";
      }
    }else{
      echo "Tu n'as pas encore de note sur ce quiz! <br>";
      echo "Bon courage!";
    }


  }else{
    echo "Appuyer sur suivant pour commencer le quiz <br>";
    echo "Pour enregistrer votre progression il est nécessaire d'avoir un compte";
  }
}
function isSelected($verify,$pseudo){
    $user = getUser($pseudo);
    if( $user['type'] == $verify){
        return "selected";
    }
    else{
        return '';
    }
}

function isActive($verify,$pseudo){
    $user = getUser($pseudo);
    if( $user['active'] == $verify){
        return "selected";
    }
    else{
        return '';
    }
}

function printUser(){
    $users = getUsers();

    foreach ($users as $user) {
        if($user['isDeleted'] == 0){
        echo "<form method='POST' action ='index.php?page=user&section=admin&action=modify&id=".$user['id']."'>";
        echo "<tr>";
        echo "<td>".$user["id"]."</td>";
        echo "<td><input type='email' name='email' value='".$user["email"]."'></td>";
        echo "<td><input type='text' name='pseudo' value='".$user["pseudo"]."'></td>";
        echo  "<td><select name='type'>";
        ?>
        <option <?= isSelected('admin',$user['pseudo']) ?>>admin</option>
        <option <?= isSelected('member',$user['pseudo']) ?>>member</option>
        <option <?= isSelected('banned',$user['pseudo']) ?>>banned</option>
        <?php
        echo "</select>";
        echo "</td>";
        echo  "<td><select name='active'>";
        ?>
        <option value="1"<?=isActive('1',$user['pseudo']) ?>>Actif</option>
        <option value="0"<?=isActive('0',$user['pseudo']) ?>>Inactif</option>
        <?php
        echo "</select>";
        echo "</td>";
        echo "<td><input type='text' name='experience' value='".$user["experience"]."'></td>";
        echo "<td>".$user["reports"]."</td>";
        echo "<td>".$user["date"]."</td>";
        echo "<td><a onclick='alert_delete_user(".$user["id"].")'> Supprimer </a></td>";
        echo "<td><input type='submit' value='Modifier'></td>";
        echo "</form>";
        }

    }
}

function printDeletedUser(){
    $users = getUsers();

    foreach ($users as $user) {
        if($user['isDeleted'] == 1){
        echo "<form method='POST' action ='index.php?page=user&section=admin&action=modify&id=".$user['id']."'>";
        echo "<tr>";
        echo "<td>".$user["id"]."</td>";
        echo "<td><input type='email' name='email' value='".$user["email"]."'></td>";
        echo "<td><input type='text' name='pseudo' value='".$user["pseudo"]."'></td>";
        echo  "<td><select name='type'>";
        ?>
        <option <?= isSelected('admin',$user['pseudo']) ?>>admin</option>
        <option <?= isSelected('member',$user['pseudo']) ?>>member</option>
        <option <?= isSelected('banned',$user['pseudo']) ?>>banned</option>
        <?php
        echo "</select>";
        echo "</td>";
        echo  "<td><select name='active'>";
        ?>
        <option value="1"<?=isActive('1',$user['pseudo']) ?>>Actif</option>
        <option value="0"<?=isActive('0',$user['pseudo']) ?>>Inactif</option>
        <?php
        echo "</select>";
        echo "</td>";
        echo "<td><input type='text' name='experience' value='".$user["experience"]."'></td>";
        echo "<td>".$user["reports"]."</td>";
        echo "<td>".$user["date"]."</td>";
        echo "<td><a href='index.php?page=user&section=admin&action=undeleteUser&id=".$user["id"]."'> Réactiver </a></td>";
        echo "<td><input type='submit' value='Modifier'></td>";
        echo "</form>";
        }

    }
}

function modify()
{
    $user = getUserById($_GET['id'] );

        if ($user['email'] != $_POST["email"]) {
            modifyUser('email', $_POST['email'], $user['id']);
        }
        if ($user['pseudo'] != $_POST["pseudo"]) {
            if($user['pseudo'] == $_SESSION['pseudo']) $_SESSION['pseudo'] = $_POST['pseudo'];
            modifyUser('pseudo', $_POST['pseudo'], $user['id']);
        }
        if ($user['active'] != $_POST["active"]) {
            modifyUser('active', $_POST['active'], $user['id']);
        }
        if ($user['type'] != $_POST["type"]) {
            modifyUser('type', $_POST['type'], $user['id']);
        }
        if ($user['experience'] != $_POST["experience"]) {
            modifyUser('experience', $_POST['experience'], $user['id']);
        }
}

function messageSheetModification(){
    $affectedLines = 0;
    if(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'activeSheet') {
        $affectedLines = sheetActivation($_GET['id']);
        if ($affectedLines != 0) {
            greenAlert('La fiche a été correctement activé');
            $user = getSheetInfo('author', $_GET['id']);
            $content = 'Ta fiche <a href="index.php?page=sheet&id='.$_GET['id'].'">'.getSheetInfo('title', $_GET['id']).'</a> a été activé par un administrateur !';
            newNotification($content, $user);
            addExperience($user, 30);
        }
    }
    elseif(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'desactSheet'){
        $affectedLines = sheetActivation($_GET['id'], 0);
        if($affectedLines != 0){
            greenAlert('La fiche a été correctement désactivé');
        }
    }
    elseif(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'deleteSheet'){
        $affectedLines = sheetDeleting($_GET['id']);
        if($affectedLines != 0){
            greenAlert('La fiche a été correctement supprimée');
        }
    }
    else {
        redAlert("Erreur");
    }

    if($affectedLines == 0){
        redAlert("Erreur: Le traitement n'a pas pu être effectué");
    }
}
function messageQuizModification(){
  if(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'activeQuiz') {
    $affectedLines = quizActivation($_GET['id']);
    if ($affectedLines !=0) {
      greenAlert('Le quiz a été correctement activé');
    }
  }
  elseif(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'desactQuiz'){
      $affectedLines = quizActivation($_GET['id'], 0);
      if($affectedLines != 0){
          greenAlert('Le Quiz a été correctement désactivé');
      }
  }
  elseif(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'deleteQuiz'){
      $affectedLines = quizDeleting($_GET['id']);
      if($affectedLines != 0){
          greenAlert('Le quiz a été correctement supprimée');
      }
    }
    elseif(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'modifOkQuiz'){

          $affectedLines = quizModifOk($_GET['id']);
          if($affectedLines != 0){
              greenAlert('Le Quiz a été correctement modifié');
          }
      }
      elseif(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action']== 'modifNotOkQuiz'){

          $affectedLines = quizModifNotOk($_GET['id']);
          if($affectedLines != 0){
              greenAlert('La modification a été annulée');
          }
      }
      else{
        redAlert("Erreur");
      }
  }


function printDest(){
    $users = getUsers();
    foreach ($users as $user) {
        echo '<option value="'.$user['email'].'">'.$user['pseudo'].' - '.$user['email'].'</option>';
    }
}
function sendMailToAll(){
    $users = getUsers();
    foreach ($users as $user) {
        if($user['newsletter'] == true)
            mail($user['email'], $_POST['object'], $_POST['message']);
    }
}

function printReportLink($table, $id){
    if($table == 'comments'){
        $comment = getCommentById($id);
        $author = getUserById($comment['author'])['pseudo'];
        return "<a href='index.php?page=sheet&id=".$comment['sheet']."'>Commentaire</a> de <a href='index.php?page=user&user=".$comment['author']."'>".$comment['author']."</a> le ".$comment['dateCom'];
    }
    elseif($table == 'sheets'){
        $sheet = getSheetById($id);
        $author = getUserById($sheet['author'])['pseudo'];
        return "<a href='index.php?page=sheet&id=$id'>".$sheet['title']."</a> de <a href='index.php?page=user&user=$author'>".$author."</a>";
    }
    elseif($table == 'quizz'){
        $quiz = getQuizById($id);
        $author = getUserById($quiz['auteur'])['pseudo'];
        return "<a href='index.php?page=quiz&id=$id'>".$quiz['title']."</a> de <a href='index.php?page=user&user=$author'>".$author."</a>";
    }
}
function printReports(){
    $reports = getActiveReports();

    foreach ($reports as $report){
        $user = getUserById($report['author']);
        $link = printReportLink($report['tableReferences'], $report['idReferences']);
        echo "<tr>
                <td><a href='index.php?page=user&user=".$user['pseudo']."'>".$user['pseudo']."</a></td>
                <td>".$report['date']."</td>
                <td>".$report['content']."</td>
                <td>".$link."</td>
                <td style='text-align: center' onclick=\"sendAjaxRequest('index.php?page=user&section=admin&action=reportAlert&id=".$report['id']."')\"><button type=\"button\" class=\"btn btn-warning\">Avertir</button></td>
                <td style='text-align: center' onclick=\"sendAjaxRequest('index.php?page=user&section=admin&action=reportBan&id=".$report['id']."')\"><button type=\"button\" class=\"btn btn-danger\">Bannir</button></td>
                <td style='text-align: center' onclick=\"sendAjaxRequest('index.php?page=user&section=admin&action=reportDelete&id=".$report['id']."')\"><button type=\"button\" class=\"btn btn-success\">Vu</button></td>
            </tr>
        ";
    }
}
function reportAlert($idReport){
    $report = getReportById($idReport);
    $content = "";
    if ($report['tableReferences'] == 'comments') {
        $comment = getCommentById($report['idReferences']);
        $user = $comment['idAuthor'];
        $content = "<a href='index.php?page=sheet&id=" . $comment['sheet'] . "'>Ton commentaire</a> écrit le " . $comment['dateCom'] . " a été signalé. Après plusieurs signalements, tu risques le banissement";
    } elseif ($report['tableReferences'] == 'sheets') {
        $sheet = getSheetById($report['idReferences']);
        $user = $sheet['author'];
        $content = "Ta fiche<a href='index.php?page=sheet&id=" . $sheet['id'] . "'>" . $sheet['title'] . "</a> a été signalé. Après plusieurs signalements, tu risques le banissement";
    } elseif ($report['tableReferences'] == 'quizz') {
        $quiz = getQuizById($report['idReferences']);
        $user = $quiz['auteur'];
        $content = "Ta fiche<a href='index.php?page=sheet&id=" . $quiz['id'] . "'>" . $quiz['title'] . "</a> a été signalé. Après plusieurs signalements, tu risques le banissement";
    } else
        $user = false;

    if ($user) {
        newNotification($content, $user);
        greenAlert('L\'avertissement a correctement été envoyé');
    }
}
function reportBan($idReport){
    $report = getReportById($idReport);
    if ($report['tableReferences'] == 'comments') {
        $comment = getCommentById($report['idReferences']);
        $user = $comment['idAuthor'];
    } elseif ($report['tableReferences'] == 'sheets') {
        $sheet = getSheetById($report['idReferences']);
        $user = $sheet['author'];
    } elseif ($report['tableReferences'] == 'quizz') {
        $quiz = getQuizById($report['idReferences']);
        $user = $quiz['auteur'];
    } else
        $user = false;

    if ($user) {
        modifyUser('type', 'banned', $user);
        greenAlert('L\'utilisateur a été banni');
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'sheetActivation' && isset($_GET['id']) && $_GET['id'] > 0 && getSheetInfo('active', $_GET['id']) == 0){
    require_once('view/users/sheetActivation.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'sheetsModif'){
    require_once('view/users/sheetsModif.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'clearTableSheets'){
    clearTableSheets();
    require_once('view/users/sheetsModif.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'usersModif'){
    require_once('view/users/userModif.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'modify' && isset($_POST['pseudo'])){
    modify();
    require_once('view/users/userModif.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'clearTableUser'){
    clearTableUsers();
    require_once('view/users/userModif.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'addUser'){
    createUser($_POST['pseudo'],sha1($_POST['pwd']), $_POST['email'], $_POST['type']);
    require_once('view/users/userModif.php');
}
elseif(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']== 'deleteUser') {
    deleteUser($_GET['id']);
    require_once('view/users/userModif.php');
}
elseif(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']== 'undeleteUser') {
    undeleteUser($_GET['id']);
    require_once('view/users/userModif.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'resetViews'){
    resetViews();
    require_once ('view/users/admin.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'mail'){
    require_once ('view/users/mail.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'sendMail' && isset($_POST['object']) && isset($_POST['dest']) && isset($_POST['message'])){
    if(isset($_POST['sendToAll']) && $_POST['sendToAll'] == true)
        sendMailToAll();
    else
        mail($_POST['dest'], $_POST['object'], $_POST['message']);
    greenAlert('L\'email a été correctement envoyé');
    require_once ('view/users/mail.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'reports'){
    require_once ('view/users/reports.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'reportAlert' && isset($_GET['id']) && $_GET['id'] > 0){
    reportAlert($_GET['id']);
    require_once ('view/users/reports.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'reportBan' && isset($_GET['id']) && $_GET['id'] > 0){
    reportBan($_GET['id']);
    require_once ('view/users/reports.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'reportDelete' && isset($_GET['id']) && $_GET['id'] > 0){
    setInactiveReport($_GET['id']);
    require_once ('view/users/reports.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'quizModif'){
    require_once('view/users/quizModif.php');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'quizActivation' && isset($_GET['id']) && $_GET['id'] > 0 && getQuizInfo('active', $_GET['id']) == 0){
    require_once('view/quiz/Quiz.php');
}
elseif (isset($_GET['action']) && $_GET['action'] == 'quizModification' && isset($_GET['id']) && $_GET['id'] > 0 && getModif($_GET['id'])>0) {
    require_once('view/quiz/Quiz.php');
}
else {
    require_once('view/users/admin.php');
}
