<?php
session_start();
require_once 'query/conn.php';
require_once 'query/login.php';

require_once 'query/Q_fiokok.php';
require_once 'query/logs.php';

if (empty($_GET['page'])) {
?>
    <!DOCTYPE html>
    <html lang="hu">

    <head>
    <?php require_once 'parts/head.php'; ?>
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
                    <h1 class="mt-4" id="pageName">kategória Tulajdonságok</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Kategóriák Tulajdonságok
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tulajdonság</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <?php
                                loadLogs($conn, "SELECT * FROM kat_tul;", false, true, true);
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <a href="#" type="button" class="btn-fab" data-bs-toggle='modal' data-bs-target="#uploadModal">
                    <i class="fa fa-plus fa-lg"></i>
                </a>
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
                <form action="query/U_fiokok.php" method="POST" autocomplete="off">
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Fiók létrehozása
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputNev" class="form-label">Email cím:</label>
                                            <input class="form-control" type="Email" name="email" />
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputBank" class="form-label">Jelszó:</label>
                                            <input class="form-control" type="password" name="pass1">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputBank" class="form-label">Jelszó megerősítés:</label>
                                            <input class="form-control" type="password" name="pass2">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit">Feltölt</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </main>
                <?php
                if (empty($_GET['page'])) {
                    include_once 'parts/footer.php';
                }
                ?>
                <script>
                    loadTablesSortable();
                </script>
    </body>

    </html>