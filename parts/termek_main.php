<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5 pt-5">
    <div class="row row-cols-2 row-cols-md-5">
    <?php
    $i = 0;
     while ($i < 50){
         echo('<div class="col">
         <div class="card " data-bs-toggle="modal" data-bs-target="#termek_modal" onclick="" style="width: 16rem;">
             <img src="/scootercity/pics/placeholder7.jpg" class="card-img-top" alt="Termék">
             <div class="card-body">
             <h5 class="card-title">termék neve</h5>
             <p class="card-text">Ár: *******</p>
             </div>
             <ul class="list-group list-group-flush d-flex">
                 <li class="list-group-item">
                     Raktáron:
                     <img src="/scootercity/pics/raktar_ok.png" class="status float-end" alt="">
                 </li>
                 <li class="list-group-item d-none">
                     Raktáron:
                     <img src="/scootercity/pics/raktar_ok.png" class="status float-end" alt="">
                 </li>
             </ul>
             <div class="card_click">
             </div>
         </div>
     </div>');
        
        $i++;}?>
    
    </div>
    <!--row end-->
<div class="modal fade" id="termek_modal" aria-hidden="true" aria-labelledby="termek_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content " >
      <div class="modal-header py-2">
        <h5 class="modal-title" id="TermekNeve">Termék neve</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <img src="/scootercity/pics/placeholder7.jpg" class="modal-img w-100">
        <div class="image-blur"></div>
      </div>
      <div class="modal-body">
        
        <ul class="list-group list-group-flush d-flex">
            <li class="list-group-item">
                Raktáron:
                <img src="/scootercity/pics/raktar_ok.png" class="status float-end" alt="">
            </li>
        </ul>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
