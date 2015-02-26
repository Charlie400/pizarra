;
var Name = {
	Dominio: 'dominio',
	Escenario: 'borrarEscenario',
	Elemento: 'borarElemento',
	Clase: 'clase',
	Alumno: 'alumno',
	Usuario: 'usuario',
	Docente: 'docente',
	BorrarUsuario: 'borrarUsuario',
	Video: 'video',
	SubirEscenarios: 'alertEscenarios',
	SubirElementos: 'alertElementos',
	GuardarSnapshot: 'guardarSnapshot',
	GuardarGrabacion: 'guardarGrabacion',
	CrearAsignacion: 'crearAsignacion',
	EnviarAsignacion: 'enviarAsignacion',
	ModificarAsignacion: 'modificarAsignacion',
	EliminarAsignacion: 'eliminarAsignacion',
	ModificarTest: 'modificarTest'
};
//funcion para cambiar clase por parámetros.
function changeClass(cElemento, cClaseNueva){
	$(cElemento).removeClass();
	$(cElemento).addClass(cClaseNueva);
}

$('#c').attr('width', $('.Pizarra').width());
$('#c').attr('height', $('.Pizarra').height());

$(window).resize(function(){
$('#c').attr('width', $('.Pizarra').width());
$('#c').attr('height', $('.Pizarra').height());

$('#imageTemp').attr('width', $('.Pizarra').width());
$('#imageTemp').attr('height', $('.Pizarra').height());
});

//función para abrir menús desplegables.

$('.MenuLeft-ItemLista-Esc').on('click', ListaClick1);
function ListaClick1(){

	if ($( ".EscenariosContainer" ).is(':hidden')) {

	 	$("#EscenariosArrow").removeAttr('src');
	 	$("#EscenariosArrow").attr('src',"images/DownArrow.png");
	 	$( ".EscenariosContainer" ).slideDown();
	}else{
		$("#EscenariosArrow").removeAttr('src');
	 	$("#EscenariosArrow").attr('src',"images/RightArrow.png");
	 	$( ".EscenariosContainer" ).slideUp();
	}
}

$('.MenuLeft-ItemLista-Ele').on('click', ListaClick2);
function ListaClick2(){
	if ($( ".ElementosContainer" ).is(':hidden')) {

	 	$("#ElementosArrow").removeAttr('src');
	 	$("#ElementosArrow").attr('src',"images/DownArrow.png");
	 	$( ".ElementosContainer" ).slideDown();
	}else{
		$("#ElementosArrow").removeAttr('src');
	 	$("#ElementosArrow").attr('src',"images/RightArrow.png");
	 	$( ".ElementosContainer" ).slideUp();
	}
}

//función para controlar el árbol de preguntas en el tipo test.

$(".TestTreeTittles").each(function(i) {
        $(this).attr('id', "testTreeTittles" + (i + 1));
    });
$(".TestTreeBody").each(function(i) {
        $(this).attr('id', "testTreeBody" + (i + 1));
    });
$('.TestTreeTittles').on('click', ListaClick3);
function ListaClick3(){
	var pregunta = this.id.slice(-1);
	var testArrowId = ("#testTreeTittles"+pregunta);
	var respuesta = ("#testTreeBody"+pregunta); 
	if ($(respuesta).is(':hidden')) {

	 	$(testArrowId).children('img').removeAttr('src');
	 	$(testArrowId).children('img').attr('src',"../images/DownArrow.png");
	 	$(respuesta).slideDown();
	}else{
		$(testArrowId).children('img').removeAttr('src');
	 	$(testArrowId).children('img').attr('src',"../images/RightArrow.png");
	 	$(respuesta).slideUp();
	}
};
//funciones que ocultan el árbol de preguntas y la explicación:
function slideRight(){
	if ($("#testTreeContainer").is(':hidden')) {
		$("#testSection2").css('display','inline-block');
		$("#testTreeContainer").css('display','block');
		$("#testTreeButtonsContainer").css('display','block');
		$("#testSection2").animate({width:"20.4%"},150);
		$("#testSection1").animate({width:"79.5%"},150);
		$("#botonEsconder1").animate({left:"79.6%"},150);
		$("#botonEsconder1 img").css("transform", "rotate(0deg)");
		$("#explicacionContainer textarea").animate({width:"70%"},150);
		$("#explicacionContainer").animate({right:"19.9%"},150);
		$("#explicacionIcons").animate({left:"73.5%"},150);
		$("#botonEsconder2").animate({left:"38.1%"},150);
	}else{
		$("#testSection2").animate({width:"1.9%"},150);
		$("#testTreeContainer").css('display','none');
		$("#testTreeButtonsContainer").css('display','none');
		$("#testSection1").animate({width:"98%"},150);
		$("#botonEsconder1").animate({left:"98%"},150);
		$("#botonEsconder1 img").css("transform", "rotate(180deg)");
		$("#explicacionContainer").animate({right:"1.92%"},150);
		$("#explicacionContainer textarea").animate({width:"90%"},150);
		$("#explicacionIcons").animate({left:"93.5%"},150);
		$("#botonEsconder2").animate({left:"47.1%"},150);

	};
}

