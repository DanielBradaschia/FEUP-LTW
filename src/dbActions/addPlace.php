<?php

include_once ('config.php');
include_once ('placeUtils.php');


$placeTitle = htmlspecialchars($_POST['title']);
$placeAddress = htmlspecialchars($_POST['address']);
$price = htmlspecialchars($_POST['price']);
$description = htmlspecialchars($_POST['description']);

if(placeAlreadyExists($placeAddress))
{
    header("Location:".$_SERVER['HTTP_REFERER']."");
    $_SESSION["ERROR"] = "This address is already registered for rental!";
}
else
    addPlaceToUser($placeTitle, $placeAddress, $price, $description);

header('Location: ../pages/profile.php');
