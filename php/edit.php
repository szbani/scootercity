<?php  
if(isset($_SESSION['edit'])) {
	$edits = $_SESSION['edit'];
		?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#prod_edit_modal').modal('show');
    });
</script>
    <div class="modal fade" id="prod_edit_modal" tabindex="-1">   
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
                <input type="text" class="form-control" value="<?php echo $edits[2];?>" name="name" id="inputname">
              </div>
            <div class="col-12">
            <label for="inputprice" class="form-label">Kép</label>
            
              <ul class="nav nav-tabs nav-justified" id="editTab" role="tablist">
                <li class="nav-item" style="cursor: pointer;" >
                  <a class="nav-link" data-bs-toggle="tab" data-bs-target="#editUpload" role="tab" aria-controls="editUpload" aria-selected="false" id="edit-upload-tab">Új feltöltése</a>    
                </li>
                <li class="nav-item " style="cursor: pointer;">
                  <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#editSelect" role="tab" aria-controls="editSelect" aria-selected="true" id="edit-select-tab">Már meglévő kiválasztás</a>    
                </li>
              </ul>

              <div class="tab-content" id="tabEditContent">
                  <div class="tab-pane fade" id="editUpload" role="tabpanel" aria-labelledby="edit-upload-tab">
                    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                  </div>
                  <div class="tab-pane fade show active" id="editSelect" role="tabpanel" aria-labelledby="edit-select-tab">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="Select-Image">Kép:</label>
                    </div>
                    <input type="text" class="form-control" name="fileToSelect" value="<?php echo $edits[3];?>" id="fileToEdit" readonly />
                    <div class="overflow-auto pt-1 mt-1" style="max-height:150px;" >
                    <?php
                       $dirname = "sec_images/";
                       $images = glob($dirname."*.jpg");
                      foreach($images as $image) {
                        $id = str_replace("sec_images/", "", $image);
                        echo '<img class="image-md ms-1 mt-1" id="'.$id.'" style="cursor: pointer;"  loading="lazy" alt="'.$image.'" src="'.$image.'"/>';
                        }
                       $images = glob($dirname."*.png");
                      foreach($images as $image) {
                        $id = str_replace("sec_images/", "", $image);
                        echo '<img class="image-md ms-1 mt-1" id="'.$id.'" style="cursor: pointer;"  loading="lazy" alt="'.$image.'" src="'.$image.'"/>';
                        }
                       $images = glob($dirname."*.jpeg");
                      foreach($images as $image) {
                        $id = str_replace("sec_images/", "", $image);
                        echo '<img class="image-md ms-1 mt-1" id="'.$id.'" style="cursor: pointer;"  loading="lazy" alt="'.$image.'" src="'.$image.'"/>';
                        }
                      ?>
                    </div>
                    
                  </div>
                  </div>
              </div>

            </div>
            <div class="col-12">
                <label for="inputprice" class="form-label">Ár</label>
                 <input type="text" class="form-control" name="price" value="<?php echo $edits[4];?>" id="inputprice">
              </div>
            <div class="col-12">
                <label for="inputdesc" class="form-label">Leírás</label>
                <input type="text" class="form-control" name="desc" value="<?php echo $edits[5];?>" id="inputdesc">
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" value="Termék felvétele" class="btn btn-primary" name="product_edit_confirm"></button>
              <input type="hidden" name="id" value="<?php echo $edits[1];?>" />
          </div>
            </div>

        </form>
        
        </div>
      </div>
    </div>
<?php
	}

	unset($edits);
	unset($_SESSION['edit']);

?>
