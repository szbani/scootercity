<?php
session_start();
require_once 'query/conn.php';
require_once 'query/login.php';

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
        include_once 'parts/navbar.html';
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
                        Termékek
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-striped table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>Terméknév</th>
                                    <th>Index Kép</th>
                                    <th>Ár(Ft)</th>
                                    <th>Kategória</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <form action="query/U_fiokok.php" id="Modal" method="POST" autocomplete="off">
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Termék felvétele
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputNev" class="form-label">Termék neve:</label>
                                            <input class="form-control" id="inputNev" type="text" name="nev" />
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputAr" class="form-label">Termék Ára:</label>
                                            <input class="form-control" id="inputAr" type="number" name="ar">
                                        </div>
                                        <div class="col">
                                            <label for="inputKategoria" class="form-label">Termék kategóriája:</label>
                                            <div class="form-check ps-0">
                                                <select id="inputKategoria" name="kategoria" class="form-select">
                                                    <option>option1</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-3">
                                            <label for="inputTulajdonsag" class="form-label">Termék Tulajdonságai:</label>
                                            <label for="inputTulajdonsag" class="form-label">Tulajdonság neve:</label>
                                            <input class="form-control" id="inputTulajdonsag" type="text" name="tulajdonsag">
                                        </div>
                                        <div class="col-3">
                                            <label for="inputTulajdonsag" class="form-label">Értéke:</label>
                                            <input class="form-control" id="inputTulajdonsag" type="text" name="tulajdonsag">
                                        </div>
                                        <div class="col-3">
                                            <label for="inputTulajdonsag" class="form-label">Termék Tulajdonságai:</label>
                                            <label for="inputTulajdonsag" class="form-label">Tulajdonság neve:</label>
                                            <input class="form-control" id="inputTulajdonsag" type="text" name="tulajdonsag">
                                        </div>
                                        <div class="col-3">
                                            <label for="inputTulajdonsag" class="form-label">Értéke:</label>
                                            <input class="form-control" id="inputTulajdonsag" type="text" name="tulajdonsag">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputBank" class="form-label">Termék képei:</label>
                                            <div class="container">
                                                <div class="row align-items-center">
                                                    <div class="col-3 text-center">
                                                        <fieldset class="form-group">
                                                            <a href="javascript:void(0)" onclick="$('#pro-image').click()"><i class="fa-solid fa-cloud-arrow-up fa-6x"></i></a>
                                                            <input type="file" id="pro-image" name="pro-image" style="display: none" class="form-control" multiple />
                                                        </fieldset>
                                                    </div>
                                                    <div class="col">
                                                        <div class="preview-images-zone">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputBank" class="form-label">Termék Leírása:</label>
                                            <textarea class="form-control" name="pass1"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="modalSubmit" class="btn btn-primary" name="upload">Feltölt</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="query/U_termekek.php" method="POST">
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delModalLabel">Biztos törlöd ezt a terméket?:<br>
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
                    createTable();
                    imageZone();
                </script>

    </body>

    </html>