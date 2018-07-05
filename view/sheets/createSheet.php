<?php
$title = "Créer votre fiche";
ob_start();
?>
<script type="text/javascript" src="public/ckeditor/ckeditor.js"></script>
<?php
$files = ob_get_clean();
ob_start(); ?>

<br>
    <div class="container">
        <a href="javascript:history.back()">Retour</a>
        <br/><br/>
        <div style="border:solid;border-radius: 15px;background-color:rgba(116, 185, 255,0.7);padding-right:15px;padding-left:20px;">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">Espace de création</h2>
                </div>
            </div>
            <form method="post" action="index.php?page=createSheet&action=createSheet" enctype="multipart/form-data">
                <div class="row">

                    <label>Titre de la fiche</label>
                    <input type="text" name="title" width="150">
                </div>
                <br>
                <label>Choisir le niveau d'étude</label>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="category" value="college" >
                                collège
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="category" value="lycee" >
                                lycée
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Choisir la matière</label>
                        <select name="discipline">
                            <option value="math">mathematique</option>
                            <option value="litterature">litterature</option>
                            <option value="anglais">anglais</option>
                            <option value="chimie">physique-chimie</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <label class="custom-file">Ajoutez un support</label>
                        <input type="file" id='file' name="supp">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Saisir le contenu de la fiche ici:</label>
                            <textarea class="form-control ckeditor" name="content" rows="15"></textarea>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Valider" >
            </form>
        </div>
    </div>

<?php $content = ob_get_clean();
require('view/template.php'); ?>
