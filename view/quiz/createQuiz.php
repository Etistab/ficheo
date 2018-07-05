<?php
$title="Créer votre quiz";
ob_start();
 ?>
 <script src="public/js/creationQuiz.js" ></script>

 <?php
 $files = ob_get_clean();
 ob_start(); ?>

 <br>
  <div class="container">
    <a href="javascript:history.back()">Retour</a>
    <br><br>
    <div style="border:solid;border-radius: 15px;background-color:rgba(116, 185, 255,0.7);padding-right:15px;padding-left:20px;">
      <div class="row">
          <div class="col-sm-12">
              <h2 class="text-center">Espace de création de Quiz</h2>
          </div>
      </div>
      <?php if($_GET['page']=='modifQuiz'){ ?>
          <form method="post" action="index.php?page=modifQuiz&action=modifQuiz&id=<?= $_GET['id'] ?>" onsubmit="return verification()"  enctype="multipart/form-data" >
            <?php }else{ ?>
          <form method="post" action="index.php?page=createQuiz&action=createQuiz" onsubmit="return verification()"  enctype="multipart/form-data" >
          <?php } ?>
      <div class="row">
        <div id="zone_titre"class="col-sm-12">
          <?php if($_GET['page']=='modifQuiz'){ ?>
            <h2><u > <?=getQuizInfo('title',$_GET['id']) ?> </u></h2>
            <input type="hidden" id='title' name="title" width="150" value="<?=getQuizInfo('title',$_GET['id']) ?>">
            <?php }else{ ?>
          <label>Titre :</label>
          <input type="text" id='title' name="title" width="150">
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <label>Nombre de question :</label>
          <select id="nombre_de_question" onchange="analyse()">
            <option value="1" selected>1</option>
            <option value="2" >2</option>
            <option value="3" >3</option>
            <option value="4" >4</option>
            <option value="5" >5</option>
            <option value="6" >6</option>
            <option value="7" >7</option>
            <option value="8" >8</option>
            <option value="9" >9</option>
            <option value="10" >10</option>
            <option value="11" >11</option>
            <option value="12" >12</option>
            <option value="13" >13</option>
            <option value="14" >14</option>
            <option value="15" >15</option>
            <option value="16" >16</option>
            <option value="17" >17</option>
            <option value="18" >18</option>
            <option value="19" >19</option>
            <option value="20" >20</option>
          </select>
        </div>
      </div>
      <div id="zone_question">
        <?php if ($_GET['page']=='modifQuiz') {
        ModifOrNot();
      }else {?>
        <div name="question_reponse">
          <div class="row">
              <div class="col-sm-12">
                <label>Question 1</label>
                <br>
                <textarea rows="2" cols="100" name="question1" style="resize: none;"></textarea>
              </div>
          </div>
          <div class="row">
              <div class="col-sm-6">
                <label>Réponse :</label>
                <input type="text" name="reponse1">
              </div>
              <div class="col-sm-6">
                <label>Choix 2:</label>
                <input type="text" name="choix_2_1">
              </div>
          </div>
          <div class="row">
              <div class="col-sm-6">
                <label>Choix 3:</label>
                <input type="text" name="choix_3_1">
              </div>
              <div class="col-sm-6">
                <label>Choix 4:</label>
                <input type="text" name="choix_4_1">
              </div>
          </div>
          </div>
      <?php } ?>
      </div>
      <input type="submit" value="Valider le quizz">
    </form>
  </div>
  </div>

  <?php $content = ob_get_clean();
  require('view/template.php'); ?>
