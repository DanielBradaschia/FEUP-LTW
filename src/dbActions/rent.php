<script src="../js/main.js"></script>

<?php

include_once 'user.php';
include_once 'placeUtils.php';

$moveIn = htmlspecialchars($_POST['checkIn']);
$moveOut = htmlspecialchars($_POST['checkOut']);
$idUser = getIdUserByEmail(htmlspecialchars($_SESSION['login-user']));
$payment = htmlspecialchars($_POST['payment']);
$idProperty = htmlspecialchars($_SESSION['restID']);
$price = getPropertyInfoById($idProperty, 'price');
//$idProperty = 3;
//$price = 70;

/*if ($_SESSION['signup-token'] !== $_POST['signup-token']) {
    header('HTTP/1.0 403 Forbidden');
    die();
}
$_SESSION['token'] = generate_random_token();*/

if($moveIn && $moveOut){
    if($moveIn < $moveOut){
        if($payment != 'Select'){
            rent($idUser, $idProperty, $moveIn, $moveOut, $payment, $price);
        }
        else {
            echo 'Must select a payment method';
        }
    }
}

/*if($email && $password){
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
}*/

function rent($idUser, $idProperty, $moveIn, $moveOut, $payment, $price){
    global $db;

    $email = getUserInfo($idUser, 'email');

    $statement = $db->prepare('INSERT INTO RENT (idUser, idProperty, moveIn, moveOut, payment, rate, price) VALUES (?,?,?,?,?,?,?)');

    if($statement->execute([$idUser, $idProperty, $moveIn, $moveOut, $payment, NULL, $price])){
        $_SESSION['login-user']=$email;
        unset($_SESSION["ERROR"]);
        header("location:../pages/index.php");
        exit();
    }
    else{
        echo $email;
        $_SESSION["ERROR"] = "Error on rent";
    }
}