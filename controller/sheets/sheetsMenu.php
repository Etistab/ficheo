<?php
require_once('model/sheets.php');
require_once ('controller/header.php');

function printSheetsByCategory($category){
    if($category == 'college' || $category == 'lycee') {
        $sheets = getActivatedSheetsByCategory($category);
    }
    else{
        $sheets = getInactiveSheets(true);
    }

    foreach ($sheets as $sheet ) {
      if ($sheet['active']==1) {
        echo "<ul class='fiche'>";
        echo "<li><a href=index.php?page=sheet&id=".$sheet['id']."><img src='public/images/".$sheet['discipline'].".jpg' class='cercle'  width='200' height='200'></a></li>";
        echo "<li>".$sheet["title"]. "</li>";
        echo "<li class='secret' >".$sheet["category"]."</li>";
        echo "<li class='secret' >".$sheet["discipline"]."</li>";
        echo "<li>Ecrit par <a href=\"index.php?page=user&user=".$sheet['author']."\">".$sheet["author"]. "</a></li>";
        echo "<li class='secret' >".$sheet["author"]."</li>";
        echo "<li class='secret' >".$sheet["date_creation"]."</li>";
        echo "</ul>";
      }
    }
}

if(isset($_GET['rech'])){
    if($_GET['rech'] == 'college'){
        $pageTitle = 'Les fiches niveau collège';
        $category = 'college';
    }
    elseif($_GET['rech'] == 'lycee'){
        $pageTitle = 'Les fiches niveau lycée';
        $category = 'lycee';
    }
    else{
        $pageTitle = 'Toutes les fiches';
        $category = 'all';
    }
}
else{
    $pageTitle = 'Toutes les fiches';
    $category = 'all';
}

require_once('view/sheets/sheetsMenu.php');
