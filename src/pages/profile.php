<?php
session_start();
session_regenerate_id(true);
$title = "Welcome";      // Set the title
include_once "header.php";
include_once "../dbActions/user.php";

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

<div class="restaurantPage">
    <div class="main">
        <div class="container">
            <h1 id="editProfile" style="text-align: left">Edit Profile</h1>
            <div class="profileCenter">
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
                        <label for="Name">Name</label>
                        <input type="text" name="name" maxlength="100" placeholder="<?php echo $name ?>"><br>
                        <span>Modify your full name here</span>
                    </li>
                    <li>
                        <label for="UserName">Username</label>
                        <input type="email" name="email" maxlength="100" placeholder="<?php echo $username ?>"><br>
                        <span>Modify your username here</span>
                    </li>
                    <li>
                        <label for="date">Date of Birth</label>
                        <input placeholder='<?php echo $date ?>' name="birthdate" class="form-control" type="text"
                               onfocus="(this.type='date')" onblur="(this.type='text')" id="date"><br>
                        <span>Modify your date of birth here</span>
                    </li>
                    <li>

                        <label for="gender">Gender</label>
                        <div class="genderProfile">
                            <?php
                            if (strtoupper($gender) == 'M') {
                                echo '  <input class="inputGender" type="radio" name="gender" checked="checked" value="M"> M ';
                                echo '<input class="inputGender" type="radio" name="gender" value="F"> F ';
                            } else {
                                echo '  <input class="inputGender" type="radio" name="gender" value="M"> M ';
                                echo '<input class="inputGender" type="radio" name="gender" checked="checked" value="F"> F ';
                            }
                            ?>
                            <br>
                        </div>
                        <span>Modify your gender here</span>

                    </li>
                    <li>
                        <label for="bio">About You</label>
                        <textarea name="bio" onkeyup="adjust_textarea(this)"></textarea>
                        <span>Say something about yourself</span>
                    </li>
                    <li>
                        <input type="submit" value="Save Changes">
                        <button class="button-item" type="button" onclick="location.href='index.php';">Cancel</button>
                    </li>

                </ul>
            </form>
        </div>
    </div>
    <div class="related">
        </div>
    </div>
</div>

<?php
include_once "footer.php";
?>
