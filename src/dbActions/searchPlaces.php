<?php

include_once ('config.php');
include_once ('placeUtils.php');

function showImage($id){

    global $db;
    $statement = $db->prepare('SELECT photo FROM PHOTO WHERE idProperty LIKE ? GROUP BY photo ORDER BY COUNT(*) DESC ');
    $statement->execute([$id]);
    $row = $statement->fetch();
    $fileName = $row['photo'];

    echo "<img src=" .$fileName. " />";
    
}





