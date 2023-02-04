<?php

if(!empty($_POST['search'])){
    require_once 'conn.php';
    $search = mysqli_real_escape_string($conn,$_POST['search']);

    $sql = "SELECT t.id,t.nev,t.ar, 
    (SELECT file_name FROM kepek k 
    WHERE k.termek_id = t.id 
    ORDER BY img_order LIMIT 1)as image 
    FROM `termekek` t WHERE t.nev LIKE '%{$search}%'; ";
    $result = mysqli_query($conn,$sql);
    $html ='';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $image = 'product-placeholder.png';
            if($row['image'] != null){
             $image = $row['image'];  
            }
            $html .= "<li class='list-group-item'><a class='row' href='/bolt/termek/".$row['id']."/".$row['nev']."'>
            <div class='col-3'><img class='image-search' src='/media/products/".$image."'></div><div class='col-7'>" . $row['nev'] . 
            "</div><div class='col-2'>".$row['ar']."</div></a></li>";
            
        }
        
    } else {
          $html .= '<li class="list-group-item">Nincs találat!</li>';
    }
    echo $html;
}

?>