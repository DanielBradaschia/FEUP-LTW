<?php
//session_start();
//session_regenerate_id(true);
?>
<!DOCTYPE html>
    <?php

    include_once "header.php";
    include_once "../dbActions/placeUtils.php";
    include_once "../dbActions/rentUtils.php";
    $place = "";
    $moveIn = "";
    $moveOut = "";
    $priceMin = 0;
    $priceMax = 2000;
    $rateMin = 0;
    $rateMax = 5;
    $rating = "";
    $location = "";
    if(!empty($_GET['place'])){
        if (preg_match("/[a-zA-Z]/", $_GET['place'])) {
            $place = $_GET['place'];
        }
    }
    if(!empty($_GET['movein'])){
        $moveIn = $_GET['movein'];
    }
    if(!empty($_GET['moveout'])){
        $moveOut = $_GET['moveout'];
    }
    if(!empty($_GET['place'])){
        if (preg_match("/[a-zA-Z]/", $_GET['place'])) {
            $place = $_GET['place'];
        }
    }
    if(!empty($_GET['location'])){
        if (preg_match("/[a-zA-Z]/", $_GET['location'])) {
            $location = $_GET['location'];
        }
    }
    if(!empty($_GET['priceMin'])){
        if (preg_match("/[a-zA-Z0-9]/", $_GET['priceMin'])) {
            $priceMin = $_GET['priceMin'];
        }
    }
    if(!empty($_GET['priceMax'])){
        if (preg_match("/[a-zA-Z0-9]/", $_GET['priceMax'])) {
            $priceMax = $_GET['priceMax'];
        }
    }
    if(!empty($_GET['rateMin'])){
        if (preg_match("/[a-zA-Z0-9]/", $_GET['rateMin'])) {
            $rating = $_GET['rateMin'];
        }
    }
    if(!empty($_GET['rateMax'])){
        if (preg_match("/[a-zA-Z0-9]/", $_GET['rateMax'])) {
            $rating = $_GET['rateMax'];
        }
    }


    ?>
    <div class="searchBarContainer">
        <?php
        include "../dbActions/searchBar.php";
        ?>
    </div>
    <div class="placeSearchPage">
        <div class="advancedSearch">
            <div class="container">
                <section class="filters">
                    <?php
                    setURL($place, $priceMin, $priceMax, $rating, $location);
                    ?>
                    <h2>Price</h2>
                    <p>
                        <label for="amount">Price range:</label>
                        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    </p>
                    <?php
                        echo "<div id=\"slider-range\" min=\"" . $priceMin . "\" max=\"" . $priceMax . "\"></div>";
                    ?>
                    <label id="minValue"></label>
                    <label id="maxValue"></label>
                </section>
            </div>
        </div>
        <div class="main">
            <?php
            $result = getPlace($place, $priceMin, $priceMax, $rateMin, $rateMax, $location);
            foreach ($result as $row) {
                echo "<div class=\"container\">";

                $placeTitle = $row['title'];
                $placeAddress = $row['address'];
                $placePrice = $row['price'];
                $placeDescription = $row['description'];
                $restRating = $row['rate'];
                $id = getPropertyInfoByAddress($placeAddress, 'idProperty');

                $check = true;
                $rent = getRentsByProperty($id);

                foreach ($rent as $row) {
                    $checkin = $row['moveIn'];
                    $checkout = $row['moveOut'];

                    if($checkin <= $moveOut && $checkout > $moveIn){
                        $check = false;
                        break;
                    }
                }

                if($check == true){
                    echo '<div class="row">';

                    echo '<div class="contentPhoto">';
                    showFirstPlaceImage($id);
                    echo '</div>';
                    echo "<h2 onclick=\"location.href='place.php?id=$id';\">" . $placeTitle . "</h2>";
                    echo '<br>'.'</br>';
                    echo '<br>'.'</br>';
                    echo "<h4> Address:</h4>";
                    echo "<h1>".$placeAddress."</h1>";
                    echo '<br>'.'</br>';
                    echo "<h4> Description:</h4>";
                    echo "<h1>".$placeDescription."</h1>";
                    echo '</div>';
                    echo '<div class="row">';
                    echo "<h4> Price:</h4>";
                    $temp = ' - ';
                    echo '<h1>'.$placePrice."€".'</h1>';
                    printStarsRating($restRating);
                    echo '<br>'.'</br>';
                    echo '</div>';
                    echo "</div>";
                }
            }
            ?>

        </div>
    </div>


<?php
include_once "footer.php";
?>