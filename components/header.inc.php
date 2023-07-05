<?php include "functions/init.php"; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Ispitni zadatak iz Web Baziranih Informacionih sistema">
    <meta name="keywords"
          content="HTML, CSS, JavaScript, PHP, mySQL, jQuery, SASS, Bootstrap, ispitni zadatak iz Web Baziranih Informacionih sistema">
    <meta name="author" content="Luka Mutic">

    <!--IOS compatibility-->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="ispitni zadatak iz Web Baziranih Informacionih sistema">
    <link rel="apple-touch-icon" href="apple-icon-144x144.png">


    <!--Android compatibility-->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="ispitni zadatak iz Web Baziranih Informacionih sistema">
    <link rel="icon" type="image/png" href="android-icon-192x192.png">

    <title>SocNet</title>

    <!--    CSS Files-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="./assets/css/main.css">

</head>
<body>

<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <h1 class="display-4 fw-bold logo">
                        SocNet
                    </h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <?php if (!isset($_SESSION['email'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                        <?php } else {
                            
                            if (!isset($_SESSION['user_type'])) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="profile.php">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout</a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="chart.php">Chart</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="export.php">Export</a>
                                </li>                                 
                                <li class="nav-item">
                                    <a class="nav-link" href="profile.php">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout</a>
                                </li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
        </nav>

    </div> <!-- .container END-->
</header>
