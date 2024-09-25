<?php
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
    header("Location:./");
    exit;
}
require_once('./DBConnection.php');
//require_once('DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion - Sistema de Monitoreo de Filas</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="./assets/img/logonuevo.ico" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="./assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="./assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="./assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="./assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="./assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="./assets/css/style.css" rel="stylesheet">

    <script src="./js/jquery-3.6.0.min.js"></script>

    <!-- <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script> -->
    <!-- <style>
        html, body{
            height:100%;
        }
    </style> -->
</head>

<body>
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <img src="./assets/img/LOREM.png" alt="">
                                <!-- <span class="d-none d-lg-block">NiceAdmin</span> -->
                            </div>
                            <!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h3 class="card-title text-center pb-0 fs-4">
                                            <b>SISTEMA DE MONITOREO</b>
                                        </h3>
                                        <p class="text-center">
                                            <b>Ingresar al Sistema</b>
                                        </p>
                                    </div>

                                    <form class="row g-3 needs-validation" id="login-form">

                                        <div class="col-12">
                                            <label for="username" class="form-label">
                                                <b>
                                                    USUARIO:
                                                </b>
                                            </label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">
                                                    <i class="bi bi-person-fill"></i>
                                                </span>
                                                <input type="text" class="form-control" id="username" autofocus
                                                    name="username" required>
                                                <div class="invalid-feedback">Favor ingrese su usuario</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">
                                                <b>
                                                    CONTRASEÑA:
                                                </b>
                                            </label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">
                                                    <i class="bi bi-lock-fill"></i>
                                                </span>
                                                <input type="password" class="form-control" name="password"
                                                    id="password" required>
                                                <div class="invalid-feedback">Favor ingrese contraseña</div>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group d-flex w-100 justify-content-between align-items-center">
                                            <span>
                                                <a href="./queue_registration.php" class="me-1">Home</a>
                                                |
                                                <a href="./cashier" class="ms-1">Cashier</a>
                                            </span>
                                        </div> -->

                                        <div class="col-12">
                                            <nav aria-label="breadcrumb">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item">
                                                        <a href="./queue_registration.php"><b>HOME</b></a>
                                                    </li>
                                                    <li class="breadcrumb-item active" aria-current="page">
                                                        <a href="./cashier"><b>CASHIER?</b></a>
                                                    </li>
                                                </ol>
                                            </nav>
                                        </div>


                                        <div class="col-12">
                                            <button class="btn btn-warning w-100" type="submit">
                                                <b>ACCEDER AL SISTEMA</b>
                                            </button>
                                        </div>
                                        <div class="col-12">
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>


        </div>

    </main>
    <!-- End #main -->

    <footer class="footer">
        <div class="container">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 USJBDEV -
                    DERECHOS RESERVADOS</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                    <a href="#">INICIO</a>
                    <i class="bi bi-house-door-fill"></i>
                </span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                    <a target="_blank" href="#">NUBE</a>
                    <i class="bi bi-cloud-fill"></i>
                </span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                    <a target="_blank" href="#">CORREO</a>
                    <i class="bi bi-inbox-fill"></i>
                </span>
            </div>
        </div>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <script src="./assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/vendor/chart.js/chart.umd.js"></script>
    <script src="./assets/vendor/echarts/echarts.min.js"></script>
    <script src="./assets/vendor/quill/quill.min.js"></script>
    <script src="./assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="./assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="./assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="./assets/js/main.js"></script>
    <!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | Cashier Queuing System</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
    <style>
        html, body{
            height:100%;
        }
    </style>
</head>
<body class="bg-dark bg-gradient">
   <div class="h-100 d-flex jsutify-content-center align-items-center">
       <div class='w-100'>
        <h3 class="py-5 text-center text-light">Cashier Queuing System</h3>
        <div class="card my-3 col-md-4 offset-md-4">
            <div class="card-body">
                <form action="" id="login-form">
                    <center><small>Please enter your credentials.</small></center>
                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" id="username" autofocus name="username" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group d-flex w-100 justify-content-between align-items-center">
                        <span>
                        <a href="./queue_registration.php" class="me-1">Home</a>
                        |
                        <a href="./cashier" class="ms-1">Cashier</a>
                        </span>
                        <button class="btn btn-sm btn-primary rounded-0 my-1">Login</button>
                    </div>
                </form>
            </div>
        </div>
       </div>
   </div>
</body> -->
</body>
<script>
$(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();
        $('.pop_msg').remove()
        var _this = $(this)
        var _el = $('<div>')
        _el.addClass('pop_msg')
        _this.find('button').attr('disabled', true)
        _this.find('button[type="submit"]').text('Logging in...')
        $.ajax({
            url: './Actions.php?a=login',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            error: err => {
                console.log(err)
                _el.addClass('alert alert-danger')
                _el.text("An error occurred.")
                _this.prepend(_el)
                _el.show('slow')
                _this.find('button').attr('disabled', false)
                _this.find('button[type="submit"]').text('Error...')

                // _this.find('button[type="submit"]').text('Save')
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    _el.addClass('alert alert-success')
                    setTimeout(() => {
                        location.replace('./');
                    }, 2000);
                } else {
                    _el.addClass('alert alert-danger')
                }
                _el.text(resp.msg)

                _el.hide()
                _this.prepend(_el)
                _el.show('slow')
                _this.find('button').attr('disabled', false)
                // _this.find('button[type="submit"]').text('Save')
                _this.find('button[type="submit"]').text('Accediendo...')


            }
        })
    })
})
</script>

</html>