<?php
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
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Felhasználók
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-striped table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Felhasználó</th>
                                    <th>Utolsó Bejelentkezés</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <form action="query/U_fiokok.php" id="form" method="POST" autocomplete="off">
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 id="modalTitle">Fiók létrehozása</h4>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputEmail" class="form-label">Email cím:</label>
                                            <input class="form-control" id="inputEmail" type="Email" name="email" required />
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputPass1" class="form-label">Jelszó:</label>
                                            <input class="form-control" id="inputPass1" type="password" name="pass1" required>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputPass2" class="form-label">Jelszó megerősítés:</label>
                                            <input class="form-control" id="inputPass2" type="password" name="pass2" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="text" id="inputId" name="id" hidden>
                                    <button type="submit" class="btn btn-primary" id="modalSubmit" name="upload">Feltölt</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="delete">
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delModalLabel">Biztos törlöd ezt a Fiókot?:<br>
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
                        echo 'createToast("Sikertelen Művelet",' . $_SESSION['errors'] . ',false);';
                        $_SESSION['errors'] = null;
                    } else if (isset($_SESSION['success'])) {
                        echo 'createToast("Siker","' . $_SESSION['success'] . '",true);';
                        $_SESSION['success'] = null;
                    }
                    ?>
                    destroyTable();
                    createTableFiokok();
                </script>

    </body>

    </html>