<?php
require_once ("model/db_connect.php");

function addMark($mark, $sheet, $idUser){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO marks(mark, dateMark, sheet, idUser) VALUES(:mark, NOW(), :sheet, :idUser)');
    $affectedLines = $req->execute(array(
        'mark' => $mark,
        'sheet' => $sheet,
        'idUser'=> $idUser
    ) );
    return $affectedLines;
}

function checkMarkCommentByUser($idUser,$idComment){
    $db = dbConnect();
    $req = $db->prepare('SELECT idUser FROM markcomment WHERE idUser=:idUser AND comments=:comments');
    $req->execute(array(
        'idUser'=>$idUser,
        'comments'=>$idComment
    ));

    $user=$req->fetch();

    return $user;
}

function checkMarkByUser($idUser,$sheet){
    $db = dbConnect();
    $req = $db->prepare('SELECT idUser FROM marks WHERE idUser=:idUser AND sheet=:sheet');
    $req->execute(array(
        'idUser'=>$idUser,
        'sheet'=>$sheet
    ));

    $pseudo=$req->fetch();

    return $pseudo;
}

function getMarksBySheet($sheet){
    $db=dbConnect();
    $req=$db->prepare('SELECT mark FROM marks WHERE sheet=:sheet');
    $req->execute(array(
        'sheet'=>$sheet
    ));
    $marks=$req->fetchall();

    return $marks;

}
function getCommentAvg($id){
  $db = dbConnect();
  $req = $db->prepare('SELECT avg(mark) as average FROM markcomment WHERE comments=:comment');
  $req->execute(array(
    'comment' => $id
  ));
  $mark =$req->fetch();

  return $mark;
}

function getMarksByCom($comment){
    $db=dbConnect();
    $req=$db->prepare('SELECT mark FROM markcomment WHERE comments=:comment');
    $req->execute(array(
        'comment'=>$comment
    ));
    $marks=$req->fetchall();

    return $marks;
}

function getNoteComment($comment){
    $marks = getMarksByCom($comment);
    $count = 0;
    if (!$marks) {
        $count = 0;
    }elseif ($marks) {
        foreach ($marks as $mark) {
            $count++;
        }
    }

    return $count;
}

function addMarkComment($mark, $idComment, $idUser){
    $db = dbConnect();
    $req=$db->prepare('INSERT INTO markcomment(mark, dateMark, comments, idUSer) values(:mark, NOW(), :comments, :idUser )');
    $affectedLines = $req->execute(array(
                            'mark'=>$mark,
                            'comments'=>$idComment,
                            'idUser'=>$idUser
    ) );

    return $affectedLines;
}
