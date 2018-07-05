<?php
require_once ('model/users.php');
require_once ('controller/header.php');

function changeUserParam(){
    if(!empty($_POST['pseudo']) && $_POST['pseudo'] != $_SESSION['pseudo']){
        $user = getUser($_POST['pseudo']);
        if(isset($user) && !empty($user)){
            redAlert("Ce pseudo est déjà utilisé");
        }
        else{
            modifyUser('pseudo', $_POST['pseudo'], $_SESSION['id']);
            $_SESSION['pseudo'] = $_POST['pseudo'];
            greenAlert("Ton pseudo a bien été modifié");
        }
    }
    if(!empty($_POST['oldPwd']) && !empty($_POST['newPwd']) && !empty($_POST['confirmPwd'])){
        $user = getUser($_SESSION['pseudo']);
        if($_POST['newPwd'] != $_POST['confirmPwd']){
            redAlert("La confirmation du mot de passe est incorrecte");
        }
        elseif($user['password'] != sha1($_POST['oldPwd'])){
            redAlert("Ton ancien mot de passe est incorrect");
        }
        else{
            modifyUser('password', sha1($_POST['newPwd']), $_SESSION['id']);
            greenAlert("Ton mot de passe a bien été modifié");
        }
    }
    if(!isset($_POST['newsletter'])){
        modifyUser('newsletter', 0, $_SESSION['id']);
    }
    if(isset($_POST['newsletter']) && $_POST['newsletter'] == true){
        modifyUser('newsletter', 1, $_SESSION['id']);
    }
}

function isChecked($column){
    $user = getUser($_SESSION['pseudo']);
    if($user[$column] == true){
        return 'checked';
    }
    else{
        return '';
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'deleteAccount'){
    deleteUser($_SESSION['id']);
    session_destroy();
    header("Location: index.php");
}

require_once ('view/users/param.php');