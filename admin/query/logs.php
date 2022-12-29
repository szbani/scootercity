<?php

function loadLogs($conn)
{
    //tul sok rekordnál lehet lassú lesz a lekérdezés
    $sql = "SELECT * FROM logs";
    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result,1)) {
            array_push($array, $row);
        }
    }
    foreach (array_reverse($array) as $arr) {
        echo '<tr id="' . $arr['id'] . '">';
        foreach ($arr as $key => $val) {
            if ($key == "id") $font = "fs-6";
            else $font = "fs-5";
            echo
            '<td id="' . $key . '" class="' . $font . ' align-middle">' . $val . '</td>';
        }
        echo '</tr>';
    }
}
