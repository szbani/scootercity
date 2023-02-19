<?php
require_once 'query/conn.php';
$url = explode("/", $_SERVER['REQUEST_URI']);

$fmt = numfmt_create('hu-HU', NumberFormatter::CURRENCY);
//SELECT t.nev, k.kep, k.type FROM termek t INNER JOIN kepek k ON t.nev = k.term_id
//SELECT t.nev, t.index_kep, t.ar FROM termek t
$params = '';
if (isset($_GET["termek"])) {
  $kat = " t.kategoria = '";
  $params = "WHERE" . $kat . $_GET["termek"] . "'";

  if (str_contains($params, "|")) {
    $params = str_replace("|", "' OR " . $kat, $params);
  }
}
?>
<!DOCTYPE html>
<html>
<?php
require_once 'parts/head.php';
?>

<body>
  <?php
  include_once "parts/navbar.php";
  ?>
  <!-- sidebar -->
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light">
      <div class="sidebar">
        
      
      
      
      <p class="border-top"></p>
        <ul class="nav flex-column">

          <li class=" mb-1">
            <button class="btn btn-toggle w-100 rounded collapsed" data-bs-toggle="collapse" data-bs-target="#kategoriak" aria-expanded="true">
              Kategóriák
            </button>

            <div class="collapse show" id="kategoriak">
              <ul class="btn-toggle-nav mx-auto list-unstyled pb-1">
                <?php
                //termek tipus(kategoria) szinek ar

                $sql = "SELECT * FROM kategoriak";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $param = $row['id'];

                    $c_sql = "SELECT COUNT(kategoria) AS count FROM `termekek` WHERE kategoria = '" . $param . "';";
                    $c_result = mysqli_query($conn, $c_sql);
                    if (mysqli_num_rows($c_result) > 0) {
                      $count = mysqli_fetch_assoc($c_result);
                    }
                    if (intval($count['count']) > 0) {
                      echo '
                        <li>
                          <a class="link-dark rounded">
                            <label class="form-check-label" for="' . $param . '">' . $row['nev'] . '</label>
                            <input class="form-check-input ms-2" type="checkbox" value="' . $param . '" id="' . $param . '">
                            <label class="form-check-label"> (' . $count['count'] . ')</label>
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
          <?php
          $sql = "SELECT DISTINCT tul_nev FROM termek_tul;";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $nev = $row['tul_nev'];
              $sql = "SELECT tul_ertek AS ertek, COUNT(tul_ertek) AS szam FROM termek_tul where tul_nev = '$nev' GROUP BY tul_ertek;";
              $result2 = mysqli_query($conn, $sql);
              echo '<li class="">
                  <button class="btn btn-toggle w-100 rounded collapsed" data-bs-toggle="collapse" data-bs-target="#' . $nev . '" aria-expanded="true">
                    ' . $nev . '
                  </button><div class="collapse" id="' . $nev . '">
                  <ul class="btn-toggle-nav mx-auto list-unstyled pb-1">';
              while ($row2 = mysqli_fetch_assoc($result2)) {
                // itt meg van mit csinalni
                $ertek = $row2['ertek'];
                echo '<li>
                    <a class="link-dark rounded">
                    <label class="form-check-label" for="' . $ertek . '">' . $ertek . '</label>
                    <input class="form-check-input ms-2" type="checkbox" value="' . $ertek . '">
                    <label class="form-check-label"> (' . $row2['szam'] . ')</label>
                    </a>
                    </li>';
              }
              echo '</ul>
                  </div>';
            }
          }

          ?>

    


      <p class="border-top mt-3"></p>
      </ul>
  </div>
  </nav>
  <!-- sidebar end -->
  <!-- termekek -->
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-md-4">
    <div class="row row-cols-2 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 mb-3">
      <?php
      $sql = "SELECT t.id,t.nev,t.ar, t.leiras,
          (SELECT file_name FROM kepek k 
          WHERE k.termek_id = t.id 
          ORDER BY img_order LIMIT 1)as image 
          FROM `termekek` t $params; ";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
          $price = str_replace(',00', '', numfmt_format_currency($fmt, $row['ar'], "HUF"));
          $kep = $row['image'];
          if ($row['image'] == null) $kep = 'product-placeholder.png';
          echo '<div class="col mt-3">
                    <div class="card bg-white rounded shadow-sm">
                      <img src="/media/products/' . $kep . '" class="card-img-top" alt="Termék">
                      <div class="card-body">
                        <p class="card-title fw-bold" id="Param_Nev">' . $row['nev'] . '</p>
                      </div>
                      <div class="p-2">
                      <div class="d-flex align-items-center justify-content-between rounded-pill bg-mint2 px-3 py-2">
                        <h5 class="mb-0"><span>' . $price . '</span></h5>
                      </div>
                      </div>
                    
                  <a class="card_click" href="/bolt/termek/' . $row['id'] . '/' . $row['nev'] . '"></a>
                </div>
              </div>';
        }
      }

      ?>

    </div>
    <!--row end-->
    <div id="termek_modal"></div>
  </main>
  </div>
  <?php
  require_once 'parts/footer.php';
  ?>
</body>

</html>