function slideDown(){
	if ($("#explicacionContainer").is(':hidden')) {
		$("#preguntasContainer").animate({height:"60%"},15);
		$("#botonEsconder2").animate({top:"60%"},15);
		$("#botonEsconder2").css("border-radius", "0 0 5px 5px");
		$("#botonEsconder2 img").css("transform", "rotate(0deg)")
		$("#explicacionContainer").css("display","block");
	}else{
		$("#explicacionContainer").css("display","none");
		$("#preguntasContainer").animate({height:"97%"},150);
		$("#botonEsconder2").animate({top:"96.9%"},150);
		$("#botonEsconder2").css("border-radius", "5px 5px 0 0");
		$("#botonEsconder2 img").css("transform", "rotate(180deg)");
	}
}

function volverTest(){
	$("#liTest1Content1").css("display","block");
	$("#liTest1Content2").css("display","none");
	$(".LiTestAutomatico1").css("display","block");
	$(".LiTestAutomatico2").css("display","none");
}

function generarTest(){
	$(".LiTestAutomatico1").css("display","none");
	$(".LiTestAutomatico2").css("display","block");
	$(".contentTest ul").css("display","none");
}

/*Funciones que controlan la pestaña test*/
$("#liTest1Content").hide();
$(".LiTestAutomatico").hide();

$("#liTest1").on('click',liTest1F);
function liTest1F(){
	changeClass('#liTest1', 'ItemTestSelected');
	changeClass('#liTest2', 'ItemTest');
	changeClass('#liTest3', 'ItemTest');
	changeClass('#liTest4', 'ItemTest');
	changeClass('#liTest5', 'ItemTest');

	$("#liTest1Content").show();
	$(".LiTestAutomatico").hide();
	$(".ComboBoxTest").val(0);
	$("#formTest").css('display','inline-block');
	$(".Testp2").css('display','none');
	$(".Testp1").css('display','inline-block');
	$(".TestValue").css("display","none");

}

$("#liTest2").on('click',liTest2F);
function liTest2F(){
	changeClass('#liTest1', 'ItemTest');
	changeClass('#liTest2', 'ItemTestSelected');
	changeClass('#liTest3', 'ItemTest');
	changeClass('#liTest4', 'ItemTest');
	changeClass('#liTest5', 'ItemTest');

	$(".LiTestAutomatico").show();
	$(".AlumnoTest").show();
	$("#liTest1Content").hide();
	$(".ComboBoxTest").val(0);
	$(".Testp2").css('display','none');
	$(".Testp1").css('display','inline-block');
	volverTest();
}

$("#liTest3").on('click',liTest3F);
function liTest3F(){
	changeClass('#liTest1', 'ItemTest');
	changeClass('#liTest2', 'ItemTest');
	changeClass('#liTest3', 'ItemTestSelected');
	changeClass('#liTest4', 'ItemTest');
	changeClass('#liTest5', 'ItemTest');

	$(".LiTestAutomatico").show();
	$(".AlumnoTest").hide();
	$("#liTest1Content").hide();
	$(".ComboBoxTest").val(0);
	$(".Testp2").css('display','none');
	$(".Testp1").css('display','inline-block');
	volverTest();
}

$("#liTest4").on('click',liTest4F);
function liTest4F(){
	changeClass('#liTest1', 'ItemTest');
	changeClass('#liTest2', 'ItemTest');
	changeClass('#liTest3', 'ItemTest');
	changeClass('#liTest4', 'ItemTestSelected');
	changeClass('#liTest5', 'ItemTest');

	$(".LiTestAutomatico").show();
	$(".AlumnoTest").hide();
	$("#liTest1Content").hide();
	$(".ComboBoxTest").val(0);
	$(".Testp2").css('display','none');
	$(".Testp1").css('display','inline-block');
	volverTest();
}

$("#liTest5").on('click',liTest5F);
function liTest5F(){
	changeClass('#liTest1', 'ItemTest');
	changeClass('#liTest2', 'ItemTest');
	changeClass('#liTest3', 'ItemTest');
	changeClass('#liTest4', 'ItemTest');
	changeClass('#liTest5', 'ItemTestSelected');

	$(".LiTestAutomatico").show();
	$(".AlumnoTest").hide();
	$("#liTest1Content").hide();
	$(".ComboBoxTest").val(0);
	$(".Testp2").css('display','none');
	$(".Testp1").css('display','inline-block');
	volverTest();
}

/*Comienzan las funciones que cambian las pestañas del menú principal*/
$("#presentacionHerramientas").hide();
$("#edicionHerramientas").hide();
$("#usuariosHerramientas").hide();
$("#asignacionesHerramientas").hide();
$("#generacionHerramientas").hide();
$("#administracionHerramientas").hide();

$("#presentacion").on('click',Presentacion);

function Presentacion(){
	changeClass('#presentacion', 'Menu-ItemSelected');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#asignaciones', 'Menu-Item');
	changeClass('#generacion', 'Menu-Item');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas").show();
	$("#edicionHerramientas, #usuariosHerramientas, #asignacionesHerramientas, #generacionHerramientas, #administracionHerramientas").hide();
}

$("#edicion").on('click',Edicion);

function Edicion(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-ItemSelected');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#asignaciones', 'Menu-Item');
	changeClass('#generacion', 'Menu-Item');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas, #usuariosHerramientas, #asignacionesHerramientas, #generacionHerramientas, #administracionHerramientas").hide();
	$("#edicionHerramientas").show();
}

$("#usuarios").on('click',Usuarios);

