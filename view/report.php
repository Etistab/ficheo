<?php
function printDisconnectWindow(){
?>
    <!-- Modal body -->
    <div class="modal-body">
        <p style="margin-right: 30px; margin-top:15px;">
            Connecte toi pour pouvoir faire un signalement :)
        </p>
        <form method="post" action="index.php?<?php isPage(); ?>action=connexion">
            <label for="pseudo">Pseudo:</label><br>
            <input type="text" name="pseudo" id="pseudo" maxlength="12"
                   placeholder="Maximum 12 caractères" required><br>
            <label for="password">Mot de passe:</label><br>
            <input type="password" name="password" id="password" maxlength="12"
                   placeholder="Maximum 12 caractères" required><br><br>
            <input type="submit" class="btn btn-dark" value="Se connecter">
            <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                    data-target="#forgetPassword" style="margin-left : 10px;">
                Mot de passe oublié ?
            </button>
        </form>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <p style="margin-right: 30px; margin-top:15px;">
            Pas encore inscrit ? Fais-le maintenant! :)
        </p>
        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                data-target="#Inscription" style="margin-left : 10px;">
            Inscription
        </button>
    </div>
<?php
}
?>
<div class="modal fade" id="report">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="padding-left : 35%;">Signaler</h4>
                </div>
            <?php
            if(isset($_SESSION['id'])) {
                ?>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="index.php?<?php isPage(); ?>action=report">
                        <label for="content">Motif du signalement: (optionnel)</label><br>
                        <textarea name="content" id="content" cols="60" rows="7"></textarea><br><br>
                        <input type="submit" class="btn btn-dark" value="Envoyer le signalement">
                    </form>
                </div>
                <?php
            }
            else {
                printDisconnectWindow();
            }
            ?>
        </div>
    </div>
</div>
<?php
if(isset($_GET['page']) && $_GET['page'] == 'sheet'){
    $comments = getCommentsBySheet($_GET['id']);
    foreach ($comments as  $comment) {
        ?>
        <div class="modal fade" id="reportComment<?= $comment['id'] ?>">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" style="padding-left : 35%;">Signaler</h4>
                    </div>
                <?php
                if(isset($_SESSION['id'])) {
                    ?>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="post"
                              action="index.php?<?php isPage(); ?>action=report&comment=<?= $comment['id'] ?>">
                            <label for="content">Motif du signalement: (optionnel)</label><br>
                            <textarea name="content" id="content" cols="60" rows="7"></textarea><br><br>
                            <input type="submit" class="btn btn-dark" value="Envoyer le signalement">
                        </form>
                    </div>
                    <?php
                }
                else {
                    printDisconnectWindow();
                }
                ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>