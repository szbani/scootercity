<nav class="navbar sticky-top navbar-expand-lg bg-light shadow-sm" id="navbar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ms-3" id="navbarSupportedContent">
      <a class="navbar-brand" href="/">
        <img src="/media/main/logo.jpg" alt="Logo" class="d-inline-block align-text-top logo">
      </a>
      <ul class="navbar-nav mt-3 me-5 mb-lg-0 fs-5 w-100">
        <li class="nav-item">
          <a class="nav-link <?php if($url[2] == 'felszreles')echo 'active';?>" aria-current="page" href="/bolt/felszreles">Motoros Felszerelés</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($url[2] == 'alkatreszek')echo 'active';?>" href="/bolt/alkatreszek">Alkatrészek</a>
        </li>
        <li class="w-50">
          <form class="navbar-form" role="search">
            <div class="input-group">
              <input class="form-control" id="search" type="search" placeholder="Keresés" aria-label="Search" autocomplete="off">
              <button type="submit" id="submit" class="input-group-text btn-success px-4"><i class="fa fa-search"></i></button>
            </div>
          </form>
          <ul class="dropdown-menu w-25" id="list"></ul>
        </li>
      </ul>

  </div>
</nav>