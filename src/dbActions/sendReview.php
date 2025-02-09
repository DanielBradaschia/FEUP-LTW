<?php
session_start();
session_regenerate_id(true);
include_once ('reviewUtils.php');
include_once ('user.php');

if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    die();
}
$_SESSION['token'] = generate_random_token();


$rate=0;


$title = htmlspecialchars($_POST['title']);
$review = htmlspecialchars($_POST['review']);
$rate = htmlspecialchars($_POST['rate']);
$user = htmlspecialchars($_SESSION['login-user']);
$idPlace = htmlspecialchars($_SESSION['restID']);

date_default_timezone_set('UTC');
$currentDate =  date("Y/m/d h:i:s");
$rate = htmlspecialchars($_POST['rating']);

$idRev = sendReviewToPlace($idPlace,$user,$title,$rate,$review,$currentDate);
setRating($idPlace);


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
        addPhotoToReview($target_file,$idRev,$idPlace);
    }
}

header("Location:".$_SERVER['HTTP_REFERER']."");