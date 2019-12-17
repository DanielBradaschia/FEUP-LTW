<?php
include_once('config.php');

function getRentsByProperty($idProperty)
{
    global $db;

    $stmt = $db->prepare('SELECT * FROM RENT WHERE idProperty = ?');
    $stmt->execute([$idProperty]);

    return $stmt->fetchAll();
}

function getRentsByUser($idUser)
{
    global $db;

    $stmt = $db->prepare('SELECT * FROM RENT WHERE idUser = ?');
    $stmt->execute([$idUser]);

    return $stmt->fetchAll();
}


