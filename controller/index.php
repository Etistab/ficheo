<?php
require_once('model/sheets.php');
require_once('controller/header.php');

function printLastSheet($category, $url = false){
    $sheet = getLastSheet($category);

    if($url) {
        if ($sheet == false) {
            echo 'index.php?page=createSheet';
        }
        else{
            echo 'index.php?page=sheet&id=' . $sheet['id'];
        }
    }
    else {
        if ($sheet == false) {
            echo 'Il n\'y a pas encore de fiche niveau ' . $category . ' en ligne, <a href="index.php?page=createSheet">écris la premiere</a> ! :)';
        } else {
            echo $sheet['title'] . ' écrit par <a  href="index.php?page=user&user=' . $sheet['author'] . '">' . $sheet['author'] . '</a> le ' . $sheet['date_creation'] . '<br/>';
            echo '<a href="index.php?page=sheet&id=' . $sheet['id'] .'" class="lastSheet">' . $sheet['content'] . '</a>';
        }
    }
}

if(isset($_GET['activation'])){
    $users = getUsers();
    foreach ($users as $user){
        if(sha1($user['id']) == $_GET['activation'])
            modifyUser('active', 1, $user['id']);
            greenAlert('Ton compte a été correctement activé ! Tu peux désormais te connecter');
    }
}

require_once('view/index.php');
