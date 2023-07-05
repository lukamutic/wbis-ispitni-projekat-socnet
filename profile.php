<?php include "components/header.inc.php";

user_restrictions();

?>

    <div class="container">
        <section class="profile-section">


            <?php
            $user = get_user();
            echo "<img class='profile-image-change' src='" . $user['profile_image'] . "'/>";

            user_profile_image_upload();

            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <p>Select image to upload</p>
                <input type="file" name="profile_image_file"><br>
                <input type="submit" value="Upload image" class="mt-3" name="submit">

            </form>

            <div class="my-3">
                <?php display_message(); ?>
            </div>

        </section> <!-- .profile-section END-->
    </div>

<?php include "components/footer.inc.php" ?>