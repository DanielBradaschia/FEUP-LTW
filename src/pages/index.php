<?php
//session_start();
//session_regenerate_id(true);
include_once "../dbActions/user.php";
include_once "header.php";
?>
<!DOCTYPE html>
<body>
<title>House2House</title>
<section class="cd-intro video">
    <div class="cd-intro-content video">
        <h1 class="svg-wrapper">
        </h1>

        <section class="cd-intro">
            <h1 id="xtype" class="cd-headline letters type" style="z-index: 4;">
                <span>My next destination is</span>
                <span class="cd-words-wrapper waiting">
				<b class="is-visible">Rio de Janeiro</b>
				<b>New York City</b>
                <b>London</b>
                <b>Tokyo</b>
                <b>Porto</b>
			</span>
            </h1>
        </section> <!-- cd-intro http://localhost:8000/index.php -->

        <?php
            include_once "../dbActions/searchBar.php";
        ?>

        <div class="cd-bg-video-wrapper" data-video="../assets/video2">
            <!-- video element will be loaded using jQuery -->
        </div>
    </div>
</section>
<section class="advertisement">
    <div class="advertisement-services">
        <a>
            <img src='../assets/category_3.png'>
        </a>
    </div>
</section>
</body>

<?php
include_once "footer.php";
?>
