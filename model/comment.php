<?php
require_once ("model/db_connect.php");

function getCommentsBySheet($sheet){
    $db = dbConnect();
    $req = $db->prepare('SELECT comments.id as id, comments.content as content, users.pseudo as author,comments.author as idAuthor, dateCom, comments.sheets as sheets FROM comments, users where sheets=:sheet and comments.isDeleted = 0 and comments.author = users.id ');
    $req->execute(array('sheet'=>$sheet));

    return $req;
}
function getCommentById($id){
    $db = dbConnect();
    $req = $db->prepare('SELECT users.pseudo AS author, comments.author AS idAuthor, dateCom, comments.sheets AS sheet FROM comments, users WHERE comments.id=:id AND comments.author = users.id ');
    $req->execute(array(
        'id' => $id
    ));
    $comment = $req->fetch();

    return $comment;
}

function addComment($content, $pseudo, $sheet){

	$db=dbConnect();
	$req = $db->prepare('INSERT INTO comments(content, author, dateCom, sheets) VALUES(:content, :author, NOW(), :sheets)');
	$affectedLines = $req->execute(array(
		'content' => $content,
		'author' => $pseudo,
		'sheets' => $sheet
	) );
	return $affectedLines;
}

function deleteComment($idCom){
    $db=dbConnect();
    $req=$db->prepare('UPDATE comments set isDeleted=1 where id=:id');
    $req->execute(array(
        'id'=>$idCom
    ));
}
