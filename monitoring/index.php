<?php
session_start();
require_once('../DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<!-- <html lang="es-Es"> -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucwords(str_replace('_',' ',$page)) ?> | Monitoreo En vivo</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="./../assets/img/escudo.png" rel="icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <!-- <link href="./../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="./../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="./../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="./../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="./../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="./../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="./../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="./../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./../css/bootstrap.css">

    <script src="./../js/jquery-3.6.0.min.js"></script>
    <script src="./../js/popper.min.js"></script>
    <script src="./../js/bootstrap.min.js"></script>
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

    <link rel="stylesheet" href="./../DataTables/datatables.min.css">
    <script src="./../DataTables/datatables.min.js"></script>
    <script src="./../Font-Awesome-master/js/all.min.js"></script>
    <script src="./../select2/js/select2.min.js"></script>
    <script src="./../js/script.js"></script>

    <!-- <link rel="stylesheet" href="./../Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="./../css/bootstrap.min.css">
    <link rel="stylesheet" href="./../select2/css/select2.min.css"> -->

    <!-- <script src="./../js/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="./../js/popper.min.js"></script>
    <script src="./../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./../DataTables/datatables.min.css">
    <script src="./../DataTables/datatables.min.js"></script>
    <script src="./../Font-Awesome-master/js/all.min.js"></script>
    <script src="./../select2/js/select2.min.js"></script> -->
    <!-- <script src="./../js/script.js"></script> -->

    <style>
        :root{
            --bs-success-rgb:71, 222, 152 !important;
        }
        html,body{
            height:100%;
            width:100%;
        }
        main{
            height:100%;
            display:flex;
            flex-flow:column;
        }
        #page-container{
            flex: 1 1 auto; 
            overflow:auto;
        }
        #topNavBar{
            flex: 0 1 auto; 
        }
        .thumbnail-img{
            width:50px;
            height:50px;
            margin:2px
        }
        .truncate-1 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        .truncate-3 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .modal-dialog.large {
            width: 80% !important;
            max-width: unset;
        }
        .modal-dialog.mid-large {
            width: 50% !important;
            max-width: unset;
        }
        @media (max-width:720px){
            
            .modal-dialog.large {
                width: 100% !important;
                max-width: unset;
            }
            .modal-dialog.mid-large {
                width: 100% !important;
                max-width: unset;
            }  
        
        }
        .display-select-image{
            width:60px;
            height:60px;
            margin:2px
        }
        img.display-image {
            width: 100%;
            height: 45vh;
            object-fit: cover;
            background: black;
        }
        /* width */
        ::-webkit-scrollbar {
        width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
        background: #f1f1f1; 
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: #888; 
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: #555; 
        }
        .img-del-btn{
            right: 2px;
            top: -3px;
        }
        .img-del-btn>.btn{
            font-size: 10px;
            padding: 0px 2px !important;
        }
    </style>
</head>


<body>
    <nav class="nav navbar navbar-light bg-primary bg-gradient py-2 text-light fs-4 fw-bold">
        <marquee behavior="" direction="">
            <span class="mx-5">Bienvenidos a Atención al Publico - Favor estar pendiente a su llamado, Muchas gracias <i class="em em-grin" aria-role="presentation" aria-label="GRINNING FACE WITH SMILING EYES"></i></span>
        </marquee>
    </nav>

    <main>
        <div class="container-fluid py-3" id="page-container">
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
            <?php
            include $page.'.php';
        ?>
        </div>
    </main>

    <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
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
    </div>

    <div class="modal fade" id="uni_modal_secondary" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit'
                        onclick="$('#uni_modal_secondary form').submit()">Save</button>
                    <button type="button" class="btn btn-sm rounded-0 btn-secondary"
                        data-bs-dismiss="modal">Close</button>
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
    </div>

</body>

</html>