function Usuarios(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-ItemSelected');
	changeClass('#asignaciones', 'Menu-Item');
	changeClass('#generacion', 'Menu-Item');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas, #edicionHerramientas, #asignacionesHerramientas, #generacionHerramientas, #administracionHerramientas").hide();
	$("#usuariosHerramientas").show();
}

$("#asignaciones").on('click',Asignaciones);

function Asignaciones(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#asignaciones', 'Menu-ItemSelected');
	changeClass('#generacion', 'Menu-Item');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas, #edicionHerramientas, #usuariosHerramientas, #generacionHerramientas, #administracionHerramientas").hide();
	$("#asignacionesHerramientas").show();		
}

$("#generacion").on('click',Generacion);

function Generacion(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#asignaciones', 'Menu-Item');
	changeClass('#generacion', 'Menu-ItemSelected');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas, #edicionHerramientas, #usuariosHerramientas, #asignacionesHerramientas, #administracionHerramientas").hide();
	$("#generacionHerramientas").show();		
}

$("#administracion").on('click',Administracion);

function Administracion(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#asignaciones', 'Menu-Item');
	changeClass('#generacion', 'Menu-Item');
	changeClass('#administracion', 'Menu-ItemSelected');
	
	$("#presentacionHerramientas, #edicionHerramientas, #asignacionesHerramientas, #generacionHerramientas, #usuariosHerramientas").hide();
	$("#administracionHerramientas").show();
}
/*Terminan las funciones del menú principal*/
//esta función controla el bloqueo del combobox clase.
if ($("#dominio").val() == 0){
	$("#clase").prop("disabled", true)
	$("#clase").attr('class', 'ComboBoxDisabled');
}else{
	$("#clase").prop("disabled", false);
	$("#clase").attr('class', 'ComboBoxClase');
}
//Esta función añade un cuadro de texto para agregar clase a un test.
$("#claseTest").on("change", testOtros);
function testOtros(){
var otros = $('#claseTest').val();
	if (otros == "otros"){
		$("#testOtros").val("");
		$("#testOtros").css('display','inline');
	}else{
		$("#testOtros").css('display','none');
	}
}
//Ésta función oculta la opción de seleccionar el tipo de respuesta así como la información dependiendo del tipo de test seleccionado en el combo
$(".ComboBoxTest").on("change", respuestaTest);
function respuestaTest(){
	var comboTest = $(".ComboBoxTest").not( ":hidden" ).val();
	if (comboTest == "1"){
		$("#formTest").css('display','inline-block');
		$(".Testp2").css('display','none');
		$(".Testp1").css('display','inline-block');
		$(".TestValue").css("display","none");
	}else if (comboTest == "2"){
		$("#formTest").css('display','none');
		$(".Testp1").css('display','none');
		$(".Testp2").css('display','inline-block');
		$(".TestValue").css("display","table-cell");
	}
}
respuestaTest();
//función para incluir calendario a los formularios.
$(function() {
    $( ".Datepicker").datepicker();
    $.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['es']);
  }); 


//Esta función controla el logout.
$(".CuadroUsuarioP").on("click", OpenlogOut);
function OpenlogOut(){
	if ($(".CuadroUsuarioLogOut").is(":visible")) {
		$(".CuadroUsuarioLogOut").slideUp();
	}else{
		$(".CuadroUsuarioLogOut").slideDown();
	}
}

function comprobarCheck(){
	if ($(".ContentCheck").is(':checked')){
		$(".UncheckButton").css("display","none");
		$(".CheckButton").css("display","inline-block");
	}else{
		$(".UncheckButton").css("display","inline-block");
		$(".CheckButton").css("display","none");
	}

	};

//Esta función controla la sincronización del boton rec y stop.

changeClass('#botonGrabarDiv','BotonGrabarOff')
function recordButtom()
{
	changeClass('#botonStopDiv','BotonStopDivVisible');
	$('#botonGrabarDivOff').css('display','none');
	$('#botonGrabarDivOn').css('display','inline-block');
	$(".AlertContainer").fadeOut();

	recordVideoAudio();
}

function stopButtom()
{
	$('#botonGrabarDivOff').css('display','inline-block');
	$('#botonGrabarDivOn').css('display','none');
	changeClass('#botonStopDiv','BotonStopDivHidden');

	stopVideoAudio();
}

$("#dominio").on("click", GetComboDominio);
//Esta variable contendrá el valor del dominio seleccionado anteriormente.
var selectDominio = "";

function GetComboDominio(){

	if ($("#dominio").val() != 0){
		
			$(".CuadroP1").empty();
			$(".CuadroP2").empty();
			$(".CuadroP1").append($("#dominio").find('option:selected').text());
			$("#clase").prop("disabled", false);
			$("#clase").attr('class', 'ComboBoxClase');
		

	}else{
		$("#clase").prop("disabled", true)
		$("#clase").attr('class', 'ComboBoxDisabled');
		$("#clase").val("#");
		$(".CuadroP1").empty();
		$(".CuadroP2").empty();
	}
}

$("#clase").on("click", GetComboClase);

function GetComboClase(){

	if ($("#clase").val() != 0){
		$(".CuadroP2").empty();
		$(".CuadroP2").append("/ " + $("#clase").find('option:selected').text());

	}else{
		$(".CuadroP2").empty();
	}
}


/* Funciones para alerts en botones */

