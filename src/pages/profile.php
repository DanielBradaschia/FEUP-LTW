<?php
//session_start();
//session_regenerate_id(true);
$title = "Welcome";      // Set the title
include_once "header.php";
include_once "../dbActions/user.php";
include_once "../dbActions/placeUtils.php";
include_once "../dbActions/rentUtils.php";

// Generate token for the update action
$_SESSION['token'] = generate_random_token();

$username = $_SESSION['login-user'];
$name = getUserInfoByUserName($username, 'name');
$photoUser = getUserInfoByUserName($username, 'profilePicture');
$srcPhoto = '../assets/' . $photoUser;
$date = getUserInfoByUserName($username, 'birthdate');
$gender = getUserInfoByUserName($username, 'gender');
$type = getUserInfoByUserName($username, 'type');
$cellphone = getUserInfoByUserName($username, 'cellphone');

?>
<title>MyProfile</title>
<div class="profilePage">
    <div class="main">
        <div class="container">
            <div class="profileCenter">
                <h1>Edit Profile</h1>
                <img class="img-item" src="<?php echo $srcPhoto ?>"><br>
                <form class="uploadPhotoProfile" action="../dbActions/uploadUserPhoto.php" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"/>
                    <input type="file" name="fileToUpload" id="fileToUpload" value="Select image to upload:"><br>
                    <input type="submit" value="Upload Image" name="submit">
                </form>
            </div>

            <form class="editProfileForm" action="../dbActions/editProfile.php" method="post">
                <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"/>
                <ul>
                    <li>
                        <label for="Name">Modify your Name</label>
                        <input type="text" name="name" maxlength="100" placeholder="<?php echo $name ?>"><br>
                    </li>

                    <li>
                        <label for="Password">Modify your Password</label>
                        <input type="Text" name="password" maxlength="100" placeholder="......"><br>
                    </li>

                    <li>
                        <label for="Cellphone">Modify your Cellphone</label>
                        <input type="number" name="cellphone" maxlength="100" placeholder="<?php echo $cellphone ?>"><br>
                    </li>

                    <li>
                        <label for="date">Modify your Date of Birth</label>
                        <input placeholder='<?php echo $date ?>' name="birthdate" class="form-control" type="text"
                               onfocus="(this.type='date')" onblur="(this.type='text')" id="date"><br>
                    </li>
                    <li>
                        <label for="gender">Gender</label>
                        <div class="genderProfile">
                            <?php
                            if (strtoupper($gender) == 'M') {
                                echo '  <input class="inputGender" type="radio" name="gender" checked="checked" value="M"> M';
                                echo '<input class="inputGender" type="radio" name="gender" value="F"> F';
                            } else {
                                echo '  <input class="inputGender" type="radio" name="gender" value="M"> M';
                                echo '<input class="inputGender" type="radio" name="gender" checked="checked" value="F"> F';
                            }
                            ?>
                            <br>
                        </div>

                    </li>
                    <li>
                        <input type="submit" value="Save Changes">
                        <button class="button-item" type="button" onclick="location.href='index.php';">Cancel</button>
                    </li>
                </ul>
            </form>

            <?php
                echo '<div class="ownerColumn">';
                    echo 'Can\'t find your Places?' . '<br>' . '<br>';
                    echo '<button id="button-add" class="button-item" type="button" onclick="location.href=\'addPlace.php\';">Add a Place</button>';
                echo '</div>';
                
                    echo '<div class="container">';
                        echo '<div class="userRest">';
                            echo '<h1 id="editProfile" style="text-align: center">Your Rents</h1>';
                            $rent = getRentsByUser(getUserInfoByUserName($username, 'idUser'));
                            foreach ($rent as $row) {
                                $title = getPropertyInfoById($row['idProperty'], 'title');
                                $checkin = $row['moveIn'];
                                $checkout = $row['moveOut'];
                                echo '<div class="placeList">';
                                echo $title;
                                echo ' ';
                                echo $checkin;
                                echo ' ';
                                echo $checkout;
                                echo '</div>';
                                }
                        echo '</div>';

                    echo '</div>';
            ?>

        </div>
    </div>
    <div class="owned">
        <div class="related">
            <?php
                if ($type == 'Owner') {
                    $result = getPlaceByOwnerId(getUserInfoByUserName($username, 'idUser'));
                    foreach ($result as $row) {
                        echo "<div class=\"container\">";

                        $placeTitle = $row['title'];
                        $placeAddress = $row['address'];
                        $placePrice = $row['price'];
                        $placeDescription = $row['description'];
                        $restRating = $row['rate'];
                        $id = getPropertyInfoByAddress($placeAddress, 'idProperty');

                        echo '<div class="row">';

                        echo '<div class="contentPhoto">';
                        showFirstPlaceImage($id);
                        echo '</div>';
                        echo "<h2 onclick=\"location.href='place.php?id=$id';\">" . $placeTitle . "</h2>";

                        echo "<h4> Address:</h4>";
                        echo "<h1>".$placeAddress."</h1>";

                        echo "<h4> Description:</h4>";
                        echo "<h1>".$placeDescription."</h1>";
                        echo '</div>';
                        echo '<div class="row">';
                        echo "<h4> Price: ".$placePrice."€</h4>";
                        $temp = ' - ';
                        printStarsRating($restRating);

                        echo '</div>';
                        echo "</div>";
                    }

                }
        
                ?>
            </div>
        </div>
    </div>    
</div>

<?php
include_once "footer.php";
?>
