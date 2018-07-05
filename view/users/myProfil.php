<?php
$title = 'Espace membre';
ob_start();?>
<?php
$files = ob_get_clean();
ob_start(); ?>

<div class="col-sm-5">
  <br>
    <div class="container">
      <div style="width:65px;height:65px;border:solid;">
      <img src="<?= getGravatar($_SESSION['pseudo']) ?>" alt="Photo de profil">
    </div>
        <h2 style="color:rgb(238,131,58);font-weight:bold;"><?= $_SESSION['pseudo'] ?></h2>
        <b>Adresse email:</b> <?= getUserInfo('email') ?><br><br>

        <!-- partie niveau -->
        <div style="border-style:double;padding-left:15px;background-color:rgba(103,102,102,0.3);font-size:1.2em;width:90%">
          <b>Niveau : <?= calcXpForNextLevel(getUserInfo('experience'), true) ?><br/>

          <div class="progress" style="margin-top:5px;margin-left:-10px;width:90%;">
            <div class="progress-bar progress-bar-striped " style="width:<?= convertXpToPercent(getUserInfo('experience')) ?>%; ">

            </div>
          </div>
          Experience: <?= getUserInfo('experience') ?> / <?= calcXpForNextLevel(getUserInfo('experience')) ?>
          Rang: <?= getUserInfo('type') ?><br/>
        </b>
        </div>
        <!-- -->
        <br>
        <div style="border-right:solid;">
            <b><u>Derniere fiche publiée:</u></b><br/>
            <?php printLastSheetByPseudo(getUserInfo('id')); ?><br/>
        </div>
    </div>
</div>

<?php $body = ob_get_clean();
require ("view/users/template.php");
?>
