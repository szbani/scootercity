<?php
require_once 'query/conn.php';
$url = explode("/", $_SERVER['REQUEST_URI']);

$fmt = numfmt_create('hu-HU', NumberFormatter::CURRENCY);
//SELECT t.nev, k.kep, k.type FROM termek t INNER JOIN kepek k ON t.nev = k.term_id
//SELECT t.nev, t.index_kep, t.ar FROM termek t
// SELECT t.id,t.nev,t.ar, t.leiras,
//           (SELECT file_name FROM kepek k 
//           WHERE k.termek_id = t.id 
//           ORDER BY img_order LIMIT 1)as image 
//           FROM `termekek` t 
//           INNER JOIN termek_tul tul ON tul.termek_id = t.id 
//           WHERE (tul.tul_nev = 'tul3' AND tul.tul_ertek = 'tul3') OR (tul.tul_nev = 'tul2' AND tul.tul_ertek = 'tul2') OR (tul.tul_nev = 'gdf' AND tul.tul_ertek = 'fdg')
//           GROUP BY t.nev;
$params = '';
$katSzuro = '';
if ($_SERVER['QUERY_STRING'] != '') {
  $rawQuery = urldecode($_SERVER['QUERY_STRING']);
  $rawQuery = str_replace('%20', ' ', $rawQuery);
  $query = explode('&', $rawQuery);
  $params2 = '';
  foreach ($query as $key => $value) {
    $tul = explode('=', $value);
    $nev = $tul[0];
    if ($params2 != '') $params2 .= ' AND ';
    if ($katSzuro != '' && $nev == 'kategoria') $katSzuro .= ' OR ';
    

    if (!str_contains($params, 'INNER JOIN') && $nev != 'kategoria' && $nev != 'keyword') {
      $params .= "INNER JOIN termek_tul tul ON tul.termek_id = t.id ";
    }
    if ($nev == 'keyword') {
      if (!str_contains($params2, 'WHERE')) {
        $params2 .= ' WHERE ';
      } else {
        $params2 .= ' AND ';
      }
      $params2 .= "t.nev LIKE '%{$tul[1]}%'";
    } else if ($nev == 'kategoria') {
      if ($katSzuro == '') $katSzuro .= ' WHERE ';
      $katSzuro .= "te.kategoria = '$tul[1]' ";
      $katSzuro = str_replace("|", "' OR te.kategoria = '", $katSzuro);
      $params2 .= " t.kategoria = '$tul[1]' ";
      $params2 = str_replace("|", "' OR t.kategoria = '", $params2);
    } else {
      $params2 .= " tul.tul_nev = '$nev' AND (";
      $ertekek = explode('|', $tul[1]);
      $tempParam = "";
      foreach ($ertekek as $key => $value) {
        if ($tempParam != "") $tempParam .= ' OR ';
        $tempParam .= "tul.tul_ertek = '$value' ";
      }
      $params2 .= $tempParam . ')';
    }
  }
  if (!str_contains($params2, 'WHERE')) $params .= ' WHERE ';
  $params .= $params2;
}
var_dump($katSzuro);
echo '<br>';
var_dump($params);

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
    <nav class="col-md-3 col-lg-2 d-md-block bg-light">
      <div class="flex-shrink-0 p-3">
        <ul class="list-unstyled ps-0">
          <li class="mb-1">
            <select class="form-select form-select-sm rounded ">
              <option>a-z sorrendben</option>
              <option value="z-a">z-a sorrendben</option>
              <option value="pup">ár szerint növekvő</option>
              <option value="pdown">ár szerint csökkenő</option>
            </select>
          </li>
          <li class="mb-1">
            <button class="btn btn-toggle w-100 d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#kategoriak" aria-expanded="true">
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
                        <li class="mt-1">
                          <a class="link-dark rounded">
                            <label class="form-check-label" for="' . $param . '">' . $row['nev'] . '</label>
                            <input class="form-check-input ms-2" type="checkbox" value="kategoria=' . $param . '" id="' . $param . '">
                            <label class="form-check-label "> (' . $count['count'] . ')</label>
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
          $sql = "SELECT DISTINCT tul_nev FROM termek_tul tul INNER JOIN termekek te ON tul.termek_id = te.id $katSzuro;";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              $nev = $row['tul_nev'];
              $sql = "SELECT tul_ertek AS ertek, COUNT(tul_ertek) AS szam FROM termek_tul where tul_nev = '$nev' GROUP BY tul_ertek;";
              $result2 = mysqli_query($conn, $sql);
              echo '<li class="mb-1 ">
                  <button class="btn btn-toggle w-100 d-inline-flex align-items-center rounded border-0" data-bs-toggle="collapse" data-bs-target="#' . $i . '" aria-expanded="true">
                    ' . $nev . '
                  </button><div class="collapse show" id="' . $i . '">
                  <ul class="btn-toggle-nav mx-auto list-unstyled pb-1">';
              while ($row2 = mysqli_fetch_assoc($result2)) {
                $ertek = $row2['ertek'];
                echo '<li class="mt-1">
                    <a class="link-dark rounded text-decoration-none ">
                    <label class="form-check-label" for="' . $nev . '-' . $ertek . '">' . $ertek . '</label>
                    <input class="form-check-input ms-2" id="' . $nev . '-' . $ertek . '" type="checkbox" value="' . $nev . '=' . $ertek . '">
                    <label class="form-check-label "for="' . $nev . '-' . $ertek . '"> (' . $row2['szam'] . ')</label>
                    </a>
                    </li>';
              }
              echo '</ul>
                  </li>
                  <p class="border-top"></p>
                  ';
              $i++;
            }
          }

          ?>

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
          FROM `termekek` t 
          $params ORDER BY t.nev ASC; ";
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