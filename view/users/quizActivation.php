<?php
$title="Espace membre";
ob_start();
 ?>
 <script src="public/js/quiz.js"></script>
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
  <h2 id='test_status'></h2>
    <div id="test" style="border-radius: 20px;border-width:4px; background-color:grey;border-color:black;">
      <div class="container">
      <h2 align='center'>coucou</h2>
      <hr width=90%>
      <div id="zone_quiz">
      <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <h3 id="zone_question"></h3>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-4" id="zone_reponse1">

        </div>
        <div class="col-sm-3" id="zone_reponse2">

        </div>
      </div>
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-4" id="zone_reponse3">

        </div>
        <div class="col-sm-3" id="zone_reponse4">

        </div>
      </div>
      <div class="row">
        <div class="col-sm-8"></div>
        <div class="col-sm-2"></div>
        <div class="col-sm-2">
      <button onclick="checkReponse()">suivant</button>
        </div>
      </div>
    </div>

      <br>
    </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="index.php?page=user&section=admin&action=activeQuiz&id=<?= $_GET['id'] ?>">Activer le quiz</a><br>
            <a href="index.php?page=user&section=admin&action=deleteQuiz&id=<?= $_GET['id'] ?>">Supprimer le quiz</a>
        </div>
    </div>
    <?php printQuestion($_GET['id']) ?>
</div>
<?php $content = ob_get_clean();
require('view/template.php'); ?>
