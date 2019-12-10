<?php
//session_start();
//session_regenerate_id(true);
?>
<!DOCTYPE html>
    <?php

    include_once "header.php";
    include_once "../dbActions/placeUtils.php";
    $place = "";
    $priceMin = 0;
    $priceMax = 2000;
    $rating = "";
    $location = "";
    if (preg_match("/[a-zA-Z]/", $_GET['place'])) {
        $place = $_GET['place'];
    }
    if (preg_match("/[a-zA-Z]/", $_GET['location'])) {
        $location = $_GET['location'];
    }
    if (preg_match("/[a-zA-Z0-9]/", $_GET['priceMin'])) {
        $priceMin = $_GET['priceMin'];
    }
    if (preg_match("/[a-zA-Z0-9]/", $_GET['priceMax'])) {
        $priceMax = $_GET['priceMax'];
    }
    if (preg_match("/[a-zA-Z0-9]/", $_GET['rating'])) {
        $rating = $_GET['rating'];
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
                    setURL($name, $priceMin, $priceMax, $rating, $location);
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
            $result = getPlace($place, $priceMin, $priceMax, $rating, $location);
            foreach ($result as $row) {
                echo "<div class=\"container\">";

                $placeTitle = $row['title'];
                $placeAddress = $row['location'];
                $placePrice = $row['price'];
                $restRating = $row['rate'];
                $id = getPropertyIdByTitle($placeTitle);

                echo '<div class="row">';

                echo '<div class="contentPhoto">';
                showFirstPlaceImage($id);
                echo '</div>';
                echo "<h2 onclick=\"location.href='place.php?id=$id';\">" . $placeName . "</h2>";
                echo '<br>'.'</br>';
                echo '<br>'.'</br>';
                echo "<h3>" .$placeLocation."</h3>";
                echo '<br>'.'</br>';
                echo "<h1>".$placeAddress."</h1>";
                echo '<br>'.'</br>';
                echo '</div>';
                echo '<div class="row">';
                echo '<br>'.'</br>';
                echo '<br>'.'</br>';

                echo "<h4> Cost for Two:</h4>";

                $temp = ' - ';

                echo '<h1>'.$placePrice."€".'</h1>';
                echo '<br>'.'</br>';

                echo '<br>'.'</br>';

                echo '</div>';
                echo "</div>";
            }
            ?>

        </div>
    </div>


<?php
include_once "footer.php";
?>