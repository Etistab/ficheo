<?php
session_start();
try {
    if (isset($_GET['page'])) {
        //  ESPACE MEMBRE
        if ($_GET['page'] == 'user') {
            if (isset($_GET['section']) && !empty($_SESSION['pseudo'])) {
                if ($_GET['section'] == 'admin' && $_SESSION['type'] == 'admin') {
                    require('controller/users/admin.php');
                }
                elseif ($_GET['section'] == 'param') {
                    require('controller/users/param.php');
                }
                elseif($_GET['section'] == 'notifs'){
                    require('controller/users/notification.php');
                }
                else throw new Exception('404 la page demandé n\'existe pas :/');
            } else {
                require('controller/users/profil.php');
            }
        }
        // PARTIE FICHES
        elseif ($_GET['page'] == 'sheet' && isset($_GET['id']) && $_GET['id'] > 0) {
            require('controller/sheets/sheet.php');
        }
        elseif ($_GET['page'] == 'sheetsMenu') {
            require('controller/sheets/sheetsMenu.php');
        }
        elseif($_GET['page'] == 'createSheet') {
            if(!empty($_SESSION['pseudo'])) require('controller/sheets/createSheet.php');
            else throw new Exception('Tu dois être connecté pour créer une fiche');
        }
        // PARTIE QUIZZ
        elseif($_GET['page'] == 'createQuiz') {
            if(!empty($_SESSION['pseudo'])) require('controller/quiz/createQuiz.php');
            else throw new Exception('Tu dois être connecté pour créer un quiz');
        }
        elseif($_GET['page'] == 'modifQuiz' && isset($_GET['id']) && $_GET['id'] > 0 ) {
            if(!empty($_SESSION['pseudo'])) require('controller/quiz/createQuiz.php');
            else throw new Exception('Tu dois être connecté pour créer un quiz');
        }
        elseif ($_GET['page'] == 'quizMenu') {
            require('controller/quiz/quizMenu.php');
        }
        elseif ($_GET['page'] == 'quiz') {
            require('controller/quiz/quiz.php');
        }
        //  DECONNEXION
        elseif ($_GET['page'] == 'disconnect') {
            session_destroy();
            header("Location:index.php");
        }
        else throw new Exception('404 la page demandé n\'existe pas :/');
    } else {
        require('controller/index.php');
    }
}
catch (Exception $e){
    echo 'Erreur : '. $e->getMessage();
}
