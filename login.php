<?php

include "./components/header.inc.php";

login_check_pages();

?>

<main>
    <div class="container">
        <h2 class="highlight-txt mt-5 mb-4 ps-2">
            Log In
        </h2>

        <?php
        display_message();
        validate_user_login();
        ?>

        <section class="login-form px-2">
            <div class="form-holder">
                <form action="" class="form mt-2" method="POST">
                    <input type="text" name="email" placeholder="Email" required> <br> <br>
                    <input type="password" name="password" placeholder="Password" required> <br> <br>
                    <input class="primary-button" type="submit" name="login-submit" value="Log In" class="btn btn-link d-inline-block">
                </form>
                <p class="pt-4 mb-0">Don't have account? No problem, register <a class="" href="register.php"><b>HERE</b></a>.</p>
            </div> <!-- .form-holder END-->
        </section> <!-- .login-form END-->


    </div>
</main>

<?php include "./components/footer.inc.php"; ?>
