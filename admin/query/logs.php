<?php

function loadTermekek($conn, $sql){
    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            array_push($array, $row);
        }
    }
    echo '<tbody>';
    foreach ($array as $arr) {
        arrayEcho($arr, true, true,true);
    }
    echo '</tbody>';
}
function loadLogs($conn, $sql, $reverse, $modify, $delete)
{
    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, 1)) {
            array_push($array, $row);
        }
    }
    echo '<tbody>';
    if ($reverse) {
        foreach (array_reverse($array) as $arr) {
            arrayEcho($arr, $delete, $modify,false);
        }
    } else {
        foreach ($array as $arr) {
            arrayEcho($arr, $delete, $modify,false);
        }
    }
    echo '</tbody>';
}

function arrayEcho($arr, $delete, $modify,$childrow)
{
    echo '<tr id="' . $arr['id'] . '">';
    if($childrow)echo'<td class="dt-control"></td>';
    foreach ($arr as $key => $val) {
        if ($key == "id") $font = "fs-6";
        else $font = "fs-5";
        echo
        '<td id="' . $key . '" class="' . $font . ' align-middle overflow-auto">' . $val . '</td>';
    }
    if ($modify) {
        modif($arr['id']);
        if (!$delete) echo '</td></tr>';
    }
    if ($delete) {
        if (!$modify) echo '<td class="align-middle">';
        delete($arr['id']);
    }
    if (!$modify && !$delete) echo '</tr>';
}
function modif($id)
{
    echo '<td class="align-middle">';
    echo '<input type="button" data-bs-toggle="modal" data-bs-target="#modifyModal"
     onClick="modify(\'' . $id . '\')" value="Módosítás" class="btn btn-warning btn-sm">';
}
function delete($id)
{
    echo '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delModal"
     onClick="del_btn(' . $id . ')" >Törlés</button> 
     </td></tr>';
}