function hideFormsLess(clase)
{
	clase || (clase = "");

	switch(clase)
	{
		case ".Foo1":
			$(".Foo2,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7,.Foo8,.Foo9").hide();
		break;
		case ".Foo2":
			$(".Foo1,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7,.Foo8,.Foo9").hide();
		break;
		case ".Foo3":
			$(".Foo1,.Foo2,.Foo4,.Foo5,.Foo6,.Foo7,.Foo8,.Foo9").hide();
		break;
		case ".Foo4":
			$(".Foo1,.Foo2,.Foo3,.Foo5,.Foo6,.Foo7,.Foo8,.Foo9").hide();
		break;
		case ".Foo5":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo6,.Foo7,.Foo8,.Foo9").hide();
		break;
		case ".Foo6":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo7,.Foo8,.Foo9").hide();
		break;
		case ".Foo7":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo6,.Foo8,.Foo9").hide();
		break;
		case ".Foo8":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7,.Foo9").hide();
		break;
		case ".Foo9":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7,.Foo8").hide();
		break;
		case "":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7,.Foo8,.Foo9").hide();
		break;
	}
}

function showClass(clase)
{
	$(clase).css('display', 'initial');
}

function initializeCreate()
{
	var clase = {
					Form: ".Foo1",
					Input: "#foo11"
				};
	$('#foo1Fail').empty();
	$("#alertBody").removeClass("AlertBodyBig").addClass("AlertBody"); 
	$(".AlertContainer").fadeIn();
	showClass(clase.Form);
	hideFormsLess(clase.Form);

	return clase;
}

function createClase()
{
	var clase = initializeCreate();

	formParametros(false, true, true,  "Añadir Clase", "Clic en agregar para añadir clase.", Name.Clase);	
	$("#addButtomFoo1").attr('onClick',"addClase()");
	$(clase.Input).val('');
	$(clase.Input).attr('name',"clase");
	$(clase.Input).attr('placeholder',"Clase");
	$("#selectDominio").show();
	getDominios('#selectDominio');
}

function createDominio()
{
	var clase = initializeCreate();

	formParametros(false, true, true, "Añadir Dominio", "Clic en agregar para añadir dominio.", Name.Dominio);
	$("#addButtomFoo1").attr('onClick',"addDominio()");
	$(clase.Input).val('');
	$(clase.Input).attr('name',"dominio");
	$(clase.Input).attr('placeholder',"Dominio");
	$("#selectDominio").hide();
}

function borrarEscenario()
{
	var clase = 
	{
		Foo: ".Foo2",
		Cont: ".content"
	};
	$(clase.Cont).empty();
	$(clase.Cont).attr('id', 'contentEscenarios');
	getMenuImages(getEndDir.Escenarios);
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").fadeIn();
	showClass(clase.Foo);
	hideFormsLess(clase.Foo);
	$(clase.Foo).get(0).setAttribute('action', serverURL + '/borrar/escenario');
	formParametros(true, false, true, "Borrar Escenarios", "Elija los escenarios que desee borrar.", Name.Escenario);
	//Esta función deshabilita el boton aceptar en borrar elementos y escenarios  hasta que algun check haya sido activado.
	$(".CheckButton").css("display","none");
	$(".UncheckButton").css("display","inline-block");
	$(".UncheckButton").on("click", escenarioNoSeleccionado)
	function escenarioNoSeleccionado(){
		$(".AlertContent").empty();
		$(".AlertContent").append("Elija los escenarios que desee borrar.<br><font color='red'>Debe tener seleccionado al menos un escenario.</font>");
	}


}

function borrarElementos()
{
	var clase = 
	{
		Foo: ".Foo2",
		Cont: ".content"
	};
	$(clase.Cont).empty();
	$(clase.Cont).attr('id', 'contentElementos');
	getMenuImages(getEndDir.Elementos);	
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").fadeIn();
	showClass(clase.Foo);
	hideFormsLess(clase.Foo);
	$(clase.Foo).get(0).setAttribute('action', serverURL + '/borrar/elemento');
	formParametros(true, false, true, "Borrar Elementos", "Elija los elementos que desee borrar.", Name.Elemento);
	$(".CheckButton").css("display","none");
	$(".UncheckButton").css("display","inline-block");
	$(".UncheckButton").on("click", elementoNoSeleccionado)
	function elementoNoSeleccionado(){
		$(".AlertContent").empty();
		$(".AlertContent").append("Elija los elementos que desee borrar.<br><font color='red'>Debe tener seleccionado al menos un elemento.</font>");
	}


}


function createAlumno()
{
	var clase = ".Foo3";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").css('display', 'inline-block');
	showClass(clase);
	hideFormsLess(clase);
	formParametros(true, false, true,  "Añadir Alumno", "Rellene los campos y pulse aceptar. *Recuerde seleccionar un"
	+" dominio en las pestaña de \"Presentacion\".", Name.Alumno);
}

function closeAlert()
{
	$(".AlertContainer").fadeOut();
}

function editUsuario()
{
	var clase = ".Foo4";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").fadeIn();
	showClass(clase);
	hideFormsLess(clase);
	formParametros(true, false, true,  "Editar Usuario", "Rellene los campos y pulse aceptar.", Name.Usuario);
}

