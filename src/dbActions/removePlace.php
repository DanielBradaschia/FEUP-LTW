<?php

include_once ('config.php');
include_once ('placeUtils.php');
include_once ('user.php');


$placeTitle = htmlspecialchars($_POST['title']);
$placeAddress = htmlspecialchars($_POST['address']);
$price = htmlspecialchars($_POST['price']);
$description = htmlspecialchars($_POST['description']);
$username = htmlspecialchars($_SESSION['login-user']);

removePlace();

header('Location: ../pages/profile.php');
