<?php
include_once "header.php";
$_SESSION['token'] = generate_random_token();

?>
<form class = "addPlaceForm" action="../dbActions/addPlace.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"/>
    <ul>
        <div class="container">
        <li>
            <label for="Address">Address</label>
            <input type="text" name="address" maxlength="100" placeholder="Address"><br>
        </li>
        </div>

        <div class="container">
        <li>
            <label for="Title">Title</label>
            <input type="text" name="title"  maxlength="100" placeholder="Title"><br>
        </li>
        </div>
        
        <div class="container">
        <li>
            <label for="Price">Price per day</label>
            <input placeholder="€/ day" name="price" class="form-control" type="text"><br>
        </li>
        </div>

        <div class="container">
        <li>
            <label for="Description">Description</label>
            <input type="text" name="description"  maxlength="1000" placeholder="Description"><br>
        </li>
        </div>


        <div class="container">
        <li>
            <label for="PhotosUpload">Upload photos </label>
            <input id="findPhoto" type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple">
        </li>

        </div>
        
        <div class="container">
        <li>
            <input type="submit" value="Save Changes">
            <input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />
        </li>
        </div>
    </ul>
</form>

<?php
include_once "footer.php";
?>

