<?php
session_start();
require_once 'query/conn.php';
require_once 'query/login.php';

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
                    <h1 class="mt-4" id="pageName">Kategória Nevek</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Kategóriák Nevek
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Név</th>
                                        <th>Termékek száma(db)</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <form action="query/U_kategoriak.php" id="form" method="POST" autocomplete="off">
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 id="modalTitle">Kategória felvétele</h4>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputNev" class="form-label">Kategória neve:</label>
                                            <input class="form-control" id="inputNev" type="text" name="nev" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="text" id="inputId" name="id" hidden>
                                    <button type="submit" class="btn btn-primary" id="modalSubmit" name="upload">Feltöltés</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="query/U_kategoriak.php" method="POST">
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delModalLabel">Biztos törlöd ezt a kategóriát?:<br>
                                        (ID:<a class="text-danger" id="delId"></a>) <a id="delNev"><a></h5>
                                    <input type="text" id="delHidden" name="id" value="" hidden>
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
                </main>
                <?php
                if (empty($_GET['page'])) {
                    include_once 'parts/footer.php';
                }
                ?>
                <script>
                    createTableKategoriak();
                </script>
    </body>

    </html>