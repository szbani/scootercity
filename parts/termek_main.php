<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 140px;">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
      <?php $i = 0;
      while ($i < 20){
        echo('        <div class="col">
        <div class="card" data-bs-toggle="modal" data-bs-target="#termek_modal" id="termek'.$i.'" onclick="modal_show(this)">
            <img src="/scootercity/media/products/product1.jpg" class="card-img-top" alt="Termék">
            <div class="card-body">
              <h5 class="card-title" id="Param_Nev">AGV K6 Hyphen bukósisak Fehér/Piros/Kék</h5>
            </div>
            <ul class="list-group list-group-flush d-flex">
                <li class="list-group-item d-flex justify-content-between">
                    <h5 class="m-0" id="Param_Ar">184 900 Ft</h5>
                    <h5 class="m-0">
                      <img src="/scootercity/media/products/termek_ok.png" id="Param_Raktar" class="status" alt="">
                    </h5>
                </li>
                <li class="d-none" id="Param_Leiras">
                  
                </li>
                <li class="d-none" id="Param_Felsorolas">
                  
                </li>
            </ul>
            <div class="card_click">
            </div>
        </div>
        </div>');
      $i++;
      }
      ?>

      
    </div>
    <!--row end-->
<div class="modal fade" id="termek_modal" aria-hidden="true" aria-labelledby="termek_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title" id="Termek_Neve">test</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="product-gallery">
          <div class="product-photo-main">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="swiper-zoom-container">
                    <img src="/scootercity/media/products/product1.jpg">
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="swiper-zoom-container">
                    <img src="/scootercity/media/products/product1_1.jpg">
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
          <div class="product-photos-side">
            <div class="swiper-container mb-2">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="swiper-zoom-container">
                    <img src="/scootercity/media/products/product1.jpg">
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="swiper-zoom-container">
                    <img src="/scootercity/media/products/product1_1.jpg">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <div class="modal-body border-top py-1 pe-4">
        
        <h5>Termék leírása:</h5>
        <h6>CAAF karbon-aramid héjszerkezet,
          5 db különböző sűrűségű ütéselnyelő EPS réteggel,
          exkluzív AGV Ultravision 5 fokozatban nyitható plexi,
          100% Max Vision Pinlock páramentes plexi,
          fém plexi mechanika.
          </h6>
      </div>
      <div class="modal-body pe-5">
        <div class="row row-cols-2 ">
          <div class="col col-9">Súlya:</div>
          <div class="col col-3 float-end text-end">1220 g</div>
          <div class="col col-9">különböző méretek:</div>
          <div class="col col-3 float-end text-end">4</div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <h5 id="Termek_Ara">Ár: *******</h5>
        <h5>Raktáron:<img src="/scootercity/media/products/termek_ok.png" id="Termek_Raktar" class="status float-end" alt=""></h5>
          
      </div>
    </div>
  </div>


  <div class="product-gallery-full-screen">
    <div class="swiper-container gallery-top">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="swiper-zoom-container">
            <img src="/scootercity/media/products/product1.jpg" draggable="false" ondragstart="return false;">
          </div>
        </div>
        <div class="swiper-slide">
          <div class="swiper-zoom-container">
            <img src="/scootercity/media/products/product1_1.jpg" draggable="false" ondragstart="return false;">
          </div>
        </div>
      </div>
      <div class="swiper-button-next swiper-button-white">
        <svg fill="#FFFFFF" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
        </svg>
      </div>
      <div class="swiper-button-prev swiper-button-white">
        <svg fill="#FFFFFF" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
      </div>
      <div class="gallery-nav">
        <div class="swiper-pagination"></div>
        <ul class="gallery-menu">
          <li class="zoom">
            <svg class="zoom-icon-zoom-in" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
              <path d="M0 0h24v24H0V0z" fill="none"/>
              <path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/>
            </svg>
            <svg class="zoom-icon-zoom-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0V0z" fill="none"/>
              <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zM7 9h5v1H7z"/>
            </svg>
          </li>
          <li class="fullscreen">
            <svg class="fs-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0z" fill="none"/>
              <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
            </svg>
            <svg class="fs-icon-exit" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0z" fill="none"/>
              <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/>
            </svg>
          </li>
          <li class="close">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
              <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
          </li>
        </ul>
      </div>
    </div>
  </div>


</div>
