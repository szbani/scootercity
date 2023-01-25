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
        <?php include_once 'parts/navbar.html'; ?>
        <div id="layoutSidenav">
            <?php include_once 'parts/sidebar.php'; ?>
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
                        <table id="table" class="table table-striped table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Felhasználó</th>
                                    <th>Tevékenység</th>
                                    <th>Idő</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                </main>
                <?php
                if (empty($_GET['page'])) {
                    include_once "query/floatingAlert.php";
                    include_once 'parts/footer.php';
                }
                ?>
                <script>
                    createTableLogs();
                </script>

    </body>

    </html>