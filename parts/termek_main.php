<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-md-4">
    <div class="row row-cols-2 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
      <?php
        
          $fmt = numfmt_create( 'hu-HU', NumberFormatter::CURRENCY );
          //SELECT t.nev, k.kep, k.type FROM termek t INNER JOIN kepek k ON t.nev = k.term_id
          //SELECT t.nev, t.index_kep, t.ar FROM termek t
          $params = '';
          if(isset($_GET["termek"])){
            $kat = " t.kategoria = '";
            $params = "WHERE".$kat.$_GET["termek"]."'";
            
            if(str_contains($params,"|")){
              $params = str_replace("|","' OR ".$kat,$params);
            }
          }
          
          $sql = "SELECT t.id,t.nev,t.ar, 
          (SELECT file_name FROM kepek k 
          WHERE k.termek_id = t.id 
          ORDER BY img_order LIMIT 1)as image 
          FROM `termekek` t; ";
          $result = mysqli_query($conn, $sql);
    
          if(mysqli_num_rows($result) > 0){
    
            while($row = mysqli_fetch_assoc($result)){
              $price = str_replace(',00','',numfmt_format_currency($fmt, $row['ar'], "HUF"));
              $kep = $row['image'];
              if($row['image'] == null) $kep = 'product-placeholder.png';
              echo '<div class="col mt-3">
              <div class="card" id="'.$row['nev'].'">
                
                  <img src="/media/products/'.$kep.'" class="card-img-top" alt="Termék">
                  <div class="card-body">
                    <h5 class="card-title" id="Param_Nev">'.$row['nev'].'</h5>
                  </div>
                  <ul class="list-group list-group-flush d-flex">
                      <li class="list-group-item d-flex justify-content-between">
                          <h5 class="m-0">'.$price.'</h5>
                      </li>
                  </ul>
                  <a class="card_click" href="/bolt/termek/'.$row['id'].'/'.$row['nev'].'"></a>
              </div>
              </div>';
            }
    
          }
        
      ?>

    </div>
    <!--row end-->
    <div id="termek_modal"></div>


    