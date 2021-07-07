
   <div id="body">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
      <h2>Felhasználók</h2>
  </div>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>ID</th>
              <th>Felhasználónév</th>
              <th>Email</th>
              <th>Keresztnév</th>
              <th>Vezetéknév</th>
              <th>Lakcím</th>
              <th>Aktiválva</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $host = "localhost";
            $username = "jatekos";
            $password = "amiajoketoyou";
            $dbname = "webshop";
            $port = "3306";

            $conn = new mysqli($host,$username,$password,$dbname,$port);

            if (!$conn) {
              die("Connection failed: " . mysqli_connect_error());
            }
              $sql = "SELECT u.id, u.username, e.email, u.vezeteknev, u.keresztnev, u.lakcim, u.activated  FROM users u JOIN emails_confirmed e ON u.email = e.id";
              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_assoc($result)){
                  echo '<tr>
                  <td>'.$row["id"].'</td>
                  <td>'.$row["username"].'</td>
                  <td>'.$row["email"].'</td>
                  <td>'.$row["vezeteknev"].'</td>
                  <td>'.$row["keresztnev"].'</td>
                  <td>'.$row["lakcim"].'</td>
                  <td>';
                  if($row["activated"] == 1){
                     echo "Igen";
                  }else{
                    echo "Nem";
                  }
                  echo '</td>
                  <td class="col-1 text-end">Szerkesztés</td>
                  <td class="col-1 text-center">Törlés</td>
                  </tr>';
                }

              }

              $conn->close();
          ?>
            
          </tbody>
        </table>

      </div>
    
      
    </div>
