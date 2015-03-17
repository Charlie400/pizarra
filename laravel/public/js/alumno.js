//Estas funciones ocultan y muestran las distintas secciones del área de trabajo.
$(".AlumnoAsignacion").on("click",mostrarAsignacion);
function mostrarAsignacion(){
	$("#areaTrabajoSection1").show();
	$("#areaTrabajoSection2").hide();
}

$(".AlumnoTarea").on("click",mostrarTarea);
function mostrarTarea(){
	$("#areaTrabajoSection2").show();
	$("#areaTrabajoSection1").hide();
}
//Esta funcion regula el reloj para el modo test.
function timer(){
var tiempo = 1;//tiempo en minutos.
var duracion = (tiempo/2)*60;
$(".AnimateTransform").attr("dur",duracion);
//y esta el crono.
function countdown(minutes) {
    var seconds = 60;
    var mins = minutes
    function tick() {
        var counter = document.getElementById("timer");
        var current_minutes = mins-1
        seconds--;
        counter.innerHTML = (current_minutes < 10 ? "0" : "") + current_minutes.toString() + ":" + (seconds < 10 ? "0" : "") + String(seconds);
        if( seconds > 0 ) {
            setTimeout(tick, 1000);
        } else {
             
            if(mins > 1){
                    
               setTimeout(function () { countdown(mins - 1); }, 1000);
                     
            }
        }
    }
    tick();
}
 
countdown(tiempo);	
}
timer();