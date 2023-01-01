<?php

function loadLogs($conn, $sql)
{
    //tul sok rekordnál lehet lassú lesz a lekérdezés
    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
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
function loadSzurok($conn, $sql)
{
    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            array_push($array, $row);
        }
    }
    echo
    '<thead>
        <tr>';
        foreach($array as $key => $val){
            echo '<th>'.$key.'</th>';
            
        };
        
        // <th>Felhasználó</th>
        // <th>#</th>
        echo'</tr>
    </thead>';
    foreach ($array as $val) {
        echo '<tr id="' . $val . '">
        <td id="' . $val . '" class="fs-5 align-middle">' . $val . '</td>
        </tr>';
    }
}
