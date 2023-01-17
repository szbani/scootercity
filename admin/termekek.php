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
                                    <th>Termék név</th>
                                    <th>Index Kép</th>
                                    <th>Ár(Ft)</th>
                                    <th>Kategória</th>
                                    <th>Mennyiség(db)</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <form action="query/U_termekek.php" id="form" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg modal-fullscreen-lg-down">
                            <div class="modal-content">
                                <div class="modal-header align-items-center pb-1">
                                    <h4 id="modalTitle">Termék felvétele</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputNev" class="form-label">Termék neve:</label>
                                            <input class="form-control" id="inputNev" type="text" name="nev" required />
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-5">
                                            <label for="inputAr" class="form-label">Termék ára:</label>
                                            <input class="form-control" id="inputAr" type="number" name="ar" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="inputKategoria" class="form-label">Termék kategóriája:</label>
                                            <div class="form-check ps-0">
                                                <select id="inputKategoria" name="kategoria" class="form-select" val="" required>
                                                    <option selected disabled value="">Kategória...</option>
                                                    <?php
                                                    $sql = "SELECT id, nev FROM kategoriak;";
                                                    $result = mysqli_query($conn, $sql);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<option value="'.$row['id'].'">' . $row['nev'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <label for="inputMennyiseg" class="form-label">Mennyiség:</label>
                                            <input class="form-control" id="inputMennyiseg" type="number" min="0" value="0" name="mennyiseg">           
                                        </div>
                                    </div>
                                    <label for="inputTulajdonsag" class="form-label">Termék tulajdonságai:</label>
                                    <div class="container form-control">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                <label for="inputTulajdonsag" class="form-label">Tulajdonság neve:</label>
                                            </div>
                                            <div class="col-4">
                                                <label for="inputTulajdonsag" class="form-label">Értéke:</label>
                                            </div>
                                        </div>
                                        <div class="row modal-scroll-zone g-1 align-items-center overflow-auto">
                                            <div class="col-16">
                                                <div class="row g-1">
                                                    <div class="col-4">
                                                        <input class="form-control" id="inputTulajdonsag" type="text" name="tul-nev[]">
                                                    </div>
                                                    <div class="col-4">
                                                        <input class="form-control" id="inputTulajdonsag" type="text" name="tul-ertek[]">
                                                    </div>
                                                    <div class="col-4">
                                                        <a class="add-row" data-bs-toggle="tooltip" data-bs-placement="right" title="Sor hozzáadása">
                                                            <i class="fa-solid fa-plus fa-2x"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            for ($i = 0; $i < 3; $i++) {
                                                echo '
                                                <div class="col-16">
                                                <div class="row g-1">
                                                 <div class="col-4">
                                                <input class="form-control" type="text" name="tul-nev[]">
                                            </div>
                                            <div class="col-4">
                                                <input class="form-control" type="text" name="tul-ertek[]">
                                            </div>
                                            <div class="col-4">
                                                <a class="del-row" data-bs-toggle="tooltip" data-bs-placement="right" title="Sor törlése">
                                                    <i class="fa-solid fa-minus fa-2x" ></i>
                                                </a>
                                            </div>
                                            </div>
                                            </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <label for="inputBank" class="form-label">Termék képei:</label>
                                            <div class="container form-control">
                                                <div class="row align-items-center">
                                                    <div class="col-3 text-center">
                                                        <fieldset class="form-group">
                                                            <a href="javascript:void(0)" onclick="$('#pro-image').click()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Képek feltöltése">
                                                                <i class="fa-solid fa-cloud-arrow-up fa-6x"></i>
                                                            </a>
                                                            <input type="file" id="pro-image" style="display: none" class="form-control" multiple />
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
                                            <label for="inputLeiras" class="form-label">Termék leírása:</label>
                                            <textarea class="form-control" id="inputLeiras" name="leiras" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <input type="text" id="inputId" name="id" hidden>
                                        <button type="submit" id="modalSubmit" class="btn btn-primary" name="upload">Feltöltés</button>
                                    </div>
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
                    createTableTermekek();
                    imageZone();
                </script>

    </body>

    </html>