function deleteUsuario()
{
	var clase = ".Foo1";
	$('#foo1Fail').empty();
	$("#alertBody").removeClass("AlertBodyBig").addClass("AlertBody"); 
	$(".AlertContainer").fadeIn();
	showClass(clase);
	hideFormsLess(clase);
	formParametros(true, false, true,  "Eliminar Usuario", "Introduzca el usuario a eliminar y pulse aceptar.", Name.BorrarUsuario);
	$("#foo11").attr('name',"borrarUsuario");
	$("#foo11").attr('placeholder',"Usuario");
	$("#selectDominio").hide();
}

function createProfesor()
{
	var clase = ".Foo3";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").fadeIn();
	showClass(clase);
	hideFormsLess(clase);
	formParametros(true, false, true,  "Añadir Docente", "Rellene los campos y pulse aceptar.", Name.Docente);
}

function grabarAlert()
{
	var clase = ".Foo5";
	$("#alertBody").removeClass("AlertBodyBig").addClass("AlertBody"); 
	showClass(clase);
	hideFormsLess(clase);
	$(".AlertContainer").fadeIn();
	formParametros(true, false, true, "Grabar Video", "Se va a comenzar a grabar un video cuya duración no podrá superar 5 minutos.", Name.Video);
}

function escenariosAlert()
{	
	var clase = ".Foo6";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase);
	showClass("#fileContainer1");
	$("#fileContainer2").hide();
	$(".AlertContainer").fadeIn();
	formParametros(true,false,true,"Añadir Escenario","Selecciona una imagen, asignele un nombre y pulse Aceptar.", Name.AñadirEscenario);
	$("#foo61").attr('name',"nombreEscenario");
	$("#foo61").attr('placeholder',"Nuevo Escenario");
	$("#foo62").attr('name',"imgEscenario");
}

function elementosAlert()
{	
	var clase = ".Foo6";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase);
	showClass("#fileContainer2");
	$("#fileContainer1").hide();
	$(".AlertContainer").fadeIn();
	formParametros(true,false,true,"Añadir Elemento","Selecciona una imagen, asignele un nombre y pulse Aceptar.", Name.AñadirElemento);
	$("#foo61").attr('name',"nombreElemento");
	$("#foo61").attr('placeholder',"Nuevo Elemento");
	$("#foo62").attr('name',"imgElemento");
}

function saveSnapshot()
{
	var clase = ".Foo7";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase);
	$(".AlertContainer").fadeIn();
	formParametros(false,false,true,"Guardar Snapshot","Selecciona donde guardar.", Name.GuardarSnapshot);
	$("#foo71").attr('name',"PublicarSnapshot");
	$("#foo72").attr('name',"DescargarSnapshot");
}

function saveRecord()
{
	var clase = ".Foo7";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase);
	$(".AlertContainer").fadeIn();
	formParametros(false,false,true,"Guardar Grabación","", Name.GuardarGrabacion);
	$("#foo71").attr('name',"PublicarGrabacion");
	$("#foo72").attr('name',"DescargarGrabacion");
}

function createAsignacion()
{
	var clase = ".Foo8";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase); 
	$(".AlertContainer").fadeIn();
	var asignacion = $("#comboAsignacion option:selected").text().toLowerCase();
	formParametros(true,false,true,"Crear "+asignacion,"Rellene los campos y pulse aceptar", Name.CrearAsignacion);	

	//Para poder distinguir materiales de apoyo de tareas añadiré un input oculto
	var typeAsignacion = $('#typeAsignacion');
	
	if ($('#comboAsignacion').val() == 0) { //Apoyo
		typeAsignacion.val(0);
		$('#foo83').css('display','inline-block');
		$('#foo84').css('display','inline-block');
		$('#foo85').css('display','none');
	}else{									//Tareas
		typeAsignacion.val(1);
		$('#foo83').css('display','none');
		$('#foo84').css('display','none');
		$('#foo85').css('display','block');
	};
	$("#foo851").on('change',function(){
		if ($("#foo851").is(':checked')){
			$("#foo852").css("display","inline-block");
			$("#foo853").css("display","inline-block");
		}else
		{
			$("#foo852").css("display","none");
			$("#foo853").css("display","none");
		}
	});
}

function sendAsignacion()
{
	var clase = ".Foo9";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase); 
	$(".AlertContainer").fadeIn();
	$("#td1").hide();
	$("#td2").show();
	$("#td3").hide();
	$(".ComboBoxAsignadas").show();
	var asignacion = $("#comboAsignacion option:selected").text().toLowerCase();
	formParametros(true,false,true,"Enviar "+asignacion,"Seleccione alumno y asignación y pulse aceptar", Name.EnviarAsignacion);	
}
function editAsignacion()
{
	var clase = ".Foo8";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase); 
	$(".AlertContainer").fadeIn();
	var asignacion = $("#comboAsignacion option:selected").text().toLowerCase();
	formParametros(true,false,true,"Modificar "+asignacion,"Modifique los cambios deseados y pulse aceptar", Name.ModificarAsignacion);	

	//Para poder distinguir materiales de apoyo de tareas añadiré un input oculto
	var typeAsignacion = $('#typeAsignacion');
	
	if ($('#comboAsignacion').val() == 0) { //Apoyo
		typeAsignacion.val(0);
		$('#foo83').css('display','initial');
		$('#foo84').css('display','initial');
		$('#foo85').css('display','none');
	}else{									//Tareas
		typeAsignacion.val(1);
		$('#foo83').css('display','none');
		$('#foo84').css('display','none');
		$('#foo85').css('display','initial');
	};
	$("#foo851").on('change',function(){
		if ($("#foo851").is(':checked')){
			$("#foo852").css("display","inline-block");
			$("#foo853").css("display","inline-block");
		}else
		{
			$("#foo852").css("display","none");
			$("#foo853").css("display","none");
		}
	});
}

function deleteAsignacion()
{
	var clase = ".Foo8";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase); 
	$(".AlertContainer").fadeIn();
	var asignacion = $("#comboAsignacion option:selected").text().toLowerCase();
	formParametros(true,false,true,"Eliminar "+asignacion,"Seleccione asignación y pulse aceptar para eliminar", Name.EliminarAsignacion);	

	//Para poder distinguir materiales de apoyo de tareas añadiré un input oculto
	var typeAsignacion = $('#typeAsignacion');
	
	if ($('#comboAsignacion').val() == 0) { //Apoyo
		typeAsignacion.val(0);
		$('#foo83').css('display','initial');
		$('#foo84').css('display','initial');
		$('#foo85').css('display','none');
	}else{									//Tareas
		typeAsignacion.val(1);
		$('#foo83').css('display','none');
		$('#foo84').css('display','none');
		$('#foo85').css('display','initial');
	};
	$("#foo851").on('change',function(){
		if ($("#foo851").is(':checked')){
			$("#foo852").css("display","inline-block");
			$("#foo853").css("display","inline-block");
		}else
		{
			$("#foo852").css("display","none");
			$("#foo853").css("display","none");
		}
	});
}

function modificarTest()
{
	var clase = ".Foo9";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase); 
	$("#td1").show();
	$("#td2").hide();
	$("#td3").show();
	$(".ComboBoxAsignadas").hide();
	$(".AlertContainer").fadeIn();
	formParametros(false,true,true,"Modificar Test","Seleccione test a modificar y pulse aceptar para eliminar", Name.ModificarTest);
}
function eliminarTest()
{
	var clase = ".Foo9";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase);
	$("#td1").show();
	$("#td2").hide();
	$("#td3").show();
	$(".ComboBoxAsignadas").hide();
	$(".AlertContainer").fadeIn();
	formParametros(true,false,true,"Modificar Test","Seleccione test a modificar y pulse aceptar para eliminar", Name.ModificarTest);
}




//En la variable n se pasará un nombre para el input dado que es necesario para enviar el formulario.
function formParametros(pOkButton, pAddButton, pCancelButton, pTitulo, pCuerpo, n){
		
		$(".AlertTittleContainer h4").empty();
		$(".AlertTittleContainer h4").append(pTitulo);
		$('.AlertContent').empty();
		$('.AlertContent').append(pCuerpo);
		ShowHideButtons(pOkButton, pAddButton, pCancelButton);
	
}


/* Termina funciones para alerts en botones */

/*Pasar por parámetros con valor TRUE para activar los botones deseados*/
function ShowHideButtons(pOkButton, pAddButton, pCancelButton){

	if (pOkButton == true){
		$('.OkButton').css('display', 'inline-block');
	}else{
		$('.OkButton').css('display', 'none');
	}

	if (pAddButton == true){
		$('.AddButton').css('display', 'inline-block');
	}else{
		$('.AddButton').css('display', 'none');
	}

	if (pCancelButton == true){
		$('.CancelButton').css('display', 'inline-block');
	}else{
		$('.CancelButton').css('display', 'none');
	}
}

/*---------FUNCIÓN AJAX----------*/

//Esta variable contendrá el valor de la respuesta de AJAX al completarse
var ajaxData = [];

function createAjaxRequest(data, url, id, befSendText, responseText, method)
{
	if (typeof(method) === undefined) method = 'GET';
	if (typeof(data) != typeof({})) data = {data: data};

	if ( ! working)
	{
		working = true;

		$.ajax({
			data: data,
			url: url, 
			dataType: 'json',
			type: method,
			beforeSend: function(){
				$(id).text(befSendText);				
			},
			timeout: 3000,
			success: function(response){
				working  = false;
				ajaxData = response;
				console.log(ajaxData);

				$(id).text(responseText);
			},
			error: function (jqXHR,estado,error) {
				working = false;
				console.log(estado);
				console.log(error);
			}
		});
	}
	else
	{
		setTimeout(function () 
		{
			createAjaxRequest(data, url, id, befSendText, responseText, method);
		}, 200);
	}
}

/*------------COMIENZAN LAS FUNCIONES QUE USAN AJAX PARA INTERACTUAR CON EL CONTENIDO------------*/

var dominio = $("#dominio"), clase = $('[id*=clase]'), dominioOption = $('[id*=dom]'), prevDomVal, 
working = false;

//SI SE HACE CLICK EN LOS OPTIONS DEL SELECT CON ID 'dominio' SE LLAMA A LA FUNCIÓN

dominioOption.click(getClasses); // on("change")??

//FUNCIÓN ENCARGADA DE TRAER LAS CLASES DEPENDIENDO DEL DOMINIO SELECCIONADO

