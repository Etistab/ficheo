<?php
require_once ('model/notifications.php');
require_once ('controller/header.php');

function printNotifications($user){
    $notifs = getNotifications($user);

    if($notifs == false) echo 'Tu n\'as pas de notification :)';
    else {
      foreach ($notifs as $notif) {
          echo "<li class='list-group-item list-group-item-secondary'>".$notif['content'] . ' le ' . $notif['date'];
          echo "<a style='float:right;' onclick=\"sendAjaxRequest('index.php?page=user&section=notifs&action=deleteNotif&id=".$notif['id']."')\"><button type='button' class='btn btn-primary btn'>Marquer comme lu</button></a><br/></li>";
      }
    }
}

function desactAllNotifs($user){
    $notifs = getNotifications($user);
    if($notifs != false){
        foreach ($notifs as $notif) {
            desactNotif($notif['id']);
        }
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'deleteNotif' && isset($_GET['id']) && $_GET['id'] > 0 && getNotifInfo('user', $_GET['id']) == $_SESSION['id']){
    desactNotif($_GET['id']);
}
if(isset($_GET['action']) && $_GET['action'] == 'deleteAllNotifs'){
    desactAllNotifs($_SESSION['id']);
}

require_once ('view/users/notifications.php');
