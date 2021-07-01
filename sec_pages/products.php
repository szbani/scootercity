<div id="body">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
      <h2>Termékek</h2>
      <div class="btn-toolbar mb-2 mb-md-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#product_add_modal">Termék Felvétele <i class="bi bi-plus-lg"></i></button>
            
      </div>
  </div>
    <?php session_start();
     include_once "../php/errors.php";?>
      <div class="table-responsive">
        <table class="table table-striped table-sm table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Termék Neve</th>
              <th>Képe</th>
              <th>Ára</th>
              <th>Leírása</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php 
            include_once("../php/mysql_conn.php");
          
              $sql = "SELECT id, name, image, price, description FROM products";
              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_assoc($result)){
                  echo '<tr>
                  <td class="align-middle">'.$row["id"].'</td>
                  <td class="align-middle">'.$row["name"].'</td>
                  <td class="align-middle"><img loading="lazy" src="sec_images/'.$row['image'].'" class="image-sm"></td>
                  <td class="align-middle">'.$row["price"].'</td>
                  <td class="align-middle">'.$row["description"].'</td>
                  <td class="col-auto text-end">
                    <form action="/webshop_test/php/product_edit.php" method="POST">
                    <input type="submit" value="Szerkesztés" class="btn btn-info btn-sm" name="prod_edit">
                    <input type="submit" value="Törlés" class="btn btn-danger btn-sm" name="prod_del">
                    <input type="hidden" name="id" value="'.$row["id"].'" />
                    </form>
                  </td>
                  </tr>';
                }

              }

              $conn->close();
          ?>
            
          </tbody>
        </table>
      </div>
    
      <!-- #region modal-->
      <div class="modal fade" id="product_add_modal" tabindex="-1"  >   
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modallabel">Termék Hozzáadása</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        
        <form class="row g-3" action="/webshop_test/php/product_up.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="col-12">
                <label for="inputname" class="form-label">Termék neve</label>
                <input type="text" class="form-control" name="name" id="inputname">
              </div>
            <div class="col-12">
            <label for="inputprice" class="form-label">Kép</label>
            
              <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item" style="cursor: pointer;" >
                  <a class="nav-link  active" onclick="nav_switch()" data-bs-toggle="tab" data-bs-target="#prodUpload" role="tab" aria-controls="prodUpload" aria-selected="true" id="prod-upload-tab">Új feltöltése</a>    
                </li>
                <li class="nav-item" style="cursor: pointer;">
                  <a class="nav-link" data-bs-toggle="tab" onclick="nav_switch()" data-bs-target="#prodSelect" role="tab" aria-controls="prodSelect" aria-selected="false" id="prod-select-tab">Már meglévő kiválasztás</a>    
                </li>
              </ul>

              <div class="tab-content" id="tabContent">
                  <div class="tab-pane fade show active" id="prodUpload" role="tabpanel" aria-labelledby="prod-upload-tab">
                    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                  </div>
                  <div class="tab-pane fade" id="prodSelect" role="tabpanel" aria-labelledby="prod-select-tab">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Select-Image">Kép:</label>
                    </div>
                    <input type="text" class="form-control" name="fileToSelect" id="fileToSelect" readonly />
                    <div class="overflow-auto pt-1 mt-1" style="max-height:150px;" >
                    <?php
                       $dirname = "../sec_images/";
                       $images = glob($dirname."*.jpg");
                      foreach($images as $image) {
                        $image = str_replace("../", "",$image);
                        $id = str_replace("sec_images/", "", $image);
                        echo '<img class="image-md ms-1 mt-1" onclick="fileToSelect(this)" id="'.$id.'" style="cursor: pointer;"  loading="lazy" alt="'.$image.'" src="'.$image.'"/>';
                        }
                       $images = glob($dirname."*.png");
                      foreach($images as $image) {
                        $image = str_replace("../", "",$image);
                        $id = str_replace("sec_images/", "", $image);
                        echo '<img class="image-md ms-1 mt-1" onclick="fileToSelect(this)" id="'.$id.'" style="cursor: pointer;"  loading="lazy" alt="'.$image.'" src="'.$image.'"/>';
                        }
                       $images = glob($dirname."*.jpeg");
                      foreach($images as $image) {
                        $image = str_replace("../", "",$image);
                        $id = str_replace("sec_images/", "", $image);
                        echo '<img class="image-md ms-1 mt-1" onclick="fileToSelect(this)" id="'.$id.'" style="cursor: pointer;"  loading="lazy" alt="'.$image.'" src="'.$image.'"/>';
                        }
                      ?>
                    </div>
                    
                  </div>
                  </div>
              </div>

            </div>
            <div class="col-12">
                <label for="inputprice" class="form-label">Ár</label>
                 <input type="text" class="form-control" name="price" id="inputprice">
              </div>
            <div class="col-12">
                <label for="inputdesc" class="form-label">Leírás</label>
                <input type="text" class="form-control" name="desc" id="inputdesc">
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Termék felvétele" class="btn btn-primary" name="product_upload"></button>
          </div>
        </div>

        </form>
        
        </div>
      </div>
      </div>
      </div>
      <!-- #endregion modal -->

