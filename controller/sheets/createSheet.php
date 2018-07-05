<?php
require_once('model/sheets.php');
require_once ('controller/header.php');

function uploadSheet(){
    if ($_FILES['supp']['error'] == 4) {
        createSheet(htmlspecialchars($_POST['title']), $_POST['content'], $_SESSION['id'], htmlspecialchars($_POST['category']), htmlspecialchars($_POST['discipline']));
        greenAlert('Ta fiche a été mise en attente de validation ! Merci pour ta contribution :).');
    }else if ($_FILES['supp']['error'] == 0) {

        $error = false;
        $listOfErrors = array(
            'Seul les .pdf, .docx et .odt sont autorisés',
            'Le fichier est trop volumineux'
        );
        $validExt = array(
            'pdf',
            'odt',
            'docx',
            'ppt'
        );
        $validSize = "5000000";
        $fileSize = $_FILES['supp']['size'];
        $file = $_FILES['supp']['name'];
        $fileInfo = pathinfo($file);
        $fileExt = $fileInfo['extension'];
        $newName = uniqid().'.'.$fileExt;
        $link = $_FILES['supp']['tmp_name'];
        $path = 'public/supports/'.$newName;

        while (file_exists($path)) {
            $newName = uniqid().'.'.$fileExt;
        }

        if ($validSize < $fileSize) {
            $error = true;
            redAlert($listOfErrors[1]);
        }

        if (!in_array($fileExt, $validExt) ) {
            $error = true;
            redAlert($listOfErrors[0]);
        }

        if (!$error) {
            move_uploaded_file($link,$path);
            createSheet2(htmlspecialchars($_POST['title']), $_POST['content'], $_SESSION['id'], htmlspecialchars($_POST['category']), htmlspecialchars($_POST['discipline']), $newName);
            greenAlert('Ta fiche a été mise en attente de validation ! Merci pour ta contribution :).');
        }
    }
}

if (isset($_GET['page']) && $_GET['page'] == 'createSheet' && isset($_GET['action']) && $_GET['action'] == 'createSheet'){
	if(empty($_POST['title'])) {
		redalert('Le titre est vide');
		require_once('view/sheets/createSheet.php');
	}elseif(empty($_POST['content'])) {
		redalert('Le contenu est vide');
		require_once('view/sheets/createSheet.php');
	}elseif (empty($_POST['category'])) {
		redalert("vous n'avez pas choisi de catégorie");
		require_once('view/sheets/createSheet.php');
	}else{
		uploadSheet();
		addExperience($_SESSION['id'], 20);
		require_once('view/sheets/createSheet.php');
	}
}

else{
	require_once('view/sheets/createSheet.php');
}