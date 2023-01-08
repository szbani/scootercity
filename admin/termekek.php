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
                                    <!-- <th>#</th> -->
                                </tr>
                            </thead>
                            <?php
                            // $sql = "SELECT t.id,t.nev,t.ar,CONCAT(ke.kep, ke.type) AS indexkep,
                            // GROUP_CONCAT(CONCAT(ke.kep, ke.type) SEPARATOR', ') as kepek,
                            // t.leiras,kn.kat_nev,t.tulajdonsagok FROM `termekek` t 
                            // INNER JOIN `kat_nev` kn ON kn.id = t.kategoria 
                            // INNER JOIN `kepek` ke ON ke.id = t.index_kep
                            // INNER JOIN `kepek_fk` kef ON kef.termid = t.id
                            // INNER JOIN `kepek` k on kef.kepid = k.id
                            // GROUP BY t.nev;";
                            // loadTermekek($conn, $sql);
                            ?> 
                        </table>
                    </div>
                </div>
                </main>
                <?php
                if (empty($_GET['page'])) {
                    include_once 'parts/footer.php';
                }
                ?>
                <script>
                    createTable();
                </script>

    </body>

    </html>

    <!-- SELECT t.id,t.nev,t.ar,CONCAT(ke.kep, ke.type) AS indexkep,
GROUP_CONCAT(CONCAT(ke.kep, ke.type) SEPARATOR', ') as kepek,
t.leiras,kn.kat_nev,t.tulajdonsagok FROM `termekek` t 
INNER JOIN `kat_nev` kn ON kn.id = t.kategoria 
INNER JOIN `kepek` ke ON ke.id = t.index_kep
INNER JOIN `kepek_fk` kef ON kef.termid = t.id
INNER JOIN `kepek` k on kef.kepid = k.id
GROUP BY t.nev; -->