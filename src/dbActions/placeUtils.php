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

function getPropertyIdByTitle($title)
{
    global $db;
    $statement = $db->prepare('SELECT idProperty FROM PROPERTY WHERE title = ? ');
    $statement->execute([$title]);
    $res = $statement->fetch();
    return $res[0];
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

function updatePlaceInfo($id,$placeName,$placeAddress,$placeDescription,$placePrice)
{
   if (!trim($placeName))
        $placeName = getPropertyInfoById($id, 'name');


    if (!trim($placeAddress))
        $placeAddress = getPropertyInfoById($id, 'address');

    if (!trim($placeDescription))
        $placeDescription = getPropertyInfoById($id, 'description');

    if (!trim($placePrice)) {
        $placePrice = getPropertyInfoById($id, 'price');
    }

    global $db;
    $statement = $db->prepare('UPDATE PROPERTY SET address = ?, title= ?, price= ?, description= ? WHERE idProperty = ?');
    $statement->execute([$placeAddress, $placeName, $placePrice, $placeDescription, $id]);
    return $statement->errorCode();
}

function removePlace($id)
{
    global $db;
    $statement = $db->prepare('DELETE FROM PROPERTY WHERE idProperty = ?');
    if ($statement->execute([$id])) {
        return true;
    }
    return false;
}

function isPlaceOwner($userId, $placeId)
{
    global $db;
    $statement = $db->prepare('SELECT idOwner FROM PROPERTY WHERE idProperty = ? ');
    $statement->execute([$placeId]);
    $res = $statement->fetch()['idOwner'];

    if ($res == $userId)
        return true;

    return false;
}
function getPlace($name, $priceMin, $priceMax, $rating, $location)
{
    global $db;
    $namekeywords = explode('%20', $name);
    $namestring = '%' . implode('% OR LIKE %', $namekeywords) . '%';
    $locationkeywords = explode('%20', $location);
    $locationstring = '%' . implode('% OR LIKE %', $locationkeywords) . '%';
    $ratingkeywords = explode('%20', $rating);
    $ratingstring = '%' . implode('% OR LIKE %', $ratingkeywords) . '%';

    $stmt = $db->prepare("SELECT * FROM PROPERTY WHERE title LIKE ? AND address LIKE ? AND rate LIKE ? AND price BETWEEN ? AND ?;");
    $stmt->execute([$namestring, $location, $ratingstring, $priceMin, $priceMax]);

    return $stmt->fetchAll();
}

function showFirstPlaceImage($idPlace)
{

    global $db;
    $statement = $db->prepare('SELECT  title FROM PROPERTY WHERE  idProperty= ?');
    $statement->execute([$idPlace]);
    $row = $statement->fetch();
    $fileName = $row['name'];

    if (!trim($fileName)) {
        $fileName = "../assets/default_house.png";
        echo "<img src=" . $fileName . " />";
    }

    echo "<img src=" . $fileName . " />";
}
