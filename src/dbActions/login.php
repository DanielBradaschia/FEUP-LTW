<?php

include_once 'user.php';

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

if($email && $password)
    login($email,$password);
