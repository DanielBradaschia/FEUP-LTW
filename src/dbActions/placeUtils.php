<?php
include_once('config.php');
include_once('rentUtils.php');

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

    $statement = $db->prepare('INSERT INTO PROPERTY (idOwner, address, title, price, description, rate) VALUES (?,?,?,?,?,?)');
    if($statement->execute([$id, $address, $title, $price, $description,0])){
        return true;
    }
    else
        $_SESSION["ERROR"] = "Error registering place";

}

function getPlaceByOwnerId($id){
        global $db;
        $statement = $db->prepare('SELECT * FROM PROPERTY WHERE IdOwner = ? ');
        $statement->execute([$id]);
    /*
        while ($row = $statement->fetch()) {
            echo '<div class="placeList">';
            echo '<a href="place.php?id=' . $row['idProperty'] . '">' . $row['title'] . '</a>';
            echo '</div>';
        }
    */
        return $statement->fetchAll();
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
function getPlace($name, $priceMin, $priceMax, $rateMin, $rateMax, $location)
{
    global $db;
    $namekeywords = explode('%20', $name);
    $namestring = '%' . implode('% OR LIKE %', $namekeywords) . '%';
    $locationkeywords = explode('%20', $location);
    $locationstring = '%' . implode('% OR LIKE %', $locationkeywords) . '%';

    $stmt = $db->prepare("SELECT * FROM PROPERTY WHERE title LIKE ? AND address LIKE ? AND (price BETWEEN ? AND ?) AND (rate BETWEEN ? AND ?)");
    //$stmt = $db->prepare("SELECT * FROM PROPERTY WHERE price BETWEEN ? AND ?;");
    $stmt->execute([$namestring, $locationstring, $priceMin, $priceMax, $rateMin, $rateMax]);
    return $stmt->fetchAll();

}

function setURL($name, $priceMin, $priceMax, $rating, $location)
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

    while ($row = $stmt->fetch()) {
        echo "<a class='servicesLink' onclick=\"href='searchPlaces.php?place=$name&priceMin=$priceMin&priceMax=$priceMax&rating=$rating&location=$location';\"></a><br>";
    }


}

function showFirstPlaceImage($idPlace)
{
    global $db;
    $statement = $db->prepare('SELECT photo FROM PHOTO WHERE  idProperty= ?');
    $statement->execute([$idPlace]);
    $row = $statement->fetch();
    $fileName = $row['photo'];

    if (!trim($fileName)) {
        $fileName = "../assets/default_house.png";
        echo "<img src=" . $fileName . " />";
    }
    else
        echo "<img src=" . $fileName . " />";
}

function printStarsRating($stars)
{
    $i = 1;
    $j = 1;
    $temp = 5 - $stars;

    echo '<div class = "placeRatingStars">';

    for ($i; $i <= $stars; $i++) {
        echo '<div class = "star">' . '</div>';
    }

    for ($j; $j <= $temp; $j++) {
        echo '<div class = "blackStar">';
        echo '</div>';
    }

    echo '</div>';

    return true;
}

