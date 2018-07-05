<?php
require_once ("model/db_connect.php");

function getInactiveSheets($active = false){
    $db = dbConnect();
    $inactiveCards = $db->prepare('SELECT sheets.id AS id, sheets.title AS title, sheets.active AS active, sheets.date_creation AS date_creation, users.pseudo AS author, sheets.category AS category, sheets.active AS active, sheets.discipline FROM users, sheets WHERE sheets.author = users.id AND sheets.active = ? ORDER BY sheets.date_creation DESC');
    $inactiveCards->execute(array($active));

    return $inactiveCards;
}

function getSheets(){
    $db = dbConnect();
    $sheets = $db->query('SELECT sheets.id AS id, sheets.title AS title, sheets.active AS active, sheets.date_creation AS date_creation, users.pseudo AS author, sheets.category AS category, sheets.discipline AS discipline, users.id AS author_id FROM users, sheets WHERE sheets.author = users.id ORDER BY sheets.date_creation DESC');

    return $sheets;
}

function getSheetInfo($column, $id){
    $sheet = getSheetById($id);
    if ($sheet == false) {
        return 'Erreur';
    }
    else {
        return $sheet[$column];
    }
}

function getActivatedSheetsByCategory($category){
    $db = dbConnect();
    $sheets = $db->prepare('SELECT sheets.id AS id, sheets.title AS title, sheets.date_creation AS date_creation, users.pseudo AS author, sheets.category AS category, sheets.active AS active, sheets.discipline FROM users, sheets WHERE sheets.active = 1 AND sheets.category = ? AND sheets.author = users.id');
    $sheets->execute(array($category));

    return $sheets;
}

function getLastSheet($category){
    $db = dbConnect();
    $req = $db->prepare('SELECT sheets.id AS id, sheets.title AS title, sheets.content AS content, sheets.date_creation AS date_creation, users.pseudo AS author FROM users, sheets WHERE sheets.category = ? AND sheets.date_creation = (SELECT MAX(date_creation) FROM sheets WHERE category = ? AND active = 1) AND sheets.active = 1 AND sheets.author = users.id');
    $req->execute(array($category, $category));
    $sheet = $req->fetch();

    return $sheet;
}

function getLastSheetById($id){
    $db = dbConnect();
    $req = $db->prepare('SELECT sheets.id AS id, sheets.title AS title, sheets.content AS content, sheets.date_creation AS date_creation FROM users, sheets WHERE sheets.date_creation = (SELECT MAX(date_creation) FROM sheets WHERE author = ? AND active = 1) AND sheets.active = 1 AND sheets.author = users.id');
    $req->execute(array($id));
    $sheet = $req->fetch();

    return $sheet;
}

function sheetActivation($id, $active = true){
    $db = dbConnect();
    $req = $db->prepare('UPDATE sheets SET active = :active WHERE id = :id');
    $req->execute(array(
        "active" => $active,
        "id" => $id
    ));
    $affectedLines = $req->rowCount();

    return $affectedLines;
}

function sheetDeleting($id){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM sheets WHERE id = ?');
    $req->execute(array($id));
    $affectedLines = $req->rowCount();

    return $affectedLines;
}

function getSheetById($id){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM sheets WHERE id = ?');
    $req->execute(array($id));
    $sheet = $req->fetch();

    return $sheet;
}

function createSheet($title, $content, $idAuthor, $category, $discipline){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO sheets(title, content, active, author, category, discipline, date_creation) VALUES (:title, :content, 0, :author, :category, :discipline, NOW())' );
    $affectedLines = $req->execute(array(
        'title'=>$title,
        'content'=>$content,
        'author'=>$idAuthor,
        'category'=>$category,
        'discipline'=>$discipline

    ));
    return $affectedLines;

}

function createSheet2($title, $content, $idAuthor, $category, $discipline, $support){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO sheets(title, content, active, author, category, discipline, date_creation, support) VALUES (:title, :content, 0, :author, :category, :discipline, NOW(), :support)' );
    $affectedLines = $req->execute(array(
        'title'=>$title,
        'content'=>$content,
        'author'=>$idAuthor,
        'category'=>$category,
        'discipline'=>$discipline,
        'support'=>$support

    ));
    return $affectedLines;

}

function getNoteSheet($idSheet){
    $db = dbConnect();
    $req=$db->prepare('SELECT mark from marks where sheet=:id');
    $req->execute(array(
        'id'=>$idSheet
    ));
    $marks=$req->fetchall();

    return $marks;
}

function countNoteBySheet($idSheet){
    $marks = getNoteSheet($idSheet);
    $count = 0;
    if(!$marks) {
        $count = 0;
    }elseif($marks) {
      foreach ($marks as $mark) {
            $count++;
        }  
    }
    return $count;
}



function clearTableSheets(){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM sheets');
    $req-> execute();
}
