<?php

include_once('user.php');
include_once('config.php');
include_once('placeUtils.php');

function sendReviewToPlace($idPlace, $user, $title, $userRate, $text, $date)
{
    $id_autor = getIdByUserName($user);
    $likes = 0;

    global $db;

    $statement = $db->prepare('INSERT INTO REVIEWS (idProperty, idUser, title, userRate, text, date, likes) VALUES (?,?,?,?,?,?,?);SELECT SCOPE_IDENTITY() as idReviews; RETURN;');

    if ($result = $statement->execute([$idPlace, $id_autor, $title, $userRate, $text, $date, $likes])) {
        $idRev = $db->lastInsertId();
        return $idRev;
    }
    return false;
}

function setRating($idPlace)
{
    global $db;
    $statement = $db->prepare('SELECT AVG(userRate) AS rating FROM (SELECT  userRate FROM REVIEWS WHERE idProperty LIKE ? GROUP BY userRate ORDER BY COUNT(*) DESC)');
    $statement->execute([$idPlace]);
    if ($row = $statement->fetch())
        $rating = floor($row['rating']);
    if (is_null($rating))
        $rating = 0;
    $statement1 = $db->prepare('UPDATE PROPERTY SET rate = ? WHERE idProperty = ?');
    $statement1->execute([$rating, $idPlace]);
}

function addPhotoToReview($name, $idRev, $idPlace)
{
    global $db;
    $statement1 = $db->prepare('INSERT INTO REVIEWPHOTO (name, idProperty, idReview) VALUES (?,?,?)');
    $statement1->execute([$name, $idPlace, $idRev]);
    return true;
}

function getPlaceReviews($idPlace, $idUser)
{
    global $db;
    $statement = $db->prepare('SELECT * FROM REVIEWS WHERE idProperty = ? ');
    $statement->execute([$idPlace]);

    while ($row = $statement->fetch())
    {

        $id = $row['idUser'];
        $idRev = $row['idReviews'];
        $userName = getUserNameById($id);
        $photoUser = "../assets/" . getUserPhoto($userName);
        $fullName = getUserInfoByUserName($userName, 'name');
        $userRate = $row['userRate'];
        $review = $row['text'];
        $htmlPhoto = '<img id="userPhotoReview" src=' . $photoUser . '>';

        echo '<div class="reviewContainer">';
            echo '<div class="reviewT">';
                echo '<div class="reviewPhoto">';
                echo $htmlPhoto;
                echo '</div>';
                echo '<div class="reviewTitle">';
                    echo '<div class="reviewTitleName">';
                    echo '<p>' . $fullName . '</p>';
                    echo '</div>';
                    printStarsRating($userRate);
                echo '</div>';
            echo '</div>';
            echo '<div class="reviewText">';
            echo '<p>' . $review . '</p>';
            echo '</div>';
            echo '<div class="reviewPhotos">';
            getReviewPhotos($idRev);
            echo '</div>';
            echo '<div class="reviewDate">';
            echo '<p>' . $row['date'] . '</p>';
            echo '</div>';
        echo '</div>';
        echo '<div class="reviewComments">';
        getAllCommentsOfReview($idRev);
        echo '</div>';
    
        if (isPlaceOwner($idUser, $idPlace) && isset($_SESSION["login-user"]))
        {
            echo '<br>';
            $button = "buttonAnswer" . $idRev;
            $name = "answer" . $idRev;
            $form = "form" . $idRev;

            echo '<br>' . '<button class="buttonAnswer" id=' . $button . ' onclick=openAnswerForm("' . $idRev . '");>Answer</button>';
            echo '<form id=' . $form . ' action="../dbActions/reviewAnswer.php?id=' . $id . '&idRev=' . $idRev . '" hidden="hidden" method="post">';
            echo '<input class="answerReviewTextArea" type="search" name=' . $name . '><br>';
            echo '<input class="buttonReviewAnswer" type="submit" value="Submit">';
            echo '</form>';
        }

    }

    return true;
}

function getAllCommentsOfReview($idRev)
{
    global $db;

    $statement = $db->prepare('SELECT * FROM COMMENTS WHERE idReview = ? ');
    $statement->execute([$idRev]);
    
    while ($row = $statement->fetch()) {
        echo '<p>' . $row['text'] . '</p>';
        echo '<p>' . $row['date'] . '</p>';
    }

    return true;
}

function getReviewPhotos($idRev)
{
    global $db;
    $statement = $db->prepare('SELECT * FROM REVIEWPHOTO WHERE idReview = ? ');
    $statement->execute([$idRev]);

    while ($row = $statement->fetch()) {
        $photoDir = $row['name'];
        echo "<img src=$photoDir onclick=\"window.open(this.src)\">";
    }

    return true;
}

function addCommentToReview($idRev, $id_autor, $text, $currentDate)
{
    $likes = 0;

    global $db;

    $statement = $db->prepare('INSERT INTO COMMENTS (idReview, idUser, text, "date", likes) VALUES (?,?,?,?,?)');

    if ($statement->execute([$idRev, $id_autor, $text, $currentDate, $likes])) {
        return true;
    }
    return false;
}


?>