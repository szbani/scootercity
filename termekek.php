<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Weblap_cím</title>
    <meta name="description" content="ide kell a leírás">
    <meta name="author" content="Szabó Dániel">
    <meta name="keywords" content="kulcs szavak">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- CSS -->    
    <link rel="stylesheet" href="css/index.css">
    
    <script src="/scootercity/js/jquery.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v11.0" nonce="vGo94UMf"></script>

    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css">
    <link rel="stylesheet" href="css/termekek.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/css/swiper.min.css'>
    <link rel="stylesheet" href="css/gallery.css">
    </head>
<body>
<?php
include_once "parts/navbar.html";

include_once "parts/termek_sidebar.php";
include_once "parts/termek_main.php";

?>
</main>
</div>
<footer class="pb-3 pt-4">
  <div class="container text-light" >
    <div class="row">
      
      <div class="col-4 col-md">
        <h5>Features</h5>
        <ul class="list-unstyled text-small">
          <li><a class="link-secondary" href="#">Cool stuff</a></li>
          <li><a class="link-secondary" href="#">Random feature</a></li>
          <li><a class="link-secondary" href="#">Team feature</a></li>
          <li><a class="link-secondary" href="#">Stuff for developers</a></li>
          <li><a class="link-secondary" href="#">Another one</a></li>
          <li><a class="link-secondary" href="#">Last time</a></li>
        </ul>
      </div>
      <div class="col-4 col-md">
        <h5>Elérhetőségek</h5>
        <ul class="list-unstyled text-small">
          <li><a class="link-secondary" href="#">H-7681 Hetvehely,<br> Rékóczi út 13/a</a></li>
          <li><a class="link-secondary" href="#">Tel.: +36-30-273-9402</a></li>
          <li><a class="link-secondary" href="#">E-mail: info@scootercity.hu</a></li>
        </ul>
      </div>
      
      <div class="col-8 col-md">
        <div class="fb-page" 
              data-href="https://www.facebook.com/scootercitymotorosbolt"
              data-width="380" 
              data-hide-cover="false"
              data-show-facepile="false">
        </div>
      </div>
      <div class="col-6 col-md">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d859.5909225318234!2d18.04283583416093!3d46.12898778151173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4742a85591a899a7%3A0x684daaae2d9a566c!2zSGV0dmVoZWx5LCBSw6Frw7NjemkgdS4gMTMsIDc2ODE!5e1!3m2!1sen!2shu!4v1628021277627!5m2!1sen!2shu" width="auto" height="130" style="border: 1px solid white;" allowfullscreen="" loading="lazy"></iframe>

      </div>
    </div>

  </footer>
<script src="js/termek.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/js/swiper.min.js'></script>
<script  src="js/gallery.js"></script>
<script  src="js/colorpicker.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/index.js"></script>
</body>
</html>