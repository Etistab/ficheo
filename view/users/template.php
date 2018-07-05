<?php
ob_start(); ?>
<br/><br/><br/>
<div class="container" style="background-color:white;border:solid; border-radius:25px; padding:0;padding-left:15px;">
    <div class="row">
        <div class="col-sm-2  " style="background-color:grey; border-radius:20px;margin:0;">
            <ul id="navigation_profil">
                <li><a href="index.php?page=user">Profil</a></li><hr>
                <li><a href="index.php?page=user&section=param">Paramètres du compte</a></li><hr>
                <li><a href="index.php?page=user&section=notifs">Notifications</a></li>
                <?php
                if(isset($_SESSION['type']) && $_SESSION['type'] == 'admin'){
                    ?>
                    <hr><li><a href="index.php?page=user&section=admin">Administration</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>

        <?= $body ?>

    </div>
</div>
<br><br><br>

<?php $content = ob_get_clean();
require ("view/template.php");
?>
