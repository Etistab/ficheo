<?php
require_once ('model/users.php');
require_once ('model/sheets.php');
require_once('controller/header.php');

function printLastSheetByPseudo($id){
    $sheet = getLastSheetById($id);
    if($sheet == false){
        echo 'Tu n\'as pas encore écris de fiche, il est temps <a href="index.php?page=createSheet">d\'écrire ta premiere !</a> :)';
    }
    else {
        echo '<a href="index.php?page=sheet&id='.$sheet['id'].'">'.$sheet['title'].'</a> posté le '.$sheet['date_creation'].'<br/>';
    }
}


   if(isset($_GET['user']) && getUser($_GET['user']) != false) {
        require_once("view/users/profil.php");
   }
   elseif(!empty($_SESSION['pseudo'])) {
       require_once("view/users/myProfil.php");
   }
   else throw new Exception('Tu dois être connecté pour acceder a l\'espace membre');

