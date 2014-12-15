var pizarra_canvas;
var pizarra_context;
var sGrosor = 3;
var imageArray = new Array();
 

pizarra_canvas = document.getElementById("c");
pizarra_context = pizarra_canvas.getContext("2d");
pizarra_context.strokeStyle = "#000";
pizarra_context.lineWidth = sGrosor;
pizarra_canvas.addEventListener("mousedown",empezarPintar,false);
pizarra_canvas.addEventListener("mouseup",terminarPintar,false);

$('.ColorPicker').on('click', cambiarColor);

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function cambiarColor(){
	pizarra_context.strokeStyle = rgb2hex($(this).css('background-color'));
}
 
$('.LineWidthModifier').on('click', cambiaTrazado)

function cambiaTrazado(){

	var sValor = $(this).attr('id')
	var sSuma;

	if (sValor == "mas"){
		sSuma = sGrosor + 1
		if (sSuma <21){
			pizarra_context.lineWidth= sSuma
		}
	}else if(sValor == "menos"){
		sSuma = sGrosor - 1
		if (sSuma > 0){
			pizarra_context.lineWidth= sSuma
		}
	}

	sGrosor = sSuma
}

/*
	empezarPintar(e)
	Al hacer mousedown sobre la pizarra, comenzamos un nuevo trazo, movemos el pincel hasta la 
	posición del ratón y añadimos un listener para el evento mousemove, para que con cada movimiento 
	del ratón se haga un nuevo trazo
*/
 
 
function empezarPintar(e){
	imageArray.push(getDataURL());
	pizarra_context.beginPath();
	pizarra_context.moveTo(e.clientX-pizarra_canvas.offsetLeft,e.clientY-pizarra_canvas.offsetTop);
	pizarra_canvas.addEventListener("mousemove",pintar,false)
}
 
/*
	terminarPintar(e) se ejecuta al soltar el botón izquierdo, y elimina el listener para 
	mousemove
*/
 
function terminarPintar(e){
	pizarra_canvas.removeEventListener("mousemove",pintar,false);
}
 
/*
	pintar(e) se ejecuta cada vez que movemos el ratón con el botón izquierdo pulsado.
	Con cada movimiento dibujamos una nueva linea hasta la posición actual del ratón en pantalla.
*/
 
function pintar(e) {
	pizarra_context.lineTo(e.clientX-pizarra_canvas.offsetLeft,e.clientY-pizarra_canvas.offsetTop);
	pizarra_context.stroke();
}
 
/*
	borrar() vuelve a setear el ancho del canvas, lo que produce que se borren los trazos dibujados
	hasta ese momento.
*/
 
function borrar(){
	pizarra_canvas.width = pizarra_canvas.width;
}

function goCanvas(){
	var imagen;
	createAjaxRequest();
	pizarra_canvas.drawImage(imagen, 0, 0)
}

function backCanvas(){
	var imagen;
	var lastImage = imageArray.length()-1;
	createAjaxRequest(imageArray(lastImage), );
	pizarra_canvas.drawImage(imagen, 0, 0)
}
