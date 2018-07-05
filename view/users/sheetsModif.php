<?php
$title = 'Espace membre';
ob_start();?>
<script src="public/js/alert2.js"></script>
<script src="public/js/filtre2.js"></script>
<?php
$files = ob_get_clean();
ob_start(); ?>

    <br/>
    <a href="javascript:history.back()"><button type="button" class="btn btn-dark" style="margin-left: 20px;">Retour</button></a>
    <br/>
    <h1>Administration des fiches</h1>
    <br>
    <input type="text" id="rechercheSheet" onkeyup="filter('tableUserSheet','rechercheSheet','filtreSheet')" placeholder="Recherche par nom">
    <select name="filtreSheet">
    	<option value="1">Titre</option>
    	<option value="2">Auteur</option>
    	<option value="3">Categorie</option>
    	<option value="4">Activation</option>
    	<option value="5">Date</option>
    
    </select><br>

        <table id="tableUserSheet" class="table table-striped" border="1px">
            <thead class="thead-dark">
            <tr>
                <th>id</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Categorie</th>
                <th>Activé ?</th>
                <th>Date de création</th>
                <th>Désactiver la fiche</th>
                <th>Supprimer definitivement</th>
            </tr>
            </thead>
            <tbody>

            <?= printSheets(); ?>

            </tbody>
        </table>

    <form>
        <input type="button" onclick="alert_delete_sheets()" value="Vider la table des fiches">
    </form>

<?php $content = ob_get_clean();
require ("view/template.php");
?>
