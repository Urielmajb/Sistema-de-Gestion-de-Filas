

<div class="container">
    <div class="row">
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center" id="serving-field">

            <div class="card col-sm-8 shadow">
                <div class="card-header">
                    <h5 class="card-title text-center">
                        <b>Ahora atendiendo</b></h5>
                </div>
                <div class="card-body">
                    <div class="fs-1  my-2 fw-bold text-center"><span id="queue">----</span></div>
                </div>
                <!-- <div class="card-footer">

                </div> -->
            </div>
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center" id="action-field">
            <div class="w-100 row row-cols-sm-1 row-cols-md-2 row-cols-xl-3">
                <div class="col">
                    <button id="next_queue" class="btn btn-flat btn-info rounded-0 btn-lg"><i
                            class="fa fa-forward"></i><b>Siguiente</b></button>
                </div>
                <div class="col">
                    <button id="notify" class="btn btn-flat btn-warning rounded-0 btn-lg"><i
                            class="fa fa-bullhorn"></i> <b>Notificar</b></button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
var websocket = new WebSocket("ws://<?php echo $_SERVER['SERVER_NAME'] ?>:8080/php-sockets.php");
//var websocket = new WebSocket("ws://<?php echo $_SERVER['SERVER_NAME'] ?>:2306/queuing/php-sockets.php"); 
websocket.onopen = function(event) {
    console.log('socket is open!')
}
websocket.onclose = function(event) {
    console.log('socket has been closed!')
    var websocket = new WebSocket("ws://<?php echo $_SERVER['SERVER_NAME'] ?>:8080/php-sockets.php");
    // var websocket = new WebSocket("ws://<?php echo $_SERVER['SERVER_NAME'] ?>:2306/queuing/php-sockets.php");
};
var in_queue = {};

function _resize_elements() {
    var window_height = $(window).height()
    var nav_height = $('#topNavBar').height()
    var container_height = window_height - nav_height
    $('#serving-field,#action-field').height(container_height - 50)
}

function get_queue() {
    $.ajax({
        url: './../Actions.php?a=next_queue',
        dataType: 'json',
        error: err => console.log(err),
        success: function(resp) {
            if (resp.status) {
                if (Object.keys(resp.data).length > 0) {
                    in_queue = resp.data
                } else {
                    in_queue = {}
                    // alert("No Queue Available")
                    alert("No hay numeros en cola disponibles")

                }
            } else {
                alert('An error occured')
            }
            queue();
        }
    })

}

function queue() {
    $('#queue').text(in_queue.queue || "----")
    websocket.send(JSON.stringify({
        type: 'queue',
        cashier_id: '<?php echo $_SESSION['cashier_id'] ?>',
        qid: in_queue.queue_id
    }))
}
_resize_elements();
$(function() {
    $(window).resize(function() {
        _resize_elements()
    })
    $('#next_queue').click(function() {
        get_queue()
    })
    $('#notify').click(function() {
        if (!!in_queue.queue) {
            queue()
        } else {
            // alert("No Queue Available")
            alert("No hay numeros en cola disponibles")

        }
    })
})
</script>