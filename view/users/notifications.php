<?php
$title = 'Espace membre - Notifications';
ob_start();?>
<script src="public/js/ajax.js"></script>
<?php
$files = ob_get_clean();
ob_start(); ?>

<div class="col-sm-10">
  <div class="container">
    <h1 align='center'>Notifications</h1>
    <br>
      <a style="float:right;" onclick="sendAjaxRequest('index.php?page=user&section=notifs&action=deleteAllNotifs')"><button type="button" class="btn btn-primary btn-lg">Tout marquer comme lu</button></a><br/>
    <br>
    <br>
    <ul id="notifs" class="list-group">
         <?php printNotifications($_SESSION['id']); ?>
    </ul>
    <br><br>
  </div>
</div>

<?php $body = ob_get_clean();
require ("view/users/template.php");
?>
