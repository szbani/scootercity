<?php
function loadArray($conn){

$sql = "SELECT * FROM admin_users";
$result = mysqli_query($conn, $sql);

$array = array();
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $nev = $row['email'];
        $main = $row['main'];

        array_push($array,
            array($id,$nev,$main)
        );
    }
}

    for($i = 0; $i < count($array); $i++){
        echo'<tr>';
        for($k = 0; $k < count($array[$i]); $k++){
            switch($k){
                case 0:
                    echo
                    '<td id="'.$array[$i][0].'-'.$k.'" name="id" class="fs-5 align-middle">'
                    .$array[$i][$k].'</td>';
                    break;
                case 2:
                    break;
                default:
                    echo
                    '<td id="'.$array[$i][0].'-'.$k.'" class="fs-6 align-middle">'
                    .$array[$i][$k].'</td>';
                    break;
            }
        }
        echo
        '<td class="align-middle">';
        if(($_SESSION['main'] != 1 && $array[$i][2] == 1) || $_SESSION['user'] == $array[$i][1]){
            echo
            '<input type="button" onClick="modify(\''.$array[$i][0].'\')" value="Szerkesztés" class="btn btn-warning btn-sm">';
        }
        if($array[$i][2] == 1 && $_SESSION['main'] == 0){
            echo
            '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delModal" onClick="del_btn('.$array[$i][0].')" >Törlés</button>';
        }
        '</td>
        </tr>';
    }
}

function select_mod($conn){
    $sql = "SELECT id, email FROM admin_users";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $nev = $row['email'];

            echo '<option value="'.$id.'" id="md_option">'.$id." ".$nev.'</option>';
        }
    }
}
?>

