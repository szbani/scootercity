<?php
session_start();

include '../query/conn.php';

$szin = $_POST['prod_szin'];
$prod_name = $_SESSION['prod_name'];

$sql = "SELECT p.mennyiseg FROM params p WHERE p.term_id = '$prod_name' AND p.szin = '$szin'";

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);
    $mennyiseg = $row['mennyiseg'];

}

$sql = "SELECT k.kep, k.type FROM kepek k WHERE k.term_id = '$prod_name' AND k.term_szin = '$szin'";
$result = mysqli_query($conn, $sql);
$kepek = '';

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $kepek = $kepek . ' <div class="swiper-slide">
                            <div class="swiper-zoom-container">
                            <img src="/scootercity/media/products/'.$row['kep'].$row['type'].'">
                            </div>
                            </div>';
    }
}else{
    $kepek = '  <div class="swiper-slide">
                <div class="swiper-zoom-container">
                <img src="/scootercity/media/products/nincskep.jpg">
                </div>
                </div>
            ';
}

$return_arr = array('mennyiseg' => $mennyiseg,
                    'kepek' => $kepek  );

echo json_encode($return_arr);


?>