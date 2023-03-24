<?php
//require_once 'query/conn.php';
//require_once 'query/login.php';
//
//if (!isset($_SESSION['user']) && !isset($_SESSION['pass'])) {
//    header('Location: ' . 'login.php');
//    die();
//}
//if (!login($_SESSION['user'], $_SESSION['pass'], $conn)) {
//    header('Location: ' . 'login.php');
//    die();
//}
if (empty($_GET['page'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>404 Error - SB Admin</title>
        <link href="/admin/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div id="layoutError">
            <div id="layoutError_content">
                <main>
                <?php
            }
                ?>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="mb-4 img-error" src="/admin/assets/img/error-404-monochrome.svg" />
                                <p class="lead">This requested URL was not found on this server.</p>
                                <a href="index.php">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Return to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                </main>
            </div>
        </div>
    </body>

    </html>