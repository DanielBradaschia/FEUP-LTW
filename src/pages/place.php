<?php
//session_start();
//session_regenerate_id(true);
?>
    <!DOCTYPE html>
    <?php
    $title = "Welcome";
    include_once "header.php";
    include_once "../dbActions/placeUtils.php";
    include_once "../dbActions/user.php";
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
                </div>    
            </div>
            
            <div class="container">
                <div class="editPlace">
                    <?php
                        if(isPlaceOwner(getIdByUserName($userId), $id))
                        {
                            echo '<div class="container">';
                                echo '<div class="addPhotos">';
                                    echo '<p class="boxTitle">Add a photo to your galery:</p>';
                                    echo '<div class="addPhotos">';
                                    echo '<form class="addPlacePhotoForm" action="../dbActions/uploadPlacePhoto.php?" method="post" enctype="multipart/form-data">';
                                    echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '">';
                                    echo '<input id="findPhoto" type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple">';
                                    echo '<br>';
                                    echo '<input type="submit" value="Upload Photo" name="submit">';
                                    echo '</form>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';

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

                            echo '<form class="removePlace" action="../dbActions/removePlace.php" method="post">';
                            echo '<button type="submit" name="deleteItem" value="'.$id.'">Delete Place</button>';
                            echo '</form>';
                        }
                    ?>
                </div>
            </div>

            <?php
            ?>


        </div>


<?php
include_once "footer.php";
?>