function getClasses()
{	
	var val   = dominio.val();	

	if (val != prevDomVal)
	{
		prevValue = val;
		if (val != "")
		{			
			var url = serverURL+'/mostrar-clases';

			createAjaxRequest(val, url, '#claseOption', 'Cargando...', 'Clase');

			setTimeout(function () {
				if (ajaxData !== null)
				{
					if (ajaxData.length < 1) return;

					clase.empty();				
					clase.append('<option id="clase" value="">Clase</option>');				

					$.each(ajaxData, function (i, value){				
						clase.append('<option id="clase'+(parseInt(i)+1)+'" value="'+value['id']+'">'+value['Nombre']+'</option>');				
					});

					$('#clase > option[value="'+selectVal+'"]').attr('selected', 'selected');
					selectVal = "";	

					return;				
				}

				getDominios('#dominio');

			}
			, 500);
		}
		else
		{
			$('#clase1').text('Clase');
		}			
	}		
}

//FUNCIÓN ENCARGADA DE TRAER LOS DOMINIOS

function getDominios(id)
{
	if (typeof(id) === undefined) id = '#selectDominio, #dominio';

	var url = serverURL+'/mostrar-dominios';

	createAjaxRequest("", url, id, 'Cargando...', 'Dominio');

	setTimeout(function () {

		var selectDom = $(id);
		selectDom.empty();

		selectDom.append('<option value="">Dominio</option>');
		$.each(ajaxData, function (i, value){				
			selectDom.append('<option id="dominio'+value['id']+'" value="'+value['id']+'">'+value['Nombre']+
			'</option>');				
		});

		$(id + ' > option[value="'+selectVal+'"]').attr('selected', 'selected');
		selectVal = "";
	}
	, 500);
}

function showMenuImages(idMenu, idAlert, idFile, idInput, iFunction, uFunction, addFunction, carpet)
{
	var menu = $(idMenu),
	alert    = $(idAlert),
	fileContainer = $(idFile);
	
	menu.text("");				
	alert.text("");
	fileContainer.text("");

	fileContainer.append('<input type="file" id="'+idInput+'" name="'+idInput+'" onChange="'+uFunction+'()" style="width: 160px;" />');

	$.each(ajaxData, function (i, value)
	{			
		menu.append('<article class="Article">'+
						'<img class="clickImage" src="images/'+carpet+'/'+value['fullname']+'" height="80" width="80">'+
						'<p id="menuleftTitulo"></p>'+
					'</article>');				
		alert.append('<tr>'+
						'<td><img src="images/'+carpet+'/'+value['fullname']+'" height="40" width="40"></td>'+
						'<td>'+value['Nombre']+'</td>'+
						'<td><input type="Checkbox" name="checkbox[]" onchange="comprobarCheck()" class="ContentCheck" value="'+value['id']+'" /></td>'+
					'</tr>');
	});
	
	clickImage = $(".clickImage").click(insertImageToCanvas); //Definimos la función con la que traeremos las imagenes 
	//de fondo al hacer click

	ajaxData.length = 0;

	menu.append('<article class="AddArticle" onClick="'+addFunction+'()">'+
						'<img class="AddArticle-Image" src="images/addEscenario.png" height="80" width="80">'+
				'</article>');
	
}

var getEndDir = 
{
	Escenarios: '/mostrar-escenarios',
 	Elementos:  '/mostrar-elementos'
}

function cleanAllMenuImages()
{
	$('#MAC1, #contentEscenarios, #fileContainer1').empty(); //Limpiar Escenarios
	$('#MAC2, #contentElementos, #fileContainer2').empty();  //Limpiar Elementos
}

function getMenuImages(endDir)
{	
	var url = serverURL + endDir,
	classValue = $('#clase').val();	

	if (isNumber(classValue))
	{
		createAjaxRequest(classValue, url, '', '', '');	

		setTimeout(function () 
		{
			if (endDir === getEndDir.Escenarios)
			{
				showMenuImages('#MAC1', '#contentEscenarios', "#fileContainer1", 'escenario', 'insertImageToCanvas', 
						       'uploadEscenario', 'escenariosAlert', 'Escenarios');
			}
			else if (endDir === getEndDir.Elementos)
			{
				showMenuImages('#MAC2', '#contentElementos', "#fileContainer2", 'elemento', 'insertImageToCanvas', 
							   'uploadElemento', 'elementosAlert', 'Elementos');
			}
			
		}, 500);
	}
	else
	{
		cleanAllMenuImages();		
	}
}

$('#clase').on('change', function () 
					 {
						getMenuImages(getEndDir.Escenarios); 
						setTimeout(function () 
						{
							getMenuImages(getEndDir.Elementos);
						}, 500);
					 });

/*-------------------------- COMIENZAN FUNCIONES PARA SUBIR ARCHIVOS ---------------------------------------*/

function uploadEscenario()
{
	uploadFile('#escenario', 'escenario', getEndDir.Escenarios);
}

function uploadElemento()
{
	uploadFile('#elemento', 'elemento', getEndDir.Elementos);
}

function uploadFile(id, name, endDir)
{	
	if ( ! working)
	{
		working   = true;		

		var classValue = $('#clase').val();		
		
		if (isNumber(classValue))
		{
			var file = $(id)[0],
			url = serverURL + '/subir/archivo';

			file = file.files[0];

			var data = new FormData();

			data.append(name, file);
			data.append('clase', classValue);

			$.ajax({
				url:url,

				type:'POST',

				contentType:false,

				data: data,

				processData:false,

				cache:false,

				success: function (r)
				{
					console.log(r);
					getMenuImages(endDir);
					working = false;
				},
				error: function (jqXHR,estado,error) {
					console.log(estado);
					console.log(error);
					working = false;
				}
			});
		}
		else
		{
			working = false;
			getMenuImages(endDir);
			console.log('No has seleccionado una clase.');
		}
	}
}

