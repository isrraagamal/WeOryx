<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/fonts/roboto.css" />
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.png" />
    <title>ESPOIR</title>
    <style>
        .error {
        color: red;
        font-size: 0.875em;
        }
    </style>
</head>
<body>
    <header>
        <div class="row">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#">
                        <img src="./assets/images/logo.png" />
                    </a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-toggle="collapse"
                        data-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <?php
                            $current_page = basename($_SERVER['PHP_SELF']);
                            ?>
                            <a class="nav-item nav-link <?php if ($current_page == 'index.php') echo 'active'; ?>" href="index.php">
                                Home <span class="sr-only">(current)</span>
                            </a>
                            <a class="nav-item nav-link <?php if ($current_page == 'about.php') echo 'active'; ?>" href="./about.php">About us</a>
                            <a class="nav-item nav-link <?php if ($current_page == 'resources.php') echo 'active'; ?>" href="./resources.php">Resources</a>
                            <a class="nav-item nav-link <?php if ($current_page == 'services.php' || ($current_page == 'services-details.php' && isset($_GET['service_id']))) echo 'active'; ?>" href="./services.php">Our Services</a>
                            <a class="nav-item nav-link <?php if ($current_page == 'team.php') echo 'active'; ?>" href="team.php">Team</a>
                            <a class="nav-item nav-link book-now-button <?php if ($current_page == 'book-now.php') echo 'active'; ?>" href="#">Book Now</a>
                            <a class="nav-item nav-link lang-button" href="#">العربية</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="header-info">
            <div class="row">
                <div class="container d-flex">
                    <div class="col-6">
                        <nav>
                            <ul>
                                <li><a href="#">Gallery</a></li>
                                <li><a href="#" class="ml-3">Testimonial</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-6">
                        <nav class="nav-info ml-4">
                            <ul>
                                <li>
                                    <img src="./assets/images/Vector.png" alt="" class="mr-2" />+966-55096820
                                </li>
                                <li>
                                    <img src="./assets/images/Icon.png" alt="" class="mr-2" />info@Espoir.com
                                </li>
                                <li class="info-icon">
                                    <a href="#">
                                        <img src="./assets/images/instagram.png" alt="" />
                                    </a>
                                </li>
                                <li class="info-icon">
                                    <a href="#">
                                        <img src="./assets/images/x.png" alt="" />
                                    </a>
                                </li>
                                <li class="info-icon">
                                    <a href="#">
                                        <img src="./assets/images/youtube.png" alt="" />
                                    </a>
                                </li>
                                <li class="info-icon">
                                    <a href="#">
                                        <img src="./assets/images/linkedin.png" alt="" />
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
