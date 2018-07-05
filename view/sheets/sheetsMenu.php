<?php
$title = 'Menu des fiches';
ob_start();?>
<script src="public/js/filtre2.js"></script>
<style onloadend="fiche()" >
.secret{
display: none;
}
.fiche{
  display: inline-block;
  width: 200px;
  height: 150px;
}
ul{
  list-style-type: none;
}
</style>

<?php
$files = ob_get_clean();
ob_start(); ?>
<div class="container" >
<h1><?= $pageTitle ?></h1>
</div class="container">
<section >
  <div class="container">
      <br>
      <p>
      Filtrer les fiches
      </p>
      <input type="text" id="choixNomFiche" onkeyup="filtrefiche()" placeholder="Titre">
      <select id="Etude" onchange="filtrefiche()">
          <option value="">tous</option>
          <option value="college">college</option>
          <option value="lycee">lycee</option>
      </select>
      <input type="text" id="choixMatiere" onkeyup="filtrefiche()" placeholder="Matiere">
      <br>
      <br>
      <div id="liste_fiche">
    <?php printSheetsByCategory($category) ?><br>
      </div>
  </div>
</section>

<?php $content = ob_get_clean();

require('view/template.php'); ?>
