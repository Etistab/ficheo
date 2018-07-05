<?php
require_once ("model/db_connect.php");

function getNotifications($user, $active = true){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM notifications WHERE user = :user AND active = :active');
    $req->execute(array(
        "user" => $user,
        "active" => $active
    ));
    $notifs = $req->fetchAll();

    return $notifs;
}

function getNotifInfo($column, $id){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM notifications WHERE id = :id');
    $req->execute(array("id" => $id));
    $notif = $req->fetch();

    return $notif[$column];
}

function newNotification($content, $user){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO notifications(content, user, date, active) VALUES(:content, :user, NOW(), 1)');
    $req->execute(array(
        "content" => $content,
        "user" => $user
    ));
}

function desactNotif($id){
    $db = dbConnect();
    $req = $db->prepare('UPDATE notifications SET active = 0 WHERE id = :id');
    $req->execute(array("id" => $id));
}