<?php
session_start();
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

function addPlaceToUser($title, $address, $price, $description){
    global $db;

    $statement = $db->prepare('INSERT INTO PROPERTY (address, title, price, description) VALUES (?,?,?,?)');
    if($statement->execute([$address, $title, $price, $description])){
        header('Location: ../pages/profile.php');
        exit();
    }
    else
        $_SESSION["ERROR"] = "Error registering place";

}