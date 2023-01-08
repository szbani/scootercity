<?php
$sql = "SELECT t.id,t.nev,t.ar,CONCAT(ke.kep, ke.type) AS indexkep,
GROUP_CONCAT(CONCAT(ke.kep, ke.type) SEPARATOR', ') as kepek,
t.leiras,kn.kat_nev,t.tulajdonsagok FROM `termekek` t 
INNER JOIN `kat_nev` kn ON kn.id = t.kategoria 
INNER JOIN `kepek` ke ON ke.id = t.index_kep
INNER JOIN `kepek_fk` kef ON kef.termid = t.id
INNER JOIN `kepek` k on kef.kepid = k.id
GROUP BY t.nev;";
include 'conn.php';

    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            array_push($array, $row);
        }
    }

    echo json_encode($array,0,512);

?>
