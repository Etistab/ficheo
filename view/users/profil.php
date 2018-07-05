<?php
$title = 'Espace membre';
ob_start();?>
<?php
$files = ob_get_clean();
ob_start(); ?>

    <br><br><br>
    <div class="container" style="background-color:white;border:solid; border-radius:25px; padding:0;padding-left:15px;">
        <br>
        <div class="row">
            <div class="col-sm-2">
              <br>
              <a href="javascript:history.back()"><button type="button" class="btn btn-dark">Retour</button></a>
            </div>
            <div style="width:65px;height:65px;border:solid;">
                <img src="<?= getGravatar($_GET['user']) ?>" alt="Photo de profil">
            </div>
            <div class="col-sm-5">
              <br>
                <div class="container">
                    <h2 style="color:rgb(238,131,58);font-weight:bold;"><?= $_GET['user'] ?></h2>
                    <b>Adresse email:</b> <?= getUserInfo('email',$_GET['user']) ?><br><br>

                    <!-- partie niveau -->
                    <div style="border-style:double;padding-left:15px;background-color:rgba(103,102,102,0.3);font-size:1.2em;width:90%">
                      <b>Niveau : <?= calcXpForNextLevel(getUserInfo('experience', $_GET['user']), true) ?><br/>

                      <div class="progress" style="margin-top:5px;margin-left:-10px;width:90%;">

                          <div class="progress-bar progress-bar-striped " style="width:<?= convertXpToPercent(getUserInfo('experience',$_GET['user'])) ?>%; ">
                          </div>
                      </div>
                      Experience: <?= getUserInfo('experience', $_GET['user']) ?> / <?= calcXpForNextLevel(getUserInfo('experience', $_GET['user'])) ?><br>
                      Rang: <?= getUserInfo('type', $_GET['user']) ?><br/>
                    </b>
                    </div>
                    <!-- -->
                    <br>
                    <div style="border-right:solid;">
                        <b><u>Derniere fiche publiée:</u></b><br/>
                        <?php printLastSheetByPseudo(getUserInfo('id', $_GET['user'])); ?><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean();
require ("view/template.php");
?>
