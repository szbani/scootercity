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
                    createTableLogs();
                </script>

    </body>

    </html>