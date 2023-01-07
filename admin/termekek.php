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
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Scootercity - Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
        <link rel="stylesheet" type="text/css" href="css/main.css" />
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
                        <table>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Terméknév</th>
                                    <th>Ár(Ft)</th>
                                    <th>Index Kép</th>
                                    <th>Termék Képek</th>
                                    <th>leírás</th>
                                    <th>Kategória</th>
                                    <th>Tulajdonságok</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Terméknév</th>
                                    <th>Ár(Ft)</th>
                                    <th>Index Kép</th>
                                    <th>Termék Képek</th>
                                    <th>leírás</th>
                                    <th>Kategória</th>
                                    <th>Tulajdonságok</th>
                                    <th>#</th>
                                </tr>
                            </tfoot>
                            <?php
                            $sql = "SELECT t.id,t.nev,t.ar,CONCAT(ke.kep, ke.type) AS indexkep,
                            GROUP_CONCAT(CONCAT(ke.kep, ke.type) SEPARATOR', ') as kepek,
                            t.leiras,kn.kat_nev,t.tulajdonsagok FROM `termekek` t 
                            INNER JOIN `kat_nev` kn ON kn.id = t.kategoria 
                            INNER JOIN `kepek` ke ON ke.id = t.index_kep
                            INNER JOIN `kepek_fk` kef ON kef.termid = t.id
                            INNER JOIN `kepek` k on kef.kepid = k.id
                            GROUP BY t.nev;";
                            loadLogs($conn, $sql, false, true, true);
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
                    loadTablesSortable();
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