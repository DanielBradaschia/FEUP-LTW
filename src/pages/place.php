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

                <?php
                 if (isset($_SESSION["login-user"]))
                 {
                     echo '<div class="container">';
                     
                     $photo = '../assets/' . getUserPhoto($_SESSION['login-user']);

                     echo '<img id="userPhoto" src=' . $photo . '>';
                     echo '<form id="formRev" class="reviewForm" action="../dbActions/sendReview.php" method="post"';
                     echo 'enctype="multipart/form-data">';
                     echo '<input type="hidden" name="token" id="token" value="' . $_SESSION['token'] . '"/>';
                     echo '<p class="boxTitle">Write a review:</p>';
                     echo '<label>Choose a title:</label>';
                     echo '<input type="text" name="title"><br>';
                     echo '<label>Write your review:</label>';
                     echo '​<textarea name="review" id="review" rows="10" cols="70"></textarea>';

                     echo '<fieldset class="ratingSearch">';
                     echo '<input type="radio" id="star5" name="rating" value="5"/>
                                <label class="full" for="star5" title="Pretty f\'ing Good - 5 stars"></label>

                            <input type="radio" id="star4" name="rating" value="4"/>
                                <label class="full" for="star4" title="Pretty Good - 4 stars"></label>
                            
                            <input type="radio" id="star3" name="rating" value="3"/>
                                <label class="full" for="star3" title="Seen Better and Worst - 3 stars"></label>
                            
                            <input type="radio" id="star2" name="rating" value="2"/>
                                <label class="full" for="star2" title="Pretty Bad - 2 stars"></label>
                            
                            <input type="radio" id="star1" name="rating" value="1"/>
                                <label class="full" for="star1" title="Pretty f\'ing Bad - 1 star"></label>
                        
                            </fieldset>

                        <br><br>

                        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple">

                        <br><br>
                        <input id="submit" type="submit" value="Publish">
                    </form>
                    
                     </div>';
                 }
                ?>

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
        </div>


<?php
include_once "footer.php";
?>