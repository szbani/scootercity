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
                            <table id="table" class="table table-striped table-bordered table-hover w-100">
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
                <form id="delete">
                    <div class=" modal fade" id="deleteModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delModalLabel">Biztos törlöd ezt a kategóriát?:<br>
                                        (ID:<a class="text-danger" id="delId"></a>) <a id="delNev"><a></h5>
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
                <div class="toast-container position-fixed bottom-0 end-0 p-3 align-items-center" style="z-index: 11">

                </div>
                </main>
                <?php
                if (empty($_GET['page'])) {
                    include_once 'parts/footer.php';
                }
                ?>
                <script>
                    <?php
                    if (isset($_SESSION['errors'])) {
                        echo 'createToast("Sikertelen Művelet",[' . $_SESSION['errors'] . '],false)';
                        $_SESSION['errors'] = null;
                    } else if (isset($_SESSION['success'])) {
                        echo 'createToast("Siker",["' . $_SESSION['success'] . '"],true);';
                        $_SESSION['success'] = null;
                    }
                    ?>
                    createTableKategoriak();
                </script>
    </body>

    </html>