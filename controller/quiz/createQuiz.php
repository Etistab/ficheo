<?php
require_once('model/quiz.php');
require_once('controller/header.php');

function ModifOrNot(){
  if (isset($_GET['page']) && $_GET['page'] == 'modifQuiz') {
  $number = countQuestions($_GET['id']);
  $id_question = getFirstQuestionsId($_GET['id'],0);
  for ($i=0; $i <$number[0] ; $i++) {
  $question = getQuestions($id_question);
  echo "<div name='question_reponse'>";
  echo "  <div class='row'>";
  echo "    <div class='col-sm-12'>";
  echo "      <label>Question 1</label>";
  echo "      <br>";
  echo "      <textarea rows='2' cols='100' name='question".($i+1)."' style='resize: none;'>".$question["question"]."</textarea>";
  echo "    </div>";
  echo "  </div>";
  echo "  <div class='row'>";
  echo "    <div class='col-sm-6'>";
  echo "      <label>Réponse :</label>";
  echo "        <input type='text' name='reponse".($i+1)."' value='".$question["answer"]."'>";
  echo "    </div>";
  echo "    <div class='col-sm-6'>";
  echo "      <label>Choix 2:</label>";
  echo "      <input type='text' name='choix_2_".($i+1)."' value='".$question["choice1"]."'>";
  echo "    </div>";
  echo "    </div>";
  echo "    <div class='row'>";
  echo "      <div class='col-sm-6'>";
  echo "        <label>Choix 3:</label>";
  echo "        <input type='text' name='choix_3_".($i+1)."' value='".$question["choice2"]."'>";
  echo "      </div>";
  echo "      <div class='col-sm-6'>";
  echo "         <label>Choix 4:</label>";
  echo "         <input type='text' name='choix_4_".($i+1)."' value='".$question["choice3"]."'>";
  echo "      </div>";
  echo "    </div>";
  echo "</div>";
  $id_question = $id_question+1;
  }
  }
}

if (isset($_GET['page']) && $_GET['page'] == 'createQuiz' && isset($_GET['action']) && $_GET['action'] == 'createQuiz' && isset($_POST['title']) && isset($_POST['question1']) && isset($_POST['reponse1']) ) {
  $i=0;
  createQuiz(htmlspecialchars($_POST['title']),$_SESSION['id']);
  $id = getIdQuiz($_POST['title']);

  for($i=1;$i<21;$i++){
    if (isset($_POST['question'.$i])) {
      createQuestion(htmlspecialchars($_POST['question'.$i]),htmlspecialchars($_POST['reponse'.$i]),htmlspecialchars($_POST['choix_2_'.$i]),htmlspecialchars($_POST['choix_3_'.$i]),htmlspecialchars($_POST['choix_4_'.$i]),$id[0],0);
    }
  }
  header('Location:index.php');
}elseif (isset($_GET['page']) && $_GET['page'] == 'modifQuiz' && isset($_GET['action']) && $_GET['action'] == 'modifQuiz' && isset($_POST['question1']) && isset($_POST['reponse1']) ){
  $i=0;
  $id = $_GET['id'];
  for($i=1;$i<21;$i++){
    if (isset($_POST['question'.$i])) {
      createQuestion(htmlspecialchars($_POST['question'.$i]),htmlspecialchars($_POST['reponse'.$i]),htmlspecialchars($_POST['choix_2_'.$i]),htmlspecialchars($_POST['choix_3_'.$i]),htmlspecialchars($_POST['choix_4_'.$i]),$id,1);
    }
  }
  header('Location:index.php');
}else{
require_once('view/quiz/createQuiz.php');
}
