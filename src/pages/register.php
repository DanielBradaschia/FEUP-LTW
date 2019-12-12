<?php

include_once 'user.php';

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$name = htmlspecialchars($_POST['name']);
$bithdate = htmlspecialchars($_POST['birthdate']);
$type = htmlspecialchars($_POST['type']);
$gender = htmlspecialchars($_POST['gender']);
$cellphone = htmlspecialchars($_POST['cellphone']);

if ($_SESSION['signup-token'] !== $_POST['signup-token']) {
    header('HTTP/1.0 403 Forbidden');
    die();
}
$_SESSION['token'] = generate_random_token();

if($email && $password){
    if(!usernameAlreadyExists($email)){
        if(validatePassword($password))
            signUp($email, $name, $type, $password, $gender, $bithdate, $cellphone);
        else {
            header("Location:".$_SERVER['HTTP_REFERER']."");
            $_SESSION["ERROR"] = "Password must be at least 6 characters.";
        }
    }
    else {
        header("Location:".$_SERVER['HTTP_REFERER']."");
        $_SESSION["ERROR"] = "Choose a different email address. This one is not available. If this is you log in now.";
    }
}
else{
    header("Location:".$_SERVER['HTTP_REFERER']."");
    $_SESSION["ERROR"] = "You must fill at least Email and Password Field ! ";
}