<?php
require_once('./DBConnection.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `queue_list` where queue_id = '{$_GET['id']}'");
    @$res = $qry->fetchArray();
    if($res){
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }
}
?>

<style>
#uni_modal .modal-footer {
    display: none;
}
</style>


<div class="container fluid">
    <?php if(isset($_GET['success']) && $_GET['success'] == true): ?>
    <!-- <div class="alert alert-success">Su número de cola se generó con éxito</div> -->
    <div class="alert alert-success alert-dismissible fade show">Su número de cola se generó con éxito</div>
    <?php endif; ?>
    <div id="outprint">
        <div class="row justify-content-end">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <center><b><p>Atencion al publico</p></b></center>
                        <div class="fs-1 fw-bold text-center">
                            <?php echo $queue ?>
                        </div>
                        <center><b><?php echo $customer_name ?></b></center>
                        <center><b>No. trámites: <?php echo $no_tram ?></b></center>
                    </div>

                    <div id="datetimefield" class="w-100  col-auto">
                    <div class="text-center time fw-bold"></div>
                    <div class="text-center date fw-bold"></div>
                </div>
                </div>
            </div>
            <!-- <div class="card border-0 border-left border-start rounded-0 border-5 border-info">
                    <div class="fs-1 fw-bold text-center">
                        <?php /*echo $queue */?>
                    </div>
                    <center><?php /*echo $customer_name */?></center>
                </div> -->
        </div>
    </div>
</div>

<div class="row my-2 mx-0 justify-content-end align-items-center">
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" id="print" class="btn btn-success col-sm-4">
            <i class="bi bi-printer"></i>&nbsp; Imprimir</button>&nbsp;&nbsp;
        <button type="button" data-bs-dismiss="modal" class="btn btn-danger col-sm-4">
            <i class="bi bi-x-circle"></i>&nbsp;
            Cerrar</button>
    </div>
</div>

<!-- <div class="row my-2 mx-0 justify-content-end align-items-center">
        <button class="btn btn-success rounded-0 me-2 col-sm-4" id="print" type="button">
            <i class="fa fa-print"></i> Imprimir
        </button>
        <button class="btn btn-dark rounded-0 col-sm-4" data-bs-dismiss="modal" type="button">
            <i class="fa fa-times"></i>
            Cerrar
        </button>
    </div> -->
</div>


<script>
$(function(){
        setInterval(() => {
            time_loop()
        }); 
    })

    function time_loop(){
        var hour,min,ampm,mo,d,yr,s;
        var datetime = new Date();
        let mos = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre']
        const weekday = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
        let dia = weekday[datetime.getDay()];
        hour = datetime.getHours()
        min = datetime.getMinutes()
        s = datetime.getSeconds()
        ampm = hour >= 12 ? "PM" : "AM";
        mo = mos[datetime.getMonth()]
        //mo = datetime.getMonth() + 1
        //d = datetime.getDay()
        d = datetime.getDate()
        yr = datetime.getFullYear()
        hour = hour >= 12 ? hour - 12 : hour;
        hour = String(hour).padStart(2,0)
        min = String(min).padStart(2,0)
        s = String(s).padStart(2,0)
        $('.time').text(hour+":"+min+":"+s+" "+ampm)
        // $('.date').text(mo+" "+d+", "+yr)
        $('.date').text(dia + ", " + d + " de " + mo + " de " + yr)
    }

    $(function()
    {
        $('#print').click(function(){
            var _el = $('<div>')
            var _h = $('head').clone()
            var _p = $('#outprint').clone()
            _h.find('title').text("Atención al público")
            _el.append(_h)
            _el.append(_p)
                var nw = window.open('','_blank','width=700,height=500,top=75,left=200')
                nw.document.write(_el.html())
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        $('#uni_modal').modal('hide') 
                    }, 200);
                }, 500);
        })
    })


</script>