function isNumber(bar)
{
	return ! isNaN(parseInt(bar));
}

/*-------------------------- TERMINAN FUNCIONES PARA SUBIR ARCHIVOS ---------------------------------------*/

/*-------------------- COMIENZAN MÉTODOS PARA ENVIAR FORMS POR AJAX -----------------------*/

var selectVal = "";

function addDominio()
{
	var data  = getData('dominio'),
	url 	  = serverURL + '/agregar';
	selectVal = $('#dominio').val();

	console.log(selectVal);

	createAjaxRequest(data, url, '', '', '', 'POST');

	setTimeout(function () 
			    {

					if (ajaxData.length > 0)
					{
						getDominios('#dominio');
					}							

				}, 500);
}

function addClase()
{	
	var data = getData('clase'),
	url 	 = serverURL + '/agregar';

	selectVal = $('#clase').val();	

	createAjaxRequest(data, url, '', '', '', 'POST');

	setTimeout(function () 
			    {

					if (ajaxData.length > 0)
					{
						getClasses();
					}

				}, 500);
}

function getData(key)
{
	var input = $('#foo11'),
	data 	  = {};

	if (isEmpty(input.val()))
	{
		$('#foo1Fail').text("El campo está vacío");
		return null;
	}

	if (key === 'dominio')
	{
		data[key] = input.val();
		return data;
	}

	data[key] = input.val();
	data['selectDominio'] = $('#selectDominio').val();

	return data;	
}

function modifyUser(id, names, action, clClass, endOfId)
{
	var isEdit = (action === 'edit');
	if (action === 'create' || isEdit)
	{
		var url  = serverURL + '/' + action + '/user';

		ajaxManager.shotQuery(url, id, names);

		setTimeout(function () {
						if (isEdit) document.getElementById('oldpassword').value = "";
						$(clClass).empty();

						if (ajaxData instanceof Object)
						{
							var p;												
							$.each(ajaxData, function (i, value) {
								p = $('#' + i + endOfId);							
								p.text(value);
							});							
						}						
					}, 500);
	}
	else
	{
		return null;
	}
}

function createUser()
{
	var names = ['firstname', 'lastname', 'username', 'nif', 'adress', 'locality', 'province', 'cp', 'phone', 
				 'email', 'borndate', 'obs', 'password', 'password_confirmation', 'roles', 'id_dominio'], 
	id   = ['firstname1', 'lastname1', 'username1', 'nif1', 'adress1', 'locality1', 'province1', 'cp1', 'phone1', 
		    'email1', 'borndate1', 'obs1', 'password1', 'password_confirmation1', 'roles1', 'dominio'];

	modifyUser(id, names, 'create', '.CU_errors', '1Error');
}

function editUser()
{
	var id = ['firstname', 'lastname', 'username', 'nif', 'adress', 'locality', 'province', 'cp', 'phone', 
		  'email', 'borndate', 'obs', 'oldpassword', 'password', 'password_confirmation', 'roles'],
	names = id;

	modifyUser(id, names, 'edit', '.EU_errors', 'Error');
}

/*-------------------- TERMINAN MÉTODOS PARA ENVIAR FORMS POR AJAX -----------------------*/

/*------------TERMINAN LAS FUNCIONES QUE USAN AJAX PARA INTERACTUAR CON EL CONTENIDO-----------*/

function dibujoManoAlzada(){
	var p = $('#botonDibujo').position();
	$(".ColorPickerContainer").css('left', p.left);
	$(".ColorPickerContainer").css('top', p.top);
	$(".ColorPickerContainer").toggle();
	$("#closeButton2").on("click",ocultarColorPicker);
	$("#closeButton3").on("click",ocultarTypeContainer);
	$("#closeButton4").on("click",ocultarInputText);
	function ocultarColorPicker(){
		$(".ColorPickerContainer").hide();	
		if ($(".ColorPickerContainer").is(":visible")){
			$('#botonDibujoDiv').css('background-color','#E74C3C');
		}else{
			$('#botonDibujoDiv').css('background-color','#3498DB');
		}	
	}
	if ($(".ColorPickerContainer").is(":visible")){
		$('#botonDibujoDiv').css('background-color','#E74C3C');
	}else{
		$('#botonDibujoDiv').css('background-color','#3498DB');
	}	
	function ocultarTypeContainer(){
		$(".TypeContainer").hide();	
	}
	function ocultarInputText(){
		$(".TempTypeText").hide();	
	}
}

$('.ColorPickerContainer h4').on('mouseover', moverMenu);

function moverMenu(){
	//$('.ColorPickerContainer').drags();
	$('.ColorPickerContainer').draggable();
}

$('#type').on('click', EditorDeTexto);

function EditorDeTexto(){
	$('.TypeContainer').draggable();
	$(".TypeContainer").toggle();
	if (!$(".TypeContainer").is(":visible")){
    	$('#type').css('box-shadow', '');
  	}else{
    	sPintarActivo = true;
    	$('#type').css('box-shadow', '0px 0px 2px #FFF');
  	}
}

