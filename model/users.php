<?php
require_once ("model/db_connect.php");

function getUser($pseudo)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM users WHERE pseudo = ?');
    $req->execute(array($pseudo));
    $user = $req->fetch();

    return $user;
}

function getUserById($id){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM users WHERE id = :id');
    $req->execute(array(
        'id'=>$id
    ));
    $user = $req->fetch();

    return $user;
}

function getUserInfo($column, $pseudo = -1){
    if(!empty($_SESSION['pseudo']) && $pseudo === -1) {
        $pseudo = $_SESSION['pseudo'];
    }

    $user = getUser($pseudo);

    return $user[$column];
}

function getUsers(){

    $db = dbConnect();
    $query = $db->prepare('SELECT * FROM users');
    $query->execute();
    $users = $query->fetchall();

    return $users;
}


function createUser($pseudo, $password, $email, $type = 'member', $newsletter = 1)
{
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO users(pseudo, password, email, active, type, date, newsletter, experience, reports) VALUES(:pseudo, :password, :email, 0, :type, NOW(), :newsletter, 0, 0)'); // SET "active" a 0 quand la verif mail sera faite
    $affectedLines = $req->execute(array(
        'pseudo' => $pseudo,
        'password' => $password,
        'email' => $email,
        'type' => $type,
        'newsletter' => $newsletter
    ));

    return $affectedLines;
}

function setLastConnection($pseudo){
    $db = dbConnect();

    $request = $db->prepare("UPDATE users SET lastConnection=NOW() WHERE pseudo=:pseudo");
    $request->execute(array(
        "pseudo" => $pseudo
    ));
}

function modifyUser($column, $value, $id){
    $db = dbConnect();

    $request = $db->prepare("UPDATE users SET ".$column."=:value WHERE id=:id");
    $request->execute(array(
        "value" => $value,
        "id" => $id
    ));
}

function addExperience($id, $experience){
    $db = dbConnect();

    $req = $db->prepare("UPDATE users SET experience = experience + :experience WHERE id = :id");
    $req->execute(array(
        "experience" => $experience,
        "id" => $id
    ));
}

function deleteUser($id){
    $db = dbConnect ();
    $req = $db->prepare("UPDATE users SET isDeleted = 1 WHERE id=:id");
    $req->execute(["id"=> $id] );
    $affectedLines =  $req->rowCount();
    
    return $affectedLines;
}

function undeleteUser($id){
    $db = dbConnect ();
    $req = $db->prepare("UPDATE users SET isDeleted = 0 WHERE id=:id");
    $req->execute(["id"=> $id] );
    $affectedLines =  $req->rowCount();
    
    return $affectedLines;
}

function clearTableUsers(){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM users');
    $req-> execute();
}