<?php
include('view/report.php');
$title = getSheetInfo('title', $_GET['id']);
ob_start();?>
<script src="public/js/alert2.js"></script>
<script src="public/js/trieCommentaires.js"></script>
<script src="public/js/ajax.js"></script>
<script src="public/ckeditor/ckeditor.js"></script>
<style>
.secret{
  display: none;
}
</style>
<?php
$files = ob_get_clean();
ob_start(); ?>

<br>
    <div class="container">
        <a href="javascript:history.back()"><button type="button" class="btn btn-dark">Retour</button></a>
        <br/><br/>
        <div style="border:solid;border-radius:15px;background-color#3949AB;padding-right:15px;padding-left:20px;">
            <div class="row">
                <div class="col-sm-3">
                    <p>Matière : <?= getSheetInfo('discipline', $_GET['id']) ?></p>
                    <p>Niveau : <?= getSheetInfo('category', $_GET['id']) ?></p>
                    <p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                                data-target="#report" style="margin-left : 10px;">
                            Signaler la fiche
                        </button>
                    </p>
                    <?php if(getSheetInfo('support', $_GET['id'])){
                    ?>
                        <a href="public/supports/<?= getSheetInfo('support', $_GET['id'])?>" download="<?= getSheetInfo('title', $_GET['id']) ?>">Télécharger le support</a>
                    <?php } ?>
                </div>
                <div class="col-sm-6">
                    <p align="center"><?= getSheetInfo('title', $_GET['id']) ?></p>
                </div>
                <div class="col-sm-3">
                    <?php
                        printAverage($_GET['id']);
                    ?>
                    <br>
                    Votes : 
                    <?php
                        $number = countNoteBySheet($_GET['id']);
                        echo $number;
                    ?>
                    <br>
                    <p>Auteur: <?= getUserById(getSheetInfo('author', $_GET['id']))[2]  ?> </p>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <?= getSheetInfo('content', $_GET['id']) ?>
                </div>
            </div>
            <div class="container">
               <?php
               if(isset($_SESSION['pseudo']) ){
                    checkMarkForm($_SESSION['id'], $_GET['id']);
                }
                else{
                    echo "<p>Connectez-vous pour laissez un commentaire :) !";
                }

                ?>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                        if (isset($_SESSION['pseudo']) ) {
                            printCommentForm1();
                        }else{
                            printCommentForm2();
                        }
                    ?>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="button" onclick="trier_moyenne()" value='trier par moyenne'>
                    <input type="button" onclick="trier_date()" value='trier par date'>
                    <br/><br/>
                   <?php printComments($_GET['id'])?>
                </div>
            </div>
        </div>
    </div>
<?php $content = ob_get_clean();
require ("view/template.php");
?>
