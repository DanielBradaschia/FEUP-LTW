<?php
session_start();
session_regenerate_id(true);
include_once 'user.php';


if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    die();
}
$_SESSION['token'] = generate_random_token();
$newEmail = htmlspecialchars($_POST['email']);
$newName = htmlspecialchars($_POST['name']);
$userName = htmlspecialchars($_SESSION['login-user']);
$data = htmlspecialchars($_POST['birthdate']);
$gender = htmlspecialchars($_POST['gender']);
$cellphone = htmlspecialchars($_POST['cellphone']);
$password = htmlspecialchars($_POST['password']);

updateUserProfile($userName,$newEmail,$newName,$data,$gender, $cellphone, $password);

header('Location: ../pages/profile.php');
