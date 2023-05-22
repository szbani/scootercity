<?php
define('ACCESS_ALLOWED', true);
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
                        Kategóriák Nevek
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-striped table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Név</th>
                                    <th>Termékek száma(db)</th>
                                    <th>Kép</th>
                                    <th>Felsőbb kategória</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <form action="query/U_kategoriak.php" id="form" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 id="modalTitle">Kategória felvétele</h4>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div>
                                <div class="modal-body">
                                    <div class="row row-cols-1 g-3">
                                        <div class="col">
                                            <label for="inputNev" class="form-label">Kategória neve:</label>
                                            <input class="form-control" id="inputNev" type="text" name="nev" required/>
                                        </div>
                                        <div class="col">
                                            <label for="inputKategoria" class="form-label">Főbb kategória:</label>
                                            <div class="form-check ps-0">
                                                <select id="inputKategoria" name="inputSubKat" class="form-select">
                                                    <option selected value="NULL">Nincs</option>
                                                    <?php
                                                    $sql = "SELECT id, nev FROM kategoriak;";
                                                    $result = mysqli_query($conn, $sql);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['nev'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="form-label" for="fileUpload">Kategória Képe</label>
                                            <input type="file" name="img" class="form-control" id="fileUpload">
                                        </div>
                                        <!-- <div class="col" id="newImg">
                                            <label for='newImgCheck' class="form-label">Új kép feltöltése</label>
                                            <input type="checkbox" name="img" class="form-check-input" id="newImgCheck">
                                        </div> -->
                                    </div>

                                    <!-- kep feltoltes helye -->
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
                        echo 'createToast("Sikertelen Művelet",' . $_SESSION['errors'] . ',false);';
                        $_SESSION['errors'] = null;
                    } else if (isset($_SESSION['success'])) {
                        echo 'createToast("Siker","' . $_SESSION['success'] . '",true);';
                        $_SESSION['success'] = null;
                    }
                    ?>
                    destroyTable();
                    createTableKategoriak();
                </script>
    </body>

    </html>