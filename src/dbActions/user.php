<?php
session_start();
include_once('config.php');


function login($email, $password) {
    global $db;
    $statement = $db->prepare('SELECT idUser,password,name FROM USER WHERE email = ? ');
    $statement->execute([$email]);

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $hashed_password = $result['password'];

    if(password_verify($password, $hashed_password)){
        $_SESSION['login-user']=$email;
        unset($_SESSION["ERROR"]);
        header("location:../pages/index.php");
        exit();
    }
    else {
        $_SESSION["ERROR"] = "Incorrect Password or Username, try again!";
        header("Location:".$_SERVER['HTTP_REFERER']."");
        exit();
    }
}

function signUp($email, $name, $type, $password, $gender, $bithdate, $cellphone){
    global $db;

    if(strtoupper($gender)=='F')
        $photo = 'photo0F.jpg';
    else $photo = 'photo0.jpg';

    $statement = $db->prepare('INSERT INTO USER (name, password, email, gender, birthdate, cellphone, profilePicture, type) VALUES (?,?,?,?,?,?,?,?)');

    if($statement->execute([$name, password_hash($password, PASSWORD_DEFAULT), $email, $gender, $bithdate, $cellphone, $photo, $type])){
        $_SESSION['login-user']=$email;
        unset($_SESSION["ERROR"]);
        header("location:../pages/index.php");
        exit();
    }
    else{
        echo $email;
        $_SESSION["ERROR"] = "Error on sign Up";
    }
}

function getUserInfo($idUser,$info){
    if($info == 'password')
        return null;

    global $db;
    $statement = $db->prepare('SELECT * FROM USER WHERE idUser = ? ');
    $statement->execute([$idUser]);
    return $statement->fetch()[$info];
}

function getIdByUserName($email){
    global $db;
    $statement = $db->prepare('SELECT idUser FROM USER WHERE email = ? ');
    $statement->execute([$email]);
    return $statement->fetch()['idUser'];
}

function getUserNameById($idUser){
    global $db;
    $statement = $db->prepare('SELECT email FROM USER WHERE idUser = ? ');
    $statement->execute([$idUser]);
    return $statement->fetch()['email'];
}

function getUserInfoByUserName($email,$info){
    if($info == 'password')
        return null;

    global $db;
    $statement = $db->prepare('SELECT * FROM USER WHERE email = ? ');
    $statement->execute([$email]);

    return $statement->fetch()[$info];
}

function updateUserProfile($email,$newEmail,$newName,$data,$gender,$newCellphone){

    if(!trim($newName))
        $newName = getUserInfoByUserName($email,'name');


    if(trim($newEmail))
        if(!usernameAlreadyExists($newEmail))
            $_SESSION['login-user']=$newEmail;
        else return false;
    else $newEmail = $email;

    if(!trim($data))
        $data = getUserInfoByUserName($email,'birthdate');

    if(strtoupper($gender) == strtoupper(getUserInfoByUserName($email,'gender'))){
        $photo = getUserInfoByUserName($email,'profilePicture');
    }
    else{
        if(strtoupper($gender) == 'M')
            $photo = 'photo0.jpg';
        else $photo = 'photo0F.jpg';
    }

    global $db;
    $statement = $db->prepare('UPDATE USER SET email = ?, name = ? , birthdate= ?, gender= ?, profilePicture= ?, cellphone = ? WHERE email = ?');
    $statement->execute([$newEmail,$newName,$data,$gender,$photo,$newCellphone,$email]);
    return $statement->errorCode();
}

function usernameAlreadyExists($email){
    global $db;
    $statement = $db->prepare('SELECT * FROM USER WHERE email = ?');
    $statement->execute([$email]);
    return $statement->fetch();
}

function uploadUserPhoto($email){
    global $db;
    $idPhoto = 'photo'.getUserInfoByUserName($email,'idUser').'.jpg';
    $statement = $db->prepare('UPDATE USER SET profilePicture = ? WHERE email = ?');
    $statement->execute([$idPhoto,$email]);
    return $statement->errorCode();
}

function validatePassword($password){
    if(strlen($password) >= 6)
        return true;

    return false;
}

function getUserPhoto($email){
    global $db;
    $statement = $db->prepare('SELECT prodilePicture FROM USER WHERE email = ?');
    $statement->execute([$email]);
    return $statement->fetch()['profilePicture'];
}


function generate_random_token() {
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    return $token;
}
