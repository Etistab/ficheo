<?php
require_once('model/sheets.php');
require_once('model/users.php');
require_once('model/mark.php');
require_once('model/comment.php');
require_once('controller/header.php');

function checkMarkForm($idUser,$sheet){
    if(isset($_SESSION['pseudo']) && !checkMarkByUser($idUser,$sheet) ) {
        printMarkForm();
    }
    else{
        echo '<p>Vous avez deja voté, merci :)</p>';
    }
}

function printMarkForm(){
    echo '<form method="POST" action="index.php?page=sheet&action=addMark&id='.$_GET["id"].'">
               <select name="mark">
                   <option value="1">1★</option>
                   <option value="2">2★</option>
                   <option value="3">3★</option>
                   <option value="4">4★</option>
                   <option value="5">5★</option>
               </select>
               <input type="submit" value="Noter">
           </form>';
}
function printCommentForm1(){
        echo '
               <form method="POST" action="index.php?page=sheet&action=addComment&id='.$_GET['id'].'">
                    <div class="form-group">
                        <label> COMMENTAIRES </label>
                        <br>
                        <textarea class="form-control ckeditor" name="comment" rows="5" placeholder="Ecrire vore commentaire ici"></textarea>
                        <br>
                        <input type="submit">
                    </div>
                </form>
        ';
}

function printCommentForm2(){
     echo '
                    <div class="form-group">
                        <label> COMMENTAIRES </label>
                        <br>
                        <textarea class="form-control ckeditor" name="comment" rows="5" placeholder="Connectez-vous pour laisser un commentaire"></textarea>
                        <br>
                        <button onclick="alert_comment()">Valider</button>
                    </div>

        ';
}

function getAverageByComment($comment){
    $marks = getMarksByCom($comment);

    $cpt = 0;
    $res = 0;

    if (!$marks) {
        $res = 0;
    }
    else{
        foreach ($marks as $mark) {
            $res = $res + $mark['mark'];
            $cpt++;
        }
        $res =  $res/$cpt;
    }

    return round($res, 2, PHP_ROUND_HALF_UP);
}

function getAverageBySheet($sheet){
    $marks = getMarksBySheet($sheet);

    $cpt = 0;
    $res = 0;

    if (!$marks) {
        $res = 0;
    }
    else{
        foreach ($marks as $mark) {
            $res = $res + $mark['mark'];
            $cpt++;
        }
        $res =  $res/$cpt;
    }

    return round($res, 2, PHP_ROUND_HALF_UP);
}

function printAverage($sheet){
    $average = getAverageBySheet($sheet);

    for($i = 0; $i < 5; $i++){
        if($i < $average) {
            echo '<span class="fa fa-star checked"></span>';
        }
        else echo '<span class="fa fa-star"></span>';
    }
}

function printAverageCom($comment){
    $average = getAverageByComment($comment);

    for($i = 0; $i < 5; $i++){
        if($i < $average) {
            echo '<span class="fa fa-star checked"></span>';
        }
        else echo '<span class="fa fa-star"></span>';
    }
}

function printComments($sheet){
    $comments = getCommentsBySheet($sheet);
    $numberNote;
    foreach ($comments as  $comment) {
        $numberNote = getNoteComment($comment['id']);
      $avg = getCommentAvg($comment['id'])[0];
        if (empty($avg)) {
          $avg=0;
        }
        echo "<div name='commentaire' class=\"media border p-3\">";

        echo '<a href="index.php?page=user&user='.$comment['author'].'"><img src="'.getGravatar($comment['author']).'" alt="Photo de profil" class="mr-3 mt-3 rounded-circle"></a>
            <div class="media-body">
                <a href="index.php?page=user&user='.$comment['author'].'"><strong>'.$comment['author'].'</strong></a> <span class="badge badge-pill badge-secondary">'.calcXpForNextLevel(getUserInfo('experience', $comment['author']), true).'</span> a dit le '.$comment['dateCom'].' :';
        echo "<br>";
        echo"<p class='secret' name='avg'>".$avg."</p>";
        echo"<p class='secret' name='date'>".$comment['dateCom']."</p>";
        if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin'){
            echo ' <button type="button" class="btn btn-danger" onclick=\'alert_delete("index.php?page=sheet&action=deleteComment&id='.$comment['id'].'")\'>supprimer</span>';
        }
        echo '
              <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#reportComment'.$comment['id'].'" style="margin-left : 10px;">
                Signaler
              </button>
                        ';
            printAverageCom($comment['id']);
            echo " Nombre de votes : ".$numberNote;
        if (isset($_SESSION['pseudo']) && !checkMarkCommentByUser($_SESSION['id'],$comment['id']))  {
            echo "
            <form style='display: inline-block' method='POST' action='index.php?page=sheet&action=markComment&id=".$_GET['id']."&idComment=".$comment['id']."'>
                <select name='mark'>
                   <option value='1'>1★</option>
                   <option value='2'>2★</option>
                   <option value='3'>3★</option>
                   <option value='4'>4★</option>
                   <option value='5'>5★</option>
               </select>
               <input type='submit' value='Noter'>
            </form>
        ";
        }elseif(isset($_SESSION['id']) && checkMarkCommentByUser($_SESSION['id'],$comment['id'])) {
            echo "<p><i>Vous avez déja noté ce commentaire, merci :) !</i></p>";
        }elseif (!isset($_SESSION['id']) ) {
            echo "<p><i>Connectez-vous pour laisser une note :) !</i></p>";
        }
        else{
            echo "<br>";
        }
        echo $comment['content'];
        echo'</div></div>';
        echo "<br><br>";
    }
}

if (isset($_GET['page']) && $_GET['page'] == 'sheet' && isset($_GET['action']) && $_GET['action'] == 'addMark' && isset($_POST['mark'])) {
    if(checkMarkByUser($_SESSION['id'], $_GET['id']) == false){
        addMark($_POST['mark'], $_GET['id'], $_SESSION['id']);
        addExperience($_SESSION['id'], 5);
        $user = getSheetInfo('author', $_GET['id']);
        $content = '<a href="index.php?page=user&id='.$_SESSION['pseudo'].'">'.$_SESSION['pseudo'].'</a> a donné une note de '.$_POST['mark'].'/5 à ta fiche <a href="index.php?page=sheet&id='.$_GET['id'].'">'.getSheetInfo('title', $_GET['id']).'</a> !';
        newNotification($content, $user);
        greenAlert('Ta note a bien été prise en compte ! merci !');
    }
}
elseif (isset($_GET['page']) && $_GET['page'] == 'sheet' && isset($_GET['action']) && $_GET['action'] == 'addComment' && isset($_POST['comment'])) {
    addComment($_POST['comment'], $_SESSION['id'], $_GET['id']);
    addExperience($_SESSION['id'], 10);
    $user = getSheetInfo('author', $_GET['id']);
    $content = '<a href="index.php?page=user&id='.$_SESSION['pseudo'].'">'.$_SESSION['pseudo'].'</a> a commenté ta fiche <a href="index.php?page=sheet&id='.$_GET['id'].'">'.getSheetInfo('title', $_GET['id']).'</a> !';
    newNotification($content, $user);
    greenAlert('Ton commentaire a bien été envoyé ! merci !');
}
elseif (isset($_GET['page']) && $_GET['page'] == 'sheet' && isset($_GET['action']) && $_GET['action'] == 'markComment' && isset($_GET['idComment']) && $_GET['idComment'] > 0) {
    addMarkComment($_POST['mark'], $_GET['idComment'], $_SESSION['id']);
    addExperience($_SESSION['id'], 5);
    $user = getCommentById($_GET['idComment'])['idAuthor'];
    $content = '<a href="index.php?page=user&id='.$_SESSION['pseudo'].'">'.$_SESSION['pseudo'].'</a> a donné une note de '.$_POST['mark'].'/5 à ton commentaire sur la fiche <a href="index.php?page=sheet&id='.$_GET['id'].'">'.getSheetInfo('title', $_GET['id']).'</a> !';
    newNotification($content, $user);
    greenAlert('Ta note a bien été prise en compte ! Merci !');
}
elseif (isset($_GET['page']) && $_GET['page'] == 'sheet' && isset($_GET['action']) && $_GET['action'] == 'deleteComment' && isset($_GET['id']) && $_GET['id'] > 0) {
    deleteComment($_GET['id']);
    greenAlert('Le commentaire a été supprimé');
}

require_once ('view/sheets/sheet.php');
