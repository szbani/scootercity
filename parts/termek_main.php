<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 140px;">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
      <?php
      $fmt = numfmt_create( 'hu-HU', NumberFormatter::CURRENCY );
      include '../query/conn.php';
      
      //SELECT t.nev, k.kep, k.type FROM termek t INNER JOIN kepek k ON t.nev = k.term_id
      $sql = "SELECT t.nev, t.index_kep, t.ar FROM termek t";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
          $price = str_replace(',00','',numfmt_format_currency($fmt, $row['ar'], "HUF"));
          echo '<div class="col mt-3">
          <div type="submit" class="card" id="'.$row['nev'].'" onclick="modal_show(this)">
              <img src="/scootercity/media/products/'.$row['index_kep'].'" class="card-img-top" alt="Termék">
              <div class="card-body">
                <h5 class="card-title" id="Param_Nev">'.$row['nev'].'</h5>
              </div>
              <ul class="list-group list-group-flush d-flex">
                  <li class="list-group-item d-flex justify-content-between">
                      <h5 class="m-0">'.$price.'</h5>
                  </li>
              </ul>
              <div class="card_click"></div>
          </div>
          </div>';
        }

      }
      ?>

    </div>
    <!--row end-->
    <div id="termek_modal"></div>


    