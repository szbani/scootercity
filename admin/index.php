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
                        DataTable Example
                    </div>
                    <div class="card-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Felhasználó</th>
                                    <th>Tevékenység</th>
                                    <th>Idő</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Felhasználó</th>
                                    <th>Tevékenység</th>
                                    <th>Idő</th>
                                    <th>IP</th>
                                </tr>
                            </tfoot>
                            <?php
                            loadLogs($conn, "SELECT * FROM logs", true, false, false);
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
                    loadTables();
                </script>

    </body>

    </html>