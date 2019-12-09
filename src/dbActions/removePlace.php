<?php

include_once ('config.php');
include_once ('placeUtils.php');
include_once ('user.php');


$id = htmlspecialchars($_POST['deleteItem']);

removePlace($id);

header('Location: ../pages/profile.php');
