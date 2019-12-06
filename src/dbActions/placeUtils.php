<?php
include_once('config.php');

function placeAlreadyExists($address){
    global $db;

    $statement = $db->prepare('SELECT * FROM PROPERTY WHERE address = ?');
    $statement->execute([$address]);

    $result = $statement->fetchAll();

    if(count($result)>0)
        return true;
    else
        return false;
}

function addPlaceToUser($title, $address, $price, $description, $id){
    global $db;

    $statement = $db->prepare('INSERT INTO PROPERTY (idOwner, address, title, price, description) VALUES (?,?,?,?,?)');
    if($statement->execute([$id, $address, $title, $price, $description])){
        return true;
    }
    else
        $_SESSION["ERROR"] = "Error registering place";

}

function getPlaceByOwnerId($id){
        global $db;
        $statement = $db->prepare('SELECT * FROM PROPERTY WHERE IdOwner = ? ');
        $statement->execute([$id]);

        while ($row = $statement->fetch()) {
            echo '<div class="placeList">';
                echo '<a href="place.php?id=' . $row['idProperty'] . '">' . $row['title'] . '</a>';
            echo '</div>';
        }
        return true;
}

function uploadPhoto($target_file, $id)
{
    global $db;
    $statement = $db->prepare('INSERT INTO PHOTO (idProperty, photo) VALUES (?,?)');
    if ($statement->execute([$id, $target_file])) {
        return true;
    }
    return false;
}

function getPropertyInfoById($idProperty, $info)
{
    global $db;
    $statement = $db->prepare('SELECT * FROM PROPERTY WHERE idProperty = ? ');
    $statement->execute([$idProperty]);

    return $statement->fetch()[$info];
}

function getPropertyInfoByAddress($address, $info)
{
    global $db;
    $statement = $db->prepare('SELECT * FROM PROPERTY WHERE address = ? ');
    $statement->execute([$address]);

    return $statement->fetch()[$info];
}

function getPlacePhotos($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM PHOTO WHERE idProperty=?');
    $stmt->execute([$id]);

    $ret = false;

    while ($row = $stmt->fetch()) {
        echo '<img class="mySlides" src=' . $row['photo'] . ' hidden="hidden">';
        $ret = true;
    }

    return $ret;
}
