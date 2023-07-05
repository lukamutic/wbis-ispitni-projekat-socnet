<?php
include('components/header.inc.php');
?>
    <main>
        <div class="container">
            <?php if (isset($_SESSION['email'])): ?>
                <?php create_post(); ?>
                <h2 class="welcome-message display-6 pt-4">
                    <?php $user = get_user();
                    echo $user['first_name']; ?>, welcome!</h2>

                <br>
                <form method="POST" class="pb-5 pt-3">
                    <h3>Create new post</h3>

                    <?php select_category(); ?>

                    <textarea name="post_content" cols="60" rows="10" placeholder="Post content..."></textarea> <br><br>
                    <input class="primary-button" type="submit" value="Post" name="submit">
                </form>
                <div>
                    <?php display_message(); ?>
                </div>
                <hr>
                <p>Categories: </p>
                <?php list_all_categories() ?>
                <hr>
                <div class="posts">
                    <h2 class="pt-5 pb-4">Latest posts</h2>
                    <?php fetch_all_posts(); ?>
                </div>
            <?php else: ?>

            <div class="text-center">
                <h1 class="welcome-text text-center mt-5 mb-4">
                    Welcome to SocNet!
                </h1>
                <p class="text-center">Please, <a class="" href="login.php"><b>LOG IN</b></a> to be able to see content from SocNet.</p>

                <p>Don't have account? No problem, register <a class="" href="register.php"><b>HERE</b></a></p>
            </div>

            <?php endif; ?>
        </div>
    </main>
<?php include('components/footer.inc.php'); ?>