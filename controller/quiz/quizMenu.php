<?php
require_once('model/quiz.php');
require_once('controller/header.php');

function printQuiz(){
  $quizs = getQuizActive();

  foreach ($quizs as $quiz) {
    $question = countQuestions($quiz['id']);
    $auteur = getAuteur($quiz['auteur']);
    echo "<ul class='quiz'>";
    echo "<li><a href=index.php?page=quiz&id=".$quiz['id'].">".utf8_decode($quiz['title'])."</a></li>";
    echo "<li>".$question[0]." question(s)</li>";
    echo "<li>".$quiz['date_crea']."</li>";
    echo "<li>Ecrit par <a href='index.php?page=user&user=".$auteur[0]."'>".$auteur[0]."</a></li>";
    echo "</ul>";
  }
}

require_once('view/quiz/quizMenu.php');
 ?>
