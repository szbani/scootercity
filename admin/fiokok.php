<?php
session_start();
require_once 'query/conn.php';
require_once 'query/login.php';

if (!isset($_SESSION['user']) && !isset($_SESSION['pass'])) {
    header('Location: ' . 'login.php');
    die();
}
if (!login($_SESSION['user'], $_SESSION['pass'], $conn)) {
    header('Location: ' . 'login.php');
    die();
}
require_once 'query/Q_fiokok.php';
require_once "query/parts.php";

if(empty($_GET['page'])){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ScooterCity - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/styles.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
</head>

<body class="sb-nav-fixed">
    <?php
    include_once 'parts/navbar.html'
    ?>
    <div id="layoutSidenav">

        <?php
        include_once 'parts/sidebar.php';
        ?>
        <div id="layoutSidenav_content">
            <main id="pageContent">
            <?php
            }
            ?>
                <div class="container-fluid px-4">
                    <h1 class="mt-4" id="pageName">Fiókok</h1>
                    <form action="query/U_fiokok.php" method="POST" autocomplete="off">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Fiók létrehozása
                                    </div>
                                    <?php
                                    include_once "query/errors.php";
                                    ?>
                                    <div class="card-body ">
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <label for="inputNev" class="form-label">Email cím:</label>
                                                <input class="form-control" id="inputEmail" type="Email" name="email" />
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <label for="inputBank" class="form-label">Jelszó:</label>
                                                <input class="form-control" type="password" id="inputPass1" name="pass1">
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <label for="inputBank" class="form-label">Jelszó megerősítés:</label>
                                                <input class="form-control" type="password" id="inputPass2" name="pass2">
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="submit" id="sub">Feltölt</button>

                                    </div>
                                </div>
                            </div>
                            <?php
                            mod_menu($conn);
                            ?>
                        </div>
                    </form>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Felhasználók
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Felhasználó</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Felhasználónév</th>
                                        <th>#</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    loadArray($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <form action="query/U_fiokok.php" method="POST">
                <div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="delModalLabel">Biztos törlöd a fiókot?(<a class="text-danger" id="del_id"></a>)</h5>
                                <input type="text" id="del_hidden" name="id" value="" hidden>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                                <button type="submit" name="delete" class="btn btn-primary">Törlés</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            if(empty($_GET['page'])){
            include_once "query/success.php";
            include_once 'parts/footer.php';
            echo '<script src="js/fiokok.js"></script>';
            }
            ?>
    </body>
</html>