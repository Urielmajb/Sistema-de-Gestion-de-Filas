<?php
session_start();
require_once('DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title><?php /*echo ucwords(str_replace('_',' ',$page)) */?> | Cashier Queuing System</title> -->
    <title>Registro de Numeros</title>

    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="./assets/img/escudo.png" rel="icon">

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

    <link rel="stylesheet" href="./css/bootstrap.css">
    <link href="./assets/css/style.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="./Font-Awesome-master/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="./select2/css/select2.min.css"> -->

    <script src="./js/jquery-3.6.0.min.js"></script>
    <!-- <script src="./js/popper.min.js"></script> -->
    <script src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./DataTables/datatables.min.css">
    <script src="./DataTables/datatables.min.js"></script>
    <script src="./Font-Awesome-master/js/all.min.js"></script>
    <script src="./select2/js/select2.min.js"></script>
    <script src="./js/script.js"></script>


    <style>
    :root {
        --bs-success-rgb: 71, 222, 152 !important;
    }

    html,
    body {
        height: 100%;
        width: 100%;
    }

    .form-control.border-0 {
        transition: border .2s cubic-bezier(0.4, 0, 1, 1);
    }

    .form-control.border-0:focus {
        box-shadow: unset !important;
        border-color: var(--bs-info) !important;
    }
    </style>

</head>

<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient" id="topNavBar">
            <div class="container">
                <a class="navbar-brand" href="./">
                    <i class="bi bi-person-fill"></i>
                    <b> Registro de Numeros de Filas </b>

                </a>
            </div>
        </nav>
        <section class="section">

            <div class="container py-3" id="page-container">
                <?php 
            if(isset($_SESSION['flashdata'])):
        ?>
                <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?>">
                    <div class="float-end"><a href="javascript:void(0)" class="text-dark text-decoration-none"
                            onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a></div>
                    <?php echo $_SESSION['flashdata']['msg'] ?>
                </div>
                <?php unset($_SESSION['flashdata']) ?>
                <?php endif; ?>

                <div class="container-fluid py-5">

                    <div class="row justify-content-center">
                        <div class="col-md-7">

                            <!-- Card with titles, buttons -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><b>Obtener número</b></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                                    <form action="" id="queue-form">
                                        <div class="form-group">
                                            <label for="customer_name" class="control-label text-info">
                                                <b>Ingrese el nombre </b>
                                            </label>
                                            <input type="text" id="customer_name" name="customer_name" autofocus
                                                autocomplete="off"
                                                class="form-control form-control-lg rounded-0 border-0 border-bottom"
                                                required>
                                            <br></br>
                                            <label for="no_tram" class="control-label text-info">
                                                <b>Numero de tramite a realizar </b>
                                            </label>
                                            <input type="text" id="no_tram" name="no_tram" autofocus autocomplete="off"
                                                class="form-control form-control-lg rounded-0 border-0 border-bottom"
                                                required>
                                        </div>
                                        <br></br>

                                        <div class="form-group text-center my-2">
                                            <button class="btn btn-warning" type='submit'>
                                                <b>Conseguir Número</b></button>
                                        </div>
                                    </form>
                                </div>
                            </div>



                            <!-- <div class="card rouded-0 shadow">
                            <div class="card-header rounded-0">
                                <div class="h5 card-title">Obtener el numero</div>
                            </div>
                            <div class="card-body rounded-0">
                                <form action="" id="queue-form">
                                    <div class="form-group">
                                        <label for="customer_name" class="control-label text-info">Enter your
                                            Name</label>
                                        <input type="text" id="customer_name" name="customer_name" autofocus
                                            autocomplete="off"
                                            class="form-control form-control-lg rounded-0 border-0 border-bottom"
                                            required>
                                    </div>
                                    <div class="form-group text-center my-2">
                                        <button class="btn-primary btn-lg btn col-sm-4 rounded-0" type='submit'>Get
                                            Queue</button>
                                    </div>
                                </form>
                            </div>
                        </div> -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <div class="card">

        <!-- Vertically centered Modal -->
        <div class="modal fade" id="uni_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Vertically Centered</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-footer py-1">
                            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit'
                                onclick="$('#uni_modal form').submit()">Save</button>
                            <button type="button" class="btn btn-sm rounded-0 btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- End Vertically centered Modal-->

    </div>
    </div>

    <!-- <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit'
                        onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-sm rounded-0 btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="modal fade" id="uni_modal_secondary" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-sm rounded-0 btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit'
                        onclick="$('#uni_modal_secondary form').submit()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-primary btn-sm rounded-0" id='confirm'
                        onclick="">Continue</button>
                    <button type="button" class="btn btn-secondary btn-sm rounded-0"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->
</body>

<script>
$(function() {
    $('#queue-form').submit(function(e) {
        e.preventDefault()
        var _this = $(this)
        _this.find('.pop-msg').remove()
        var el = $('<div>')
        el.addClass('alert pop-msg')
        el.hide()
        _this.find('button[type="submit"]').attr('disabled', true)
        $.ajax({
            url: './Actions.php?a=save_queue',
            method: 'POST',
            data: _this.serialize(),
            dataType: 'JSON',
            error: err => {
                console.log(err)
                el.addClass("alert-danger")
                el.text("An error occured while saving data.")
                _this.find('button[type="submit"]').attr('disabled', false)
                _this.prepend(el)
                el.show('slow')
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    // uni_modal("Your Queue", "get_queue.php?success=true&id=" + resp.id)

                    uni_modal("Tu numero", "get_queue.php?success=true&id=" + resp.id)
                    $('#uni_modal').on('hide.bs.modal', function(e) {
                        location.reload()
                    })
                } else if (resp.status = 'failed' && !!resp.msg) {
                    el.addClass('alert-' + resp.status)
                    el.text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                } else {
                    el.addClass('alert-' + resp.status)
                    el.text("An Error occured.")
                    _this.prepend(el)
                    el.show('slow')
                }
                _this.find('button[type="submit"]').attr('disabled', false)
            }
        })
    })
})
</script>

</html>