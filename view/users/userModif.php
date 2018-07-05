<?php
$title = 'Administration des membres';
ob_start();?>
<script src="public/js/alert2.js"></script>
<script src="public/js/filtre2.js"></script>
<?php
$files = ob_get_clean();
ob_start(); ?>

<br/>
<a href="javascript:history.back()"><button type="button" class="btn btn-dark" style="margin-left: 20px;">Retour</button></a>
<br/>
<h1>Administration des membres</h1>

<form method="post" action="index.php?page=user&section=admin&action=addUser">
	<input type="text" name="email" placeholder="email">
	<input type="text" name="pseudo" placeholder="peudo">
	<input type="password" name="pwd" placeholder="mot de passe">
	 <select name="type">
	 	<option value="admin">Admin</option>
	 	<option value="member">Membre</option>
	 	<option value="banned">Banned</option>
	 </select>
	 <input type="submit" value="Ajouter">
</form>

<br>
<input type="text" id="rechercheOn" onkeyup="filter('tableUserOn','rechercheOn','filtreOn')" placeholder="Recherche par nom">
<select name="filtreOn">
	<option value="1">Email</option>
	<option value="2">Pseudo</option>
	<option value="3">Type</option>
	<option value="4">Active</option>
	<option value="5">Experience</option>
	<option value="6">Signalement</option>
</select><br>
<h2>Membres actifs</h2>
 <table id='tableUserOn' class="table table-striped"border="1px">
	<thead class="thead-dark">
		<tr>
			<th>id</th>
	 		<th>email</th>
	 		<th>pseudo</th>
	 		<th>type</th>
	 		<th>active</th>
	 		<th>experience</th>
	 		<th>Signalement</th>
	 		<th>date inscription</th>
		</tr>
	</thead>
	<tbody>

	<?php printUser(); ?>

	</tbody>
</table>
<br>
<input type="text" id="rechercheOff" onkeyup="filter('TableUserOff','rechercheOff','filtreOff')" placeholder="Recherche par nom">
<select name="filtreOff">
	<option value="1">Email</option>
	<option value="2">Pseudo</option>
	<option value="3">Type</option>
	<option value="4">Active</option>
	<option value="5">Experience</option>
	<option value="6">Signalement</option>
</select><br>
<br>
<h2>Membres supprimés</h2>
 <table id="TableUserOff" class="table table-striped"border="1px">
	<thead class="thead-dark">
		<tr>
			<th>id</th>
	 		<th>email</th>
	 		<th>pseudo</th>
	 		<th>type</th>
	 		<th>active</th>
	 		<th>experience</th>
	 		<th>Signalement</th>
	 		<th>date inscription</th>
		</tr>
	</thead>
	<tbody>

	<?php printDeletedUser(); ?>

	</tbody>
</table>
<form>
    <input type="button" onclick="alert_delete_all_users()" value="Vider la table Utilisateur">
</form>
<br>


<?php $content = ob_get_clean();
require ("view/template.php");
?>
