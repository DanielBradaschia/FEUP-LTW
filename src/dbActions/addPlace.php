<?php

include_once ('config.php');
include_once ('placeUtils.php');
include_once ('user.php');


$placeTitle = htmlspecialchars($_POST['title']);
$placeAddress = htmlspecialchars($_POST['address']);
$price = htmlspecialchars($_POST['price']);
$description = htmlspecialchars($_POST['description']);
$username = htmlspecialchars($_SESSION['login-user']);

if(placeAlreadyExists($placeAddress))
{
    header("Location:".$_SERVER['HTTP_REFERER']."");
    $_SESSION["ERROR"] = "This address is already registered for rental!";
}

addPlaceToUser($placeTitle, $placeAddress, $price, $description, getUserInfoByUserName($username, 'idUser'));

for ($i = 0; $i < count($_FILES['fileToUpload']['name']); $i++) {
    $j = 0; //Variable for indexing uploaded image
    $target_path = "../assets/"; //Declaring Path for uploaded images
    $validextensions = array("jpeg", "jpg", "png"); //Extensions which are allowed
    $ext = explode('.', basename($_FILES['fileToUpload']['name'][$i])); //explode file name from dot(.)
    $file_extension = end($ext); //store extensions in the variable

    $target_path = $target_path.md5(uniqid()). ".".$ext[count($ext) - 1]; //set the target path with a new name of image
    $j = $j + 1; //increment the number of uploaded images according to the files in array

    if (($_FILES["fileToUpload"]["size"][$i] < 100000) && in_array($file_extension, $validextensions)) {
        $target_file = $target_path.$_FILES["fileToUpload"]["name"][$i];
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i],$target_file);
        uploadPhoto($target_file,getPropertyInfoByAddress($placeAddress,'idProperty'));
    }
}

header('Location: ../pages/profile.php');
