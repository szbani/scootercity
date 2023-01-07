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
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div>
                    Kategória
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link link" href="kategoria-nevek.php">Nevek</a>
                        <a class="nav-link link" href="kategoria-tulajdonsagok.php">Tulajdonságok</a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    szűrők
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                            Termék
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link link" href="meretek.php">Méretek</a>
                                <a class="nav-link link" href="szinek.php">Színek</a>
                            </nav>
                        </div>
                    </nav>
                </div>
                <a class="nav-link link" href="kepek.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Képek
                </a>
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