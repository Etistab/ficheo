<?php
$title = 'Espace membre';
ob_start();?>
<script src="public/js/alert.js"></script>
<?php
$files = ob_get_clean();
ob_start(); ?>

<div class="col-sm-8">

        <br>
        <form method="post" action="index.php?page=user&section=param&action=changeParam">
          <div class="container">
            <div class="form-group row">
              <label for="pseudo" class="col-sm-3 col-form-label col-form-label-sm"><b>Changer de pseudo :</b></label>
              <div class="col-sm-5">
                <input type="text" name="pseudo" class="form-control form-control-sm" />
              </div>
            </div>
            <hr style="border-color:black;">
          </div>
          <b>Changer de mot de passe :</b> <br>
          <div class="container">
          <div class="form-group row">
            <label for="oldpwd" class="col-sm-3 col-form-label col-form-label-sm"><b>Ancien mot de passe:</b></label>
            <div class="col-sm-5">
              <input type="password" name="oldPwd" class="form-control form-control-sm" />
            </div>
          </div>
          <div class="form-group row">
            <label for="newPwd" class="col-sm-3 col-form-label col-form-label-sm"><b>Nouveau mot de passe</b></label>
            <div class="col-sm-5">
              <input type="password" name="newPwd" class="form-control form-control-sm" />
            </div>
          </div>
          <div class="form-group row">
            <label for="confirmPwd" class="col-sm-3 col-form-label col-form-label-sm"><b>Confirmation:</b></label>
            <div class="col-sm-5">
              <input type="password" name="confirmPwd" class="form-control form-control-sm" />
            </div>
          </div>
          <hr style="border-color:black;">
          <input type="checkbox" name="newsletter" <?= isChecked('newsletter') ?>> <label for="newsletter"> S'abonner aux newsletters</label><br/><br/>
          <button type="submit"  class="btn-primary mb-2">Enregistrer les modifications</button>
              <a href="index.php?page=user&section=param&action=deleteAccount"> Supprimer mon compte </a>
</div>
        </form>
        <br>
        <p>
            Change ta photo de profil grace a <a href="http://www.gravatar.com" target="_blank">Gravatar</a> en utilisant ton adresse email: <?= getUserInfo('email') ?>
        </p>

</div>

<?php $body = ob_get_clean();
require ("view/users/template.php");
?>
