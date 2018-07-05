<?php
require_once ('model/db_connect.php');

function getActiveReports($active = true){
    $db = dbConnect();

    $req = $db->prepare('SELECT * FROM reports WHERE active = :active');
    $req->execute(array(
        "active" => $active
    ));
    $reports = $req->fetchAll();

    return $reports;
}
function getReportById($id){
    $db = dbConnect();

    $req = $db->prepare('SELECT * FROM reports WHERE id = :id');
    $req->execute(array(
        "id" => $id
    ));
    $report = $req->fetch();

    return $report;
}

function setInactiveReport($id){
    $db = dbConnect();

    $req = $db->prepare('UPDATE reports SET active = 0 WHERE id = :id');
    $req->execute(array(
        "id" => $id
    ));
}

function newReport($content, $tableReferences, $idReferences, $user){
    $db = dbConnect();

    $req = $db->prepare('INSERT INTO reports(author, date, tableReferences, idReferences, content, active) VALUES(:user, NOW(), :tableReferences, :idReferences, :content, 1)');
    $req->execute(array(
        "user" => $user,
        "tableReferences" => $tableReferences,
        "idReferences" => $idReferences,
        "content" => $content
    ));
    $affectedLines = $req->rowCount();

    return $affectedLines;
}