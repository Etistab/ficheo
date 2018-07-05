<?php
$title = 'Espace membre';
ob_start();?>
<script src="public/js/ajax.js"></script>
<?php
$files = ob_get_clean();
ob_start();?>
<br>
<a href="javascript:history.back()"><button type="button" class="btn btn-dark" style="margin-left: 20px;">Retour</button></a>
<br><br>
<h1 style="text-align: center">Gestion des signalements</h1>
<br/>
<table class="table table-striped" border="1px">
    <thead class="thead-dark">
        <tr>
            <th>Utilisateur</th>
            <th>Date</th>
            <th>Motif</th>
            <th>Lien du signalement</th>
            <th>Envoyer un avertissement</th>
            <th>Bannir le membre</th>
            <th>Marquer comme vu</th>
        </tr>
    </thead>
    <tbody>
        <?php printReports(); ?>
    </tbody>
</table>

<?php $content = ob_get_clean();
require ("view/template.php");
?>
