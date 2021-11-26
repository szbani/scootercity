<div class="row">
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light">
  <div class="sidebar">
    <p class="border-top "></p>
    <ul class="nav flex-column">
      
      <li class=" mb-1">
        <button class="btn btn-toggle w-100 rounded collapsed" data-bs-toggle="collapse" data-bs-target="#kategoriak" aria-expanded="true">
          Kategóriák
        </button>
          
        <div class="collapse show" id="kategoriak">
          <ul class="btn-toggle-nav mx-auto list-unstyled pb-1">
              <?php 
              //termek tipus(kategoria) szinek ar
              include '../query/conn.php';

              $sql = "SELECT * FROM kategoriak";
              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                  $param = $row['kat_nev'];

                  $c_sql = "SELECT COUNT(kategoria) AS count FROM `termek` WHERE kategoria = '".$param."';";
                  $c_result = mysqli_query($conn, $c_sql);
                  if(mysqli_num_rows($c_result) > 0){
                    $count = mysqli_fetch_assoc($c_result);
                  }
                  if(intval($count['count']) > 0){
                    echo '
                    <li>
                      <a class="link-dark rounded">
                        <label class="form-check-label" for="'.$param.'">'.$param.'</label>
                        <input class="form-check-input ms-2" type="checkbox" value="'.$param.'" id="'.$param.'">
                        <label class="form-check-label"> ('.$count['count'].')</label>
                      </a>
                    </li>
                  ';
                  }

                }

              }
              ?>
        
          </ul>
        </div>
      </li>

      <p class="border-top mt-3"></p>
    </ul>
  </div>
</nav>