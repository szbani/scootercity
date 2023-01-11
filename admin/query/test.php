<?php
require 'conn.php';

$sql = "SELECT t.id,t.nev,t.ar,
(SELECT kep FROM kepek WHERE id =kef.kepid ORDER by sorrend) as indexkep,
JSON_ARRAYAGG(k.kep ORDER BY sorrend) as kepek,
t.leiras,kn.kat_nev,t.tulajdonsagok FROM `termekek` t 
INNER JOIN `kat_nev` kn ON kn.id = t.kategoria 
INNER JOIN `kepek_fk` kef ON kef.termid = t.id
INNER JOIN `kepek` k on kef.kepid = k.id
GROUP BY t.nev;";

    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            array_push($array, $row);
        }
    }
    echo json_encode($array,0,512);



    // SELECT t.id,t.nev,t.ar,
    // JSON_ARRAYAGG(CONCAT(k.kep, k.type) ORDER BY sorrend) as kepek,
    // t.leiras,kn.kat_nev,t.tulajdonsagok FROM `termekek` t 
    // INNER JOIN `kat_nev` kn ON kn.id = t.kategoria 
    // INNER JOIN `kepek_fk` kef ON kef.termid = t.id
    // INNER JOIN `kepek` k on kef.kepid = k.id
    // GROUP BY t.nev;

// SELECT t.id,t.nev,t.ar,CONCAT(ke.kep, ke.type) AS indexkep,
// (SELECT JSON_ARRAYAGG(CONCAT(k.kep,k.type) ORDER BY sorrend) FROM kepek_fk kef
// INNER JOIN kepek k on k.id = kef.kepid
// WHERE t.id = kef.termid
// ORDER by kef.sorrend) as kepek,
// t.leiras,kn.kat_nev,t.tulajdonsagok FROM `termekek` t 
// INNER JOIN `kat_nev` kn ON kn.id = t.kategoria 
// INNER JOIN `kepek` ke ON ke.id = t.index_kep
// GROUP BY t.nev
// ORDER BY t.nev;
?>
