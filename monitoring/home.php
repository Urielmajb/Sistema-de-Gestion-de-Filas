<div class="container-fluid">
    <center><button class="btn btn-lg btn-warning w-25" id="start" type="button"><i class="bi bi-play-fill"></i><b>&nbsp; Iniciar Monitoreo En vivo<b></button></center>
    
    <div class="d-none" id="monitor-holder">
        <div class="row my-0 mx-0">
            <div class="col-md-5 d-flex flex-column justify-content-center align-items-center" id="serving-field">

            
                <div class="col-sm-12 shadow h-100">
                    <div class="card card-title">
                        <h5 class="card-title text-center"><b>Ahora Atendiendo</b></h5>
                    </div>
                    
                    <div class="card-body h-100">
                        <div id="serving-list" class="list-group overflow-auto">
                            <?php 
                            $cashier = $conn->query("SELECT * FROM `cashier_list` order by `name` asc");
                            while($row = $cashier->fetchArray()):
                            ?>
                            <div class="card list-group-item" data-id="<?php echo $row['cashier_id'] ?>"
                                style="display:none">
                                <div class="fs-5 fw-2 cashier-name border-bottom border-info"><?php echo $row['name'] ?>
                                </div>
                                <div class="ps-4"><span class="serve-queue fs-4 fw-bold">1001 - John Smith</span></div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>

          
            <div class="card col-md-7 d-flex flex-column justify-content-center align-items-center text-light"
                id="action-field">
                <div class="col-auto flex-grow-1">
                    <?php 
                    $vid = scandir('../video');
                    $video = isset($vid[2]) ? $vid[2]: "";
                ?>
                    <video id="loop-vid" src="./../video/<?php echo $video ?>" loop class="w-100 h-100"></video>
                </div>

                <div class="card-title">
                <div id="datetimefield" class="w-100  col-auto">
                    <div class="fs-1 text-center time fw-bold"></div>
                    <div class="fs-5 text-center date fw-bold"></div>
                </div>
                </div>

                </div>
            
        </div>
    </div>
    
</div>


<script>
var websocket = new WebSocket("ws://<?php echo $_SERVER['SERVER_NAME'] ?>:8080/php-sockets.php");
websocket.onopen = function(event) {
    console.log('socket is open!')
}
websocket.onclose = function(event) {
    console.log('socket has been closed!')
    var websocket = new WebSocket("ws://<?php echo $_SERVER['SERVER_NAME'] ?>:8080/php-sockets.php");
};

// let tts = new SpeechSynthesisUtterance();
// tts.lang = "en"; 
// tts.voice = window.speechSynthesis.getVoices()[0] ; 

const tts = new SpeechSynthesisUtterance();
var voices = window.speechSynthesis.getVoices();
tts.lang = "es-MX";
//tts.voice = window.speechSynthesis.getVoices()[0] ;

//tts.voice = voices.filter(function(voice) { return voice.name == "Microsoft Jorge Online"; })[248];
tts.voice = window.speechSynthesis.getVoices().find(voice => voice.startsWith(lang))

let notif_audio = new Audio("../audio/ascend.mp3")
let vid_loop = $('#loop-vid')[0]

tts.onstart = () => {
    vid_loop.pause()
}

notif_audio.setAttribute('muted', true)
notif_audio.setAttribute('autoplay', true)
document.querySelector('body').appendChild(notif_audio)

function speak($text = "") {
    if ($text == '')
        return false;
    //tts.lang = "es-MX";
    //tts.voice = voices.filter(function(voice) { return voice.name == "Microsoft Jorge Online"; })[248];
    tts.text = $text;
    notif_audio.setAttribute('muted', false)
    notif_audio.play()

    setTimeout(() => {
        window.speechSynthesis.speak(tts);
        tts.onend = () => {
            vid_loop.play()
        }
    }, 500);
}


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

// function time_loop() {
//     var hour, min, ampm, mo, d, yr, s;
//     //let mos = ['','January','Febuary','March','April','May','June','July','August','September','October','November','December']
//     var datetime = new Date();
//     hour = datetime.getHours()
//     min = datetime.getMinutes()
//     s = datetime.getSeconds()
//     ampm = hour >= 12 ? "PM" : "AM";
//     //mo = mos[datetime.getMonth()]
//     mo = datetime.getMonth() + 1
//     d = datetime.getDate()
//     //d = datetime.getDay()
//     yr = datetime.getFullYear()
//     hour = hour >= 12 ? hour - 12 : hour;
//     hour = String(hour).padStart(2, 0)
//     min = String(min).padStart(2, 0)
//     s = String(s).padStart(2, 0)
//     $('.time').text(hour + ":" + min + ":" + s + " " + ampm)
//     $('.date').text(d + "/" + mo + "/" + yr)
//     //$('.date').text(mo+" "+d+", "+yr)        
// }


function _resize_elements() {
    var window_height = $(window).height()
    var nav_height = $('nav').height()
    var container_height = window_height - nav_height
    $('#serving-field,#action-field').height(container_height - 50)
    $('#serving-list').height($('#serving-list').parent().height() - 30)
}

function new_queue($cashier_id, $qid) {
    $.ajax({
        //arregle la ruta
        url: '../Actions.php?a=get_queue',
        method: 'POST',
        data: {
            cashier_id: $cashier_id,
            qid: $qid
        },
        dataType: 'JSON',
        error: err => {
            console.log(err)
        },
        success: function(resp) {
            if (resp.status == 'success') {
                var item = $('#serving-list').find('.list-group-item[data-id="' + $cashier_id + '"]')
                var cashier = item.find('.cashier-name').text()
                var nitem = item.clone()
                nitem.find('.serve-queue').text(resp.queue + " - " + resp.name)
                item.remove()
                $('#serving-list').prepend(nitem)
                if (resp.queue == '') {
                    nitem.hide('slow')
                } else {
                    nitem.show('slow')
                    speak("Número "+(Math.abs(resp.queue))+resp.name+ " , " + " favor proceder al "+ cashier) 
                    // speak("Número " + (Math.abs(resp.queue)) + resp.name + ", favor proceder a la " +
                    //     cashier)
                }
            }
        }
    })
}

$(function() {
    setInterval(() => {
        time_loop()
    }, 1000);
    $('#start').click(function() {
        $(this).hide()
        $('#monitor-holder').removeClass('d-none')
        _resize_elements()
        vid_loop.play()
    })
    $(window).resize(function() {
        _resize_elements()
    })

    websocket.onmessage = function(event) {
        var Data = JSON.parse(event.data);
        if (!!Data.type && typeof Data.type != undefined && typeof Data.type != null) {
            if (Data.type == 'queue') {
                new_queue(Data.cashier_id, Data.qid)
            }
            if (Data.type == 'test') {
                speak("This is a sample notification.")
            }
        }
    }
})
</script>