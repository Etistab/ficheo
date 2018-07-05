<?php

$db = new PDO('mysql:host=localhost;dbname=ficheo;charset=utf8', 'root', '');
  $req=$db->prepare('SELECT mark FROM quizmarks WHERE users=:users AND quiz=:quiz');
  $req->execute(array(
    'users'=>$_POST['user'],
    'quiz'=>$_POST['user']
  ));
  $test = $req->fetch();
  echo $test[0]['mark'];
  if (empty($test[0])) {
    $req2= $db->prepare('INSERT INTO quizmarks(users,quiz,mark) VALUES (:users, :quiz, :mark)' );
    $req2->execute(array(
      'users'=> $_POST['user'],
      'quiz'=>$_POST['quiz'],
      'mark'=>$_POST['mark']
    ));
  }else{
    $req3=$db->prepare('UPDATE quizmarks set mark= :mark WHERE users=:users AND quiz=:quiz');
    $req3->execute(array(
      'users'=>$_POST['user'],
      'quiz'=>$_POST['quiz'],
      'mark'=>$_POST['mark']
    ));
  }
