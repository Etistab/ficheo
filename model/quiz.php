<?php
require_once ("model/db_connect.php");

function getAllQuiz(){
  $db = dbConnect();
  $quiz = $db->query('SELECT quizz.id AS id , quizz.title AS title, quizz.date_crea AS date_creation, users.pseudo AS author, quizz.active AS active from users,quizz where quizz.auteur=users.id ORDER BY quizz.date_crea DESC');
  return $quiz;
}
function getInactiveQuiz($active = 0){
  $db = dbConnect();
  $quiz = $db->prepare('SELECT quizz.id AS id , quizz.title AS title, quizz.date_crea AS date_creation, users.pseudo AS author, quizz.active AS active from users,quizz where quizz.auteur=users.id AND quizz.active = ? ORDER BY quizz.date_crea DESC');
  $quiz->execute(array($active));
  return $quiz;
}
function getModifQuiz(){
  $db = dbConnect();
  $quiz = $db->prepare('SELECT DISTINCT quizz.title AS title, quizz.id AS id, users.pseudo AS author from users,quizz,questionquizz where quizz.auteur=users.id AND questionquizz.quizz=quizz.id AND questionquizz.modif = 1  ');
  $quiz->execute();
  return $quiz;
}

function getQuizInfo($column, $id){
    $quiz = getQuizById($id);
    if ($quiz == false) {
        return 'Erreur';
    }
    else {
        return $quiz[$column];
    }
}

function getQuizName($id){
$db = dbConnect();
$req=$db->prepare('SELECT title FROM quizz where id = ?');
$req->execute(array($id));
$quiz = $req->fetch();

return $quiz;

}
function getQuizById($id){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM quizz WHERE id = ?');
    $req->execute(array($id));
    $quiz = $req->fetch();

    return $quiz;
  }

function getIdQuiz($title){
  $db = dbConnect();
  $req =$db->prepare('SELECT id FROM quizz where title = ?');
  $req->execute(array($title));
  $quiz = $req->fetch();

  return $quiz;
}
function createQuiz($title,$auteur){
  $db =dbConnect();
  $req =$db->prepare('INSERT INTO quizz(title,auteur) VALUES (:title,:auteur)' );
  $affectedLines =$req->execute(array(
    'title'=>$title,
    'auteur'=>$auteur
  ));
  return $affectedLines;
}

function createQuestion($question,$answer,$choice1,$choice2,$choice3,$quizz,$modif){
  $db =dbConnect();
  $req =$db->prepare('INSERT INTO questionquizz(question, answer, choice1, choice2, choice3, quizz,modif) VALUES (:question, :answer, :choice1, :choice2, :choice3, :quizz, :modif)');
  $affectedLines = $req->execute(array(
    ':question'=>$question,
    ':answer'=>$answer,
    ':choice1'=>$choice1,
    ':choice2'=>$choice2,
    ':choice3'=>$choice3,
    ':quizz'=>$quizz,
    ':modif'=>$modif
  ));
  return $affectedLines;
}
function countQuestions($id,$modif =0){
  $db =dbConnect();
  $req =$db->prepare('SELECT count(*) FROM questionquizz where quizz= ? AND modif = ?');
  $req->execute(array($id,$modif));
  $number = $req->fetch();

  return $number;
}

function getFirstQuestionsId($id,$modif) {
  $db =dbConnect();
  $req =$db->prepare('SELECT min(id) FROM questionquizz where quizz= ? AND modif= ?');
  $req->execute(array($id,$modif));
  $id_question = $req->fetch();

  return $id_question[0];
}
function getQuestions($id){
  $db=dbConnect();
  $req=$db->prepare('SELECT question,answer,choice1,choice2,choice3 FROM questionquizz WHERE id = ?');
  $req->execute(array($id));
  $quiz= $req->fetch();

  return $quiz;


}
function quizActivation($id, $active = true){
  $db = dbConnect();
  $req =$db->prepare('UPDATE quizz SET active = :active WHERE id = :id');
  $req->execute(array(
    "active"=>$active,
    "id"=>$id
  ));
  $affectedLines=$req->rowCount();

  return $affectedLines;
}
function quizDeleting($id){
  $db= dbConnect();
  $req = $db->prepare('DELETE FROM quizz where id = ?');
  $req->execute(array($id));
  $affectedLines = $req->rowCount();

  return $affectedLines;
}
function quizModifOk($id){
  $db=dbConnect();
  $req = $db->prepare('DELETE  FROM questionquizz where quizz =? AND modif=0');
  $req->execute(array($id));
  $req = $db->prepare('UPDATE questionquizz SET modif=0 WHERE quizz = ?');
  $req->execute(array($id));
  $affectedLines = $req->rowCount();

  return $affectedLines;

}
function quizModifNotOk($id){
  $db=dbConnect();
$req = $db->prepare('DELETE FROM questionquizz where quizz =? AND modif=1');
  $req->execute(array($id));
  $affectedLines = $req->rowCount();

  return $affectedLines;

}
function getQuizActive(){
  $db=dbConnect();
  $req=$db->prepare('SELECT id,title,date_crea,auteur FROM quizz where active=1');
  $req->execute();
  $quiz=$req->fetchAll(PDO::FETCH_ASSOC);

  return $quiz;

}
function getAuteur($id){
  $db=dbConnect();
  $req=$db->prepare('SELECT pseudo from users where id= ?');
  $req->execute(array($id));
  $user = $req->fetch();

  return $user;
}
function getMarks($user,$quiz){
  $db=dbConnect();
  $req=$db->prepare('SELECT mark from quizmarks where users= :user AND quiz = :quiz');
  $req->execute(array(
    "user"=>$user,
    "quiz"=>$quiz
  ));
  $mark = $req->fetch();

  return $mark;
}
function getModif($id){
  $db=dbConnect();
    $req=$db->prepare('SELECT count(*) FROM questionquizz WHERE modif=1 AND quizz = ?');
    $req->execute(array($id));
    $modif = $req->fetch();

    return $modif[0];
  }
