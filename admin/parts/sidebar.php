<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-color" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Main</div>
                <a class="nav-link link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-lines-leaning"></i></div>
                    Áttekintés
                </a>
                <a class="nav-link link" href="termekek.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Termékek
                </a>
                <a class="nav-link link" href="kategoriak.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Kategórák
                </a>
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link link" href="fiokok.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Fiókok
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bejelentkezve mint:</div>
            <?php
            echo $_SESSION['user'];
            ?>
        </div>
    </nav>
</div>