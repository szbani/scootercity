<?php
session_start();
require_once('query/conn.php');
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - Scootercity</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/login.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content" class="text-center mt-5">
            <main class="form-signin">
                <form method="POST" action="query/login.php">
                    <h1 class="h3 mb-3 fw-normal">Bejelentkezés</h1>

                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput">Email cím</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="pw" class="form-control" id="floatingPassword" placeholder="Jelszó" required>
                        <label for="floatingPassword">Jelszó</label>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit" name="loginPage">Bejelentkezés</button>
                    <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p> -->
                </form>
            </main>
        </div>
        <?php
        include_once 'query/errorsF.php';
        ?>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 mt-auto bg-light">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        function showToast(id) {
            var toastLiveExample = document.getElementById(id)
            var toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>