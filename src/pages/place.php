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
    $rating = getPropertyInfoById($id, 'rate');
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
                    <form action="" method="post">
                    <input type="submit" name="deleteItem" value="'.$id.'" />
                    <?php
                        if(isset($_POST['deleteItem']))
                        {
                            removePlace($id);
                            header('Location: ../pages/profile.php');
                        }
                    ?>    
                </div>    
            </div>

            <div class="container">
                <div class="editPlace">
                    <?php
                        echo '<form class="editPlaceForm" action="../dbActions/editPlace.php" method="post">';
                        echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '">';
                        
                        echo '<label>Address</label>';
                        echo '<input type="text" name="placeAddress" value="' . getPropertyInfoById($id, 'address') . '"">';
                        echo '<br>';
                        
                        echo '<label>Title</label>';
                        echo ' <input type="text" name="placeTitle" value="' . getPropertyInfoById($id, 'title') . '">';
                        echo '<br>';
                        
                        echo '<label>Description</label>';
                        echo ' <input type="text" name="placeDescription" value="' . getPropertyInfoById($id, 'description') . '">';
                        echo '<br>';
                        
                        echo '<label>Cost</label>';
                        echo '<input type="text" name="placePrice" value="' . getPropertyInfoById($id, 'price') . '">';
                        echo '<input type="submit" value="Submit">';
                        echo '</fieldset>';
                        echo '</form>';
                    ?>
                </div>
            </div>

            <div class="container">
                <div class="addPhotos">
                    <p class="boxTitle">Add a photo to your galery:</p>
                    <div class="addPhotos">
                        <form class="addPlacePhotoForm" action="../dbActions/uploadPlacePhoto.php?" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
                        <input id="findPhoto" type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple">
                        <br>
                        <input type="submit" value="Upload Photo" name="submit">
                        </form>
                    </div>
                </div>
            </div>



        </div>


<?php
include_once "footer.php";
?>