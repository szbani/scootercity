<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (isset($_POST['table'])) {
        define('ACCESS_ALLOWED', true);
        require 'conn.php';

        if ($_POST['table'] == 'termekek') {
            $sql = "SELECT t.*,k.nev as knev,
		(SELECT nev FROM marka m WHERE m.id = t.marka) as markanev,
		(SELECT discountPrice from discount d where d.termek_id = t.id) as learazas,
		(SELECT SUM(tm.mennyiseg) FROM termek_menny tm WHERE tm.termek_id = t.id) as mennyiseg,
		(SELECT GROUP_CONCAT(tm.meret, ':', tm.mennyiseg) FROM termek_menny tm WHERE tm.termek_id = t.id) as meretek,
        (SELECT GROUP_CONCAT(file_name ORDER BY img_order) FROM kepek k WHERE k.termek_id = t.id) as images,
        (SELECT JSON_ARRAYAGG(JSON_OBJECT(tu.tul_nev,tu.tul_ertek)) FROM termek_tul tu WHERE tu.termek_id = t.id) AS tulajdonsagok FROM `termekek` t
            INNER JOIN `kategoriak` k ON k.id = t.kategoria;";
            $result = mysqli_query($conn, $sql);
        } else if ($_POST['table'] == 'logs') {
            $sql = "SELECT * FROM logs";
            $result = mysqli_query($conn, $sql);
        } else if ($_POST['table'] == 'fiokok') {
            $sql = "SELECT a.*, a.email AS nev,
	    (SELECT CONCAT(l.action,' ',l.time) FROM logs l 
        WHERE l.action LIKE 'Bejelentkezett' AND l.user = a.email
        ORDER BY l.time DESC LIMIT 1) as action
        FROM `admin_users` a;";
            $result = mysqli_query($conn, $sql);
        } else if ($_POST['table'] == 'kategoriak') {
            $sql = "SELECT k.*,(SELECT ke.nev FROM kategoriak ke WHERE ke.id = k.subkat) AS subnev, (SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva  
        FROM `kategoriak` k
        GROUP BY k.nev;";
            $result = mysqli_query($conn, $sql);
        } else if ($_POST['table'] == 'markak') {
            $sql = "SELECT m.*, (SELECT COUNT(t.nev) FROM termekek t WHERE m.id = t.marka) as hasznalva  
        FROM `marka` m
        GROUP BY m.nev;";
            $result = mysqli_query($conn, $sql);
        }

        $array = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, 1)) {
                if ($_POST['table'] == 'fiokok') {
                    $data = array();
                    if ($_SESSION['main'] == 0 || $_SESSION['user'] == $row['email']) {
                        $data += ['edit' => '<i class="fa fa-pencil"/>'];
                    } else $data += ['edit' => ""];
                    if ($_SESSION['main'] == 0 && $_SESSION['user'] != $row['email']) {
                        $data += ['delete' => '<i class="fa fa-trash"/>'];
                    } else $data += ['delete' => ""];
                    array_push($array, array_merge($row, $data));
                } else {
                    array_push($array, $row);
                }
            }
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE, 512);
    }
} else {
    // require "conn.php";
    // session_start();
    // $sql = "SELECT t.*,k.nev as knev, (SELECT GROUP_CONCAT(file_name ORDER BY img_order) FROM kepek k WHERE k.termek_id = t.id) as images FROM `termekek` t 
    // INNER JOIN `kategoriak` k ON k.id = t.kategoria WHERE t.id = 103 ";
    // $result = mysqli_query($conn, $sql);
    // $array = array();
    // if (mysqli_num_rows($result) > 0) {
    //     while ($row = mysqli_fetch_array($result, 1)) {

    //         array_push($array,array_merge($row,$tuls));

    //         // array_push($array, array_merge($row, $data));
    //     }
    // }
    // var_dump($array);
    header('Location: ' . "http://" . $_SERVER['HTTP_HOST'] . '/adminpage/login.php');
    die();
}




// CREATE VIEW menny_pivot AS(SELECT tm.*,
//                            CASE WHEN tm.meret = "M" THEN tm.mennyiseg END AS M,
//                            CASE WHEN tm.meret = "XL" THEN tm.mennyiseg END AS XL
//                            FROM `termek_menny` tm); 


// CREATE VIEW menny_pivot_2 AS(SELECT termek_id, SUM(M) as M, SUM(XL) AS XL FROM menny_pivot GROUP BY termek_id);

// ALTER VIEW kat_view AS(SELECT k.*, (SELECT GROUP_CONCAT(id) FROM kategoriak k2 WHERE k2.subkat = k.id) AS alkategoriak, 
// (SELECT COUNT(t.nev) FROM termekek t WHERE k.id = t.kategoria) as hasznalva FROM `kategoriak` k GROUP BY nev); 


// ALTER VIEW Bolt AS(SELECT t.id, t.nev,t.ar,t.leiras,k.nev AS knev,
//                     (SELECT file_name FROM kepek k WHERE k.termek_id = t.id ORDER BY img_order LIMIT 1)AS indeximg,
//                     (SELECT GROUP_CONCAT(file_name ORDER BY img_order) FROM kepek k WHERE k.termek_id = t.id) as images,
//                     (SELECT JSON_ARRAYAGG(JSON_OBJECT(tu.tul_nev,tu.tul_ertek)) FROM termek_tul tu WHERE tu.termek_id = t.id) AS tulajdonsagok
//                     FROM termekek t INNER JOIN kategoriak k ON k.id = t.kategoria);
//
//CREATE VIEW bolt AS(
//SELECT`t`.`id` AS `id`,`t`.`nev` AS `nev`,`t`.`ar` AS `ar`,`t`.`leiras` AS `leiras`,`k`.`nev` AS `knev`,
//(SELECT`k`.`file_name`FROM `kepek` `k` WHERE `k`.`termek_id` = `t`.`id`ORDER BY `k`.`img_order` LIMIT 1) AS `indeximg`,
//(SELECT GROUP_CONCAT(`k`.`file_name`ORDER BY`k`.`img_order` ASC SEPARATOR ',')FROM `kepek` `k`WHERE `k`.`termek_id` = `t`.`id`) AS `images`,
//(SELECT`m`.`nev`FROM `marka` `m`WHERE`t`.`marka` = `m`.`id`) AS `marka`,
//(SELECT json_arrayagg(json_object(`tu`.`tul_nev`, `tu`.`tul_ertek`))FROM`termek_tul` `tu`WHERE`tu`.`termek_id` = `t`.`id`) AS `tulajdonsagok`
//FROM( `termekek` `t`JOIN `kategoriak` `k`ON(`k`.`id` = `t`.`kategoria`))



