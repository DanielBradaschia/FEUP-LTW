<?php
//session_start();
//session_regenerate_id(true);
?>
    <!DOCTYPE html>
    <?php
    $title = "Welcome";
    include_once "header.php";
    include_once "../dbActions/placeUtils.php";
    //include_once "../dbActions/reviewsUtils.php";
    $_SESSION['token'] = generate_random_token();
    $id = $_GET["id"];
    $userId = $_SESSION['login-user'];
    $_SESSION['restID'] = $id;
    $namePlace = getPropertyInfoById($id, 'title');
    $location = getPropertyInfoById($id, 'address');
    $description = getPropertyInfoById($id, 'description');
    $rating = getPropertyInfoById($_SESSION["restID"], 'rate');
    ?>
    
    <script src="../js/slider.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/slider.js"></script>


    <div class="placePage">
        <div class="main">
            <div class="container">
                <div class="album">
                    <div id="photos">
                         <?php $var = getPlacePhotos($id);
                        echo '</div>';
                        if ($var) {
                            echo '<a class="arrowLeft" onclick="plusDivs(-1)">&#10094;</a>';
                            echo '<a class="arrowRight" onclick="plusDivs(+1)">&#10095;</a>';
                        }
                        ?>
                    </div>
                    
                    <p id="placeName"><?php echo $namePlace ?></p>
                    <p id="placeLocation"><?php echo $location ?></p>
                    <p id="placeDescription"><?php echo $description ?></p>
                </div>


                
            </div>

        </div>


<?php
include_once "footer.php";
?>