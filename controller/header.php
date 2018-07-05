<?php
require_once('model/users.php');
require_once ('model/report.php');
require_once ('model/notifications.php');

function greenAlert($message){?>
    <div class="alert alert-success alert-dismissable" style="position: absolute  ; z-index :2; width:100%;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p class="text-center" style="margin : 0;">
            <?= $message ?>
        </p>
    </div>
    <?php
}
function redAlert($message){?>
    <div class="alert alert-danger alert-dismissable" style="position: absolute  ; z-index :2; width:100%;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p class="text-center" style="margin : 0;">
            <?= $message ?>
        </p>
    </div>
    <?php
}
function orangeAlert($message){?>
    <div class="alert alert-warning alert-dismissable" style="position: absolute  ; z-index :2; width:100%;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p class="text-center" style="margin : 0;">
            <?= $message ?>
        </p>
    </div>
    <?php
}
function isPage(){
    if(isset($_GET['page']))
        echo 'page='.$_GET['page'].'&';
    if(isset($_GET['id']))
        echo 'id='.$_GET['id'].'&';
}

function connexion()
{
    $user = getUser($_POST['pseudo']);
    if(!isset($user['pseudo'])){
        redAlert('Cet utilisateur n\'existe pas');
    }
    elseif($user['password'] != sha1($_POST['password'])){
        redAlert('Le mot de passe est incorrect');
    }
    elseif($user['active'] == false){
        orangeAlert('Le  compte '.$user['pseudo'].' est désactivé');
    }
    elseif($user['type'] == 'banned'){
        redAlert('Ce compte a été banni');
    }
    elseif ($user['isDeleted'] == 1) {
        redAlert('Ce compte a été supprimé');
    }
    elseif($user['pseudo'] == $_POST['pseudo'] && $user['password'] == sha1($_POST['password']) AND $user['active'] == true){
        greenAlert('Bonjour '.$_POST['pseudo'].' tu t\'es connecté avec succès !');

        $_SESSION['id'] = $user['id'];
        $_SESSION['pseudo'] = $_POST['pseudo'];
        $_SESSION['type'] = $user['type'];

        setLastConnection($_SESSION['pseudo']);
    }
    else{
        redAlert('Erreur');
    }
}
function inscription()
{
    $user = getUser($_POST['pseudo']);
    if(isset($user['pseudo']) && $user['pseudo'] == $_POST['pseudo']){
        redAlert('Ce pseudo est déjà utilisé');
    }
    elseif(isset($user['email']) && $user['email'] == $_POST['email']){
        redAlert('Cette adresse email est déjà utilisée');
    }
    elseif($_POST['password'] != $_POST['confirm_password']){
        redAlert('La confirmation du mot de passe n\'est pas correcte');
    }
    elseif($_POST['pseudo'] < 12 && $_POST['password'] < 12){
        $affectedLines = createUser(htmlspecialchars($_POST['pseudo']), sha1($_POST['password']), htmlspecialchars($_POST['email']));
        if($affectedLines == false){
            redAlert('Erreur: L\'utilisateur n\'a pas pu être ajouté');
        }
        else {
            greenAlert('Vous avez été inscris ! Un email vous a été envoyé afin d\'activer votre compte');
            sendInscriptionMail($_POST['email'], $_POST['pseudo'], $_POST['password']);
        }
    }
    else{
        redAlert('Erreur');
    }
}
function sendInscriptionMail($dest, $pseudo, $password){
    $id = getUserInfo('id', $pseudo);
    $hashId = sha1($id);
    $message = "Bienvenue sur Ficheo !\n
                Merci de t'être inscris $pseudo et de nous faire confiance. Conserve ce mail pour ne pas oublier tes identifiants !\n
                Pseudo: $pseudo\n
                Mot de passe: $password\n\n
                Plus qu'une étape avant de pouvoir profiter pleinement des fonctionnalités de Ficheo !\n
                Clique sur ce lien pour activer ton compte: http://localhost/projet_annuel/index.php?activation=$hashId";
    mail($dest, 'Bienvenue sur Ficheo !', $message);
}
function forgetPassword($email){
    $users = getUsers();
    $check = false;
    foreach ($users as $user){
        if($user['email'] == $email && $user['isDeleted'] == 0){
            $password = createRandomString(8);
            $message = "Ton nouveau mot de passe Ficheo !\n
                        Voici ton nouveau mot de passe pour te connecter a nouveau sur Ficheo ! :) Tu pourras le modifier dans ton espace membre si tu le souhaite\n
                        Pseudo: ".$user['pseudo']."\n
                        Mot de passe: $password\n

                        A bientôt !";
            mail($_POST['email'], 'Nouveau mot de passe Ficheo', $message);
            modifyUser('password', sha1($password), $user['id']);
            greenAlert('Un email t\'a été envoyé avec un nouveau mot de passe ! :)');
            $check = true;
        }
    }
    if(!$check)
        redAlert('Cette adresse email n\'existe pas ou ton compte a été supprimé');
}

function createRandomString($size){
    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPKRSTUVWXYZ0123456789';
    $char = str_shuffle($char);
    $result = substr($char, 0, $size);
    return $result;
}

function report($content){
    $affectedLines = false;
    if(isset($_GET['page']) && $_GET['page'] == 'sheet' || $_GET['page'] == 'quiz'){
        if(isset($_GET['comment']) && $_GET['comment'] > 0)
            $affectedLines = newReport($content, 'comments', $_GET['comment'], $_SESSION['id']);
        elseif($_GET['page'] == 'sheet' && $_GET['id'] > 0)
            $affectedLines = newReport($content, 'sheets', $_GET['id'], $_SESSION['id']);
        elseif($_GET['page'] == 'quiz' && $_GET['id'] > 0)
            $affectedLines = newReport($content, 'quizz', $_GET['id'], $_SESSION['id']);
    }
    if ($affectedLines == false)
        redAlert('Erreur: Le signalement n\'a pas été enregistré');
    else
        greenAlert('Le signalement a bien été enregistré');
}

function messagesHeader(){
    if(isset($_GET['action'])){
        if($_GET['action'] == 'connexion' && isset($_POST['pseudo']) && isset($_POST['password']))
            connexion();
        elseif ($_GET['action'] == 'inscription' && isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['email']))
            inscription();
        elseif ($_GET['action'] == 'forgetPassword' && isset($_POST['email']))
            forgetPassword($_POST['email']);
        elseif($_GET['action'] == 'report' && isset($_POST['content']))
            report($_POST['content']);
        elseif(isset($_GET['page'])) {
            if(isset($_GET['section'])) {
                if ($_GET['page'] == 'user' && $_GET['section'] == 'admin' && $_SESSION['type'] == 'admin' && ($_GET['action'] == 'desactSheet' || $_GET['action'] == 'deleteSheet' || $_GET['action'] == 'activeSheet'))
                    messageSheetModification();
                elseif ($_GET['page'] == 'user' && $_GET['section'] == 'admin' && $_SESSION['type'] == 'admin' && ($_GET['action'] == 'desactQuiz' || $_GET['action'] == 'deleteQuiz' || $_GET['action'] == 'activeQuiz'))
                   messageQuizModification();
               elseif ($_GET['page'] == 'user' && $_GET['section'] == 'admin' && $_SESSION['type'] == 'admin' && ($_GET['action'] == 'modifOkQuiz' || $_GET['action'] == 'modifNotOkQuiz'))
                   messageQuizModification();
                elseif ($_GET['page'] == 'user' && $_GET['section'] == 'param' && $_GET['action'] == 'changeParam')
                    changeUserParam();
            }
        }
    }
}

function getGravatar($user, $s = 60, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $email = getUserInfo('email', $user);
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function numberOfNotifications($user){
    $notifs = getNotifications($user);
    if($notifs == false) return 0;
    else {
        $size = sizeof($notifs);
        if($size < 100) return $size;
        else return "99+";
    }
}

function calcXpForNextLevel($experience, $level = false){
    $result = 150;

    for($i = 1; $result <= $experience; $i++) {
        $result += $result * 1.2;
    }

    if($level){
        return $i;
    }
    return round($result);
}

function convertLevelToXp($level) {
    $result = 150;

    for($i = 1; $i < $level; $i++) {
        $result += $result * 1.2;
    }

    return $result;
}

function convertXpToPercent($experience) {
    $a = $experience - convertLevelToXp(calcXpForNextLevel(getUserInfo('experience'), true) - 1);
    $b = calcXpForNextLevel($experience) - convertLevelToXp(calcXpForNextLevel(getUserInfo('experience'), true) - 1);

    if(calcXpForNextLevel(getUserInfo('experience'), true) == 1) return round($experience/150 *100, 2);

    return round($a/$b*100, 2);
}

// +1 page vue dans les log
$viewsLog = fopen('public/logs/views.log', 'r+');

$viewsNumber = fgets($viewsLog);
$viewsNumber += 1;
fseek($viewsLog, 0);
fputs($viewsLog, $viewsNumber);

fclose($viewsLog);
