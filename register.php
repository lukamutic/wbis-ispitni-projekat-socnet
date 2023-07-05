<?php

include "./components/header.inc.php";

login_check_pages();

?>
<main>
    <div class="container">
        <?php
        validate_user_registration();
        display_message();
        ?>

        <h2 class="highlight-txt mt-4 mb-4 ps-2">
            Register here:
        </h2>
        <div class="form-holder">
            <form class="form my-2" action="" method="POST">
                <input type="text" name="first_name" placeholder="First Name"> <br><br>
                <input type="text" name="last_name" placeholder="Last Name"> <br><br>
                <input type="text" name="username" placeholder="Userame" required> <br><br>
                <input type="email" name="email" placeholder="Email" required> <br><br>
                <input type="password" name="password" placeholder="Password" required> <br><br>

                <input type="password" name="confirm_password" placeholder="Confirm Password" required> <br><br>

                <input class="primary-button" type="submit" name="register-submit" value="Register Now">

                <p class="pt-4 mb-0">Already have account? You can just <a class="" href="login.php"><b>Log In HERE</b></a>.</p>

            </form>
        </div>
    </div> <!-- .container END -->

</main>

<?php include "./components/footer.inc.php"; ?>
