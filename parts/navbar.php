<?php
if (!defined('ACCESS_ALLOWED')) exit();
?>

<nav class="information py-1">
    <div class="container pb-1">
        <div class="row pt-2">
            <div class="col-12">
                <a class="nav-link2" href="#">
                    <span class="d-none d-md-inline-block "><i
                                class="fa-solid fa-envelope"></i> scootercityshop@gmail.com</span>
                </a>
                <span class="mx-md-2 d-inline-block"></span>
                <a class="nav-link2" href="#">
                    <span class="d-none d-md-inline-block"><i class="fa-solid fa-phone"></i> +36-70/650-8555</span>
                </a>
                <span class="mx-md-2 d-inline-block"></span>
                <a class="nav-link2" href="#">
                    <span class="d-none d-md-inline-block"><i class="fa-solid fa-location-dot"></i> H-7681 Hetvehely, Rákóczi út 13/a</span>
                </a>
                <div class="float-end ">
                    <a class="nav-link2" href="https://www.facebook.com/scootercitymotorosbolt/">
                        <span class="d-none d-lg-inline-block"><i class="fa-brands fa-facebook"></i> Facebook</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>


<nav class="navbar navbar-dark sticky-top navbar-expand-lg bg-nav">


    <?php
    $uri = $_SERVER['REQUEST_URI'];
    if (str_contains($uri,'bolt') && !str_contains($uri,'termek')) {
        echo '<button class="navbar-toggler ms-md-5 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
            aria-controls="sidebar">
        <span class="navbar-toggler-icon"></span>
    </button>
    ';
    }
    ?>
    <a class="navbar-brand ms-md-5 ms-2" href="/">
        <img src="/media/main/logo.jpg" alt="Logo" class="d-inline-block align-text-top logo">
    </a>
    <button class="navbar-toggler me-md-5 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-three-dots"
             viewBox="0 0 16 16">
            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
        </svg>
    </button>
    <div class="collapse navbar-collapse m-3 m-lg-0 ms-lg-3 " id="navbar">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-lg-2 w-100 gy-3">
            <div class="col col-lg-5 ms-xl-5 ms-xxl-3">
                <form class=" navbar-form lista h-100" role="search" autocomplete="off">
                    <div class="input-group search-field h-100">
                        <input class="form-control" id="search" type="search" placeholder="Keresés"
                               aria-label="Search">
                        <button type="submit" id="submit" class="input-group-text btn-success px-4">
                            <i class="fa fa-search"></i></button>
                    </div>
                    <ul class="dropdown-menu" id="list"></ul>
                </form>
            </div>
            <div class="col col-lg-7 col-xl-6 col-xxl-5 ">
                <ul class="navbar-nav m-0 mb-lg-0 fs-5 justify-content-end ">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/bolt">Termékek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/bolt/legujabb">Legújabbak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bolt?discount=true">Kedvezmények</a>
                    </li>
                </ul>

            </div>
        </div>

    </div>
</nav>