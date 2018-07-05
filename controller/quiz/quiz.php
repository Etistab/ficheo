<?php
require_once('model/quiz.php');
require_once ('controller/header.php');

function printQuizName(){
  if (isset($_GET['id'])) {
    $name = getQuizName($_GET['id']);
    if($name == false){
      return 'erreur';
    }else {
      return $name[0];
    }
  } else {
    return "Erreur";
  }
}
function printQuestion($id,$modif){
  $number = countQuestions($id);
  $id_question = getFirstQuestionsId($id,$modif);
  for ($i = 0;$i<$number[0];$i++){
    $question = getQuestions($id_question);
      echo "<p class='secret' name='question' id='question_".($i+1)."'>".utf8_decode($question["question"])."</p>";
      echo "<p class='secret' id='reponse_".($i+1)."'>".utf8_decode($question["answer"])."</p>";
      echo "<p class='secret' id='choix2_".($i+1)."'>".utf8_decode($question["choice1"])."</p>";
      echo "<p class='secret' id='choix3_".($i+1)."'>".utf8_decode($question["choice2"])."</p>";
      echo "<p class='secret' id='choix4_".($i+1)."'>".utf8_decode($question["choice3"])."</p>";
      $id_question = $id_question + 1;
    }
  }
function printMarks(){
  if (isset($_SESSION['id'])) {
    if (getMarks($_SESSION['id'],$_GET['id']) != NULL) {
      echo "Tu avais ".getMarks($_SESSION['id'],$_GET['id'])[0]." bonne(s) réponse(s) sur ".countQuestions($_GET['id'])[0]." question(s) la dernière fois";
      if (getMarks($_SESSION['id'],$_GET['id'])[0] == countQuestions($_GET['id'])[0]) {
        echo "<br><br>BRAVO tu as la note maximal !";
      }else {
        echo "<br><br>Courage ! tu peux mieux faire !";
      }
    }else{
      echo "Tu n'as pas encore de note sur ce quiz! <br>";
      echo "Bon courage!";
    }


  }else{
    echo "Appuyer sur suivant pour commencer le quiz <br>";
    echo "Pour enregistrer votre progression il est nécessaire d'avoir un compte";
  }
}

function isCreator(){
  $creator = getQuizInfo('auteur',$_GET['id']);
  if(isset($_SESSION['id'])){
    if($_SESSION['id'] == $creator){
      echo "<p> <a href='index.php?page=modifQuiz&id=".$_GET['id']."'><button type='button' class='btn btn-primary'>Modifier</button></a></p> ";
    }
  }
}


require_once('view/quiz/quiz.php');
