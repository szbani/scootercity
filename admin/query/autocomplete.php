<?php
include_once 'conn.php';
$searchTerm = $_GET['term'];
if ($_GET['auto'] == 'nev') {
    $query = $conn->query("SELECT DISTINCT tul_nev FROM termek_tul WHERE tul_nev LIKE '%" . $searchTerm . "%' ORDER BY tul_nev ASC;");
}
if($_GET['auto'] == 'ertek'){
    $nev = $_GET['nev'];
    $query = $conn->query("SELECT DISTINCT tul_nev FROM termek_tul WHERE tul_nev = '$nev' 
    AND tul_ertek LIKE '%" . $searchTerm . "%' ORDER BY tul_nev ASC;");
}
    $skillData = array();
    if ($query->num_rows > 0) {
        $i = 0;
        while ($row = $query->fetch_assoc()) {
            $data['id'] = $i;
            $data['value'] = $row['tul_nev'];
            array_push($skillData, $data);
            $i++;
        }
    }

echo json_encode($skillData);
die();
