<?php
$title = 'Espace membre';
ob_start();?>

<?php
$files = ob_get_clean();
ob_start(); ?>

<h1 style="text-align: center">Activation de la fiche</h1>

    <div class="container">
        <div style="border:solid;border-radius:15px;background-color#3949AB;padding-right:15px;padding-left:20px;">
            <div class="row">
                <div class="col-sm-3">
                    <p>Matière : <?= getSheetInfo('discipline', $_GET['id']) ?></p>
                    <p>Niveau : <?= getSheetInfo('category', $_GET['id']) ?></p>
                </div>
                <div class="col-sm-6">
                    <p align="center"><?= getSheetInfo('title', $_GET['id']) ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <?= getSheetInfo('content', $_GET['id']) ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <a href="index.php?page=user&section=admin&action=activeSheet&id=<?= $_GET['id'] ?>">Activer la fiche</a>
                    <a href="index.php?page=user&section=admin&action=deleteSheet&id=<?= $_GET['id'] ?>">Supprimer la fiche</a>
                </div>
            </div>
        </div>
    </div>
<?php $content = ob_get_clean();
require ("view/template.php");
?>
