<nav class="col-md-3 col-lg-2 d-md-block pe-0 bg-sidebar ">
    <div class="flex-shrink-0 m-0 p-3">
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <select id="sort" class="form-select form-select-sm rounded ">
                    <option value="">a-z sorrendben</option>
                    <option value="z-a">z-a sorrendben</option>
                    <option value="pup">ár szerint növekvő</option>
                    <option value="pdown">ár szerint csökkenő</option>
                </select>
            </li>

            <?php
            $fokat = $db->Select('SELECT * FROM kat_view WHERE subkat IS null GROUP BY nev;');

            if (count($fokat) > 0) {
                foreach ($fokat as $row) {
                    if ($row['alkategoriak'] != Null) {
                        echo '<li class="mb-1 bg-sidebar2"><button class="btn btn-toggle w-100  d-inline-flex align-items-center rounded border-0 collapsed fw-bold" data-bs-toggle="collapse" data-bs-target="#' . $row['id'] . '-' . $row['nev'] . '" aria-expanded="true">
                      ' . $row['nev'] . '
                      </button>
                      <div class="collapse show" id="' . $row['id'] . '-' . $row['nev'] . '">
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
                        echo '<ul class="btn-toggle-nav mx-auto list-unstyled pb-1 border-bottom">
                      <li class="">
                      <a class="link-dark link rounded text-decoration-none fw-bold cursor" href="/bolt/' . $ertek . '">
                      ' . $ertek . ' (' . $row['hasznalva'] . ')
                      </a>
                      </li></ul>';
                    }
                }
            }
            ?>

        </ul>
    </div>
</nav>
