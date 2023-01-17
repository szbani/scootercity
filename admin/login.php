<?php
session_start();
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

<body class="img js-fullheight" style="background-image: url(assets/img/bg.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Scootercity - Admin</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Bejelentkezés</h3>
                        <form method="POST" action="query/login.php" class="signin-form">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" name="pw" type="password" class="form-control" placeholder="Password" required>
                                <span toggle="#password-field" id="togglePw" onclick="showPw(this)" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="loginPage" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    include_once 'query/floatingAlert.php';
    ?>
    <script>
        function showToast(id) {
            var toastLiveExample = document.getElementById(id)
            var toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        }
    </script>
    <script src="../js/jquery.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/login.js"></script>
</body>

</html>