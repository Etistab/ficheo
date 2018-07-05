<?php
$title = 'Espace membre';
ob_start();?>
<?php
$files = ob_get_clean();
ob_start(); ?>

<div class="col-sm-6">
    <div class="container">
        <h1>Envoyer un mail</h1>
        <form method="post" action="index.php?page=user&section=admin&action=sendMail">
            <label for="dest">A: </label>
            <select name="dest">
                <?php printDest(); ?>
            </select>
            <br>
            <input type="checkbox" name="sendToAll"><label>Envoyer à tous les membres</label>
            <br><br>
            <label for="object">Objet: </label> <input type="text" name="object" placeholder="Objet"><br><br>
            <label for="message">Message:</label><br>
            <textarea title="message" name="message" rows="6" cols="100"></textarea><br>
            <input type="submit" value="Envoyer">
        </form>
    </div>
    <br>
</div>


<?php $body = ob_get_clean();
require ("view/users/template.php");
?>
