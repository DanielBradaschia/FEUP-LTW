<?php

//session_start();
//session_regenerate_id(true);
include_once "config.php";
include_once "placeUtils.php";
include_once "user.php";

// If the user didn't come from the edit place page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    die();
}
$_SESSION['token'] = generate_random_token();

$placeName = htmlspecialchars($_POST['placeTitle']);
$placeAddress = htmlspecialchars($_POST['placeAddress']);
$placeDescription = htmlspecialchars($_POST['placeDescription']);
$placePrice = htmlspecialchars($_POST['placePrice']);
$id = htmlspecialchars($_SESSION["restID"]);

updatePlaceInfo($id,$placeName,$placeAddress,$placeDescription,$placePrice);

header("Location:".$_SERVER['HTTP_REFERER']."");