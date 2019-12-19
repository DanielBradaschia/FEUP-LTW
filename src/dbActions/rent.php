<script type="text/javascript" src="../js/main.js" language="javascript" >
  var data = actualDate();
  </script>

<?php

include_once 'user.php';
include_once 'placeUtils.php';
include_once 'rentUtils.php';

$moveIn = htmlspecialchars($_POST['checkIn']);
$moveOut = htmlspecialchars($_POST['checkOut']);
$idUser = getIdUserByEmail(htmlspecialchars($_SESSION['login-user']));
$payment = htmlspecialchars($_POST['payment']);
$idProperty = htmlspecialchars($_SESSION['restID']);
$price = getPropertyInfoById($idProperty, 'price');

if($moveIn && $moveOut){
    if($moveIn < $moveOut){
        if($payment != 'Select'){
            rent($idUser, $idProperty, $moveIn, $moveOut, $payment, $price);
        }
        else {
            header("Location:".$_SERVER['HTTP_REFERER']."");
            $_SESSION["ERROR"] = "You must select a payment method";
        }
    }
    else {
        header("Location:".$_SERVER['HTTP_REFERER']."");
        $_SESSION["ERROR"] = "Error in dates";
    }
}
else {
    header("Location:".$_SERVER['HTTP_REFERER']."");
        $_SESSION["ERROR"] = "Please select Check in date and Check out date";
}

function rent($idUser, $idProperty, $moveIn, $moveOut, $payment, $price){
    global $db;

    $email = getUserInfo($idUser, 'email');
    $check = true;
    $rent = getRentsByProperty($idProperty);

    foreach ($rent as $row) {
        $checkin = $row['moveIn'];
        $checkout = $row['moveOut'];

        if($checkin <= $moveOut && $checkout > $moveIn){
            $check = false;
            break;
        }
    }

    if($check == true){
        $statement = $db->prepare('INSERT INTO RENT (idUser, idProperty, moveIn, moveOut, payment, price) VALUES (?,?,?,?,?,?)');

        if($statement->execute([$idUser, $idProperty, $moveIn, $moveOut, $payment, $price])){
            $_SESSION['login-user']=$email;
            unset($_SESSION["ERROR"]);
            header("location:../pages/index.php");
            exit();
        }
        else{
            header("Location:".$_SERVER['HTTP_REFERER']."");
            $_SESSION["ERROR"] = "Error on rent";
        }
    } else {
        header("Location:".$_SERVER['HTTP_REFERER']."");
        $_SESSION["ERROR"] = "Invalid Dates";
    }
}