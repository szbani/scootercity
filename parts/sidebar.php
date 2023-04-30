<nav id="sidebar" class="col-xxl-2 col-xl-3 col-lg-3 d-md-block pe-0 offcanvas-lg offcanvas-start bg-sidebar "
     tabindex="-1">
    <div class="offcanvas-body d-block m-0 p-3">
        <ul class="list-unstyled ps-0 w-100">

            <li class="mb-1 bg-sidebar2">
                <label class="fw-bold ms-2 ">Rendezés</label>
                <select id="sort" class="form-select form-select-sm rounded ">
                    <option value="">a-z sorrendben</option>
                    <option value="z-a">z-a sorrendben</option>
                    <option value="pup">ár szerint növekvő</option>
                    <option value="pdown">ár szerint csökkenő</option>
                </select>
            </li>
            <div id="markak">
                <?php
                require_once 'query/marka.php';
                ?>
            </div>
        </ul>
        <ul class="list-unstyled ps-0 w-100 bg-sidebar3">
            <?php
            $fokat = $db->Select('SELECT * FROM kat_view WHERE subkat IS null GROUP BY nev;');

            if (count($fokat) > 0) {
                foreach ($fokat as $row) {
                    if ($row['alkategoriak'] != Null) {
                        echo '<li class="mb-1 bg-sidebar2"><button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 fw-bold w-100" data-bs-toggle="collapse" data-bs-target="#' . $row['id'] . '-' . $row['nev'] . '" aria-expanded="false">
                      ' . $row['nev'] . '
                      </button>
                      <div class="collapse" id="' . $row['id'] . '-' . $row['nev'] . '">
                      <ul class="btn-toggle-nav mx-auto  list-unstyled">';
                        $kat->kategoriak($db, $row['id']);
                        echo '<li>
                                    <a class="link-dark link rounded text-decoration-none fw-bold cursor" href="/bolt/' . $row['nev'] . '">
                                    mind 
                                    </a>
                                    </li></ul></div></li>';
                    } else {
                        $id = $row['id'];
                        $ertek = $row['nev'];
                        echo '<div class="bg-sidebar2 mb-1"><ul class="btn-toggle-nav sidebar-hover list-unstyled border-bottom">
                      <li>
                      <a class="link-dark link rounded text-decoration-none fw-bold cursor" href="/bolt/' . $ertek . '">
                      ' . $ertek . ' (' . $row['hasznalva'] . ')
                      </a>
                      </li></ul></div>';
                    }
                }
            }
            ?>

        </ul>
    </div>
</nav>
