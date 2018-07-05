<?php
$title = 'Menu des fiches';
ob_start();?>
<script src="public/js/filtre2.js"></script>
<style onloadend="fiche()" >
.secret{
display: none;
}
.quiz{
  display: inline-block;
  width: 200px;
  height: 150px;
}
</style>
<?php
$files = ob_get_clean();
ob_start(); ?>
<div class="container">
  <section>
    <div class="container">
      <br>
      <h2 align="center">MENU DES QUIZZ</h2>
      <br><br>
      <div id="liste_quiz">
        <?php  printQuiz()?> <br>
      </div>
    </section>

<?php $content = ob_get_clean();

require('view/template.php'); ?>
