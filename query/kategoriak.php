<?php

class kategoriak{
public function kategoriak($db, $id)
{
    $subkat = $db->Select('SELECT * FROM kat_view WHERE subkat = ' . $id . ' GROUP BY nev;');
    foreach ($subkat as $row) {
        if ($row['alkategoriak'] != Null) {
            echo '<li>
            <button class="btn btn-toggle w-100 d-inline-flex align-items-center rounded border-0 collapsed fw-bold" data-bs-toggle="collapse" data-bs-target="#' . $row['id'] . '-' . $row['nev'] . '" aria-expanded="true">
            ' . $row['nev'] . '
            </button>
            <div class="collapse show" id="' . $row['id'] . '-' . $row['nev'] . '">
            <ul class="btn-toggle-nav mx-auto list-unstyled">';
            $this->kategoriak($db, $row['id']);

            echo '<li>
            <a class="link-dark link rounded text-decoration-none fw-bold cursor" href="/bolt/' . $row['nev'] . '">
            mind
            </a>
            </li>
            </ul></div></li>';
        } else {
            $id = $row['id'];
            $ertek = $row['nev'];
            echo '<li>
            <a class="link-dark link rounded text-decoration-none fw-bold cursor" href="/bolt/' . $ertek . '">
            ' . $ertek . ' (' . $row['hasznalva'] . ')
            </a>
            </li>';
        }
    }
}

public function subkats($kat, $db): string
{
    $vissza = '';
    $temp = $db->SELECT("SELECT alkategoriak_nev as kats FROM kat_view WHERE nev like '$kat'");
    if ($temp[0]['kats'] == null) {
        $vissza .= $kat;
    } else {
        foreach (explode(',', $temp[0]['kats']) as $k) {
            if ($vissza != '') $vissza .= ',';
            $vissza .= $this->subkats($k, $db);
        }

    }
//    var_dump($vissza);
//    var_dump($kat);
    return $vissza;
}
}
