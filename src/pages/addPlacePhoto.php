<?php
include_once "header.php";
$id = $_GET['id'];
$_SESSION['restID'] = $id;
?>

<p>Add your first photo to Place album...</p>

<form class="addPlaceForm" action="../dbActions/uploadPlacePhoto.php?" method="post" enctype="multipart/form-data">
    <li>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Place Photo" name="submit">
    </li>

    <button type="button" onclick="window.location.href='profile.php'" >Not Yet!</button>
</form>

<?php
include_once "footer.php";
?>
