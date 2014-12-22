;
var Name = {
	Dominio: 'dominio',
	Escenario: 'borrarEscenario',
	Clase: 'clase',
	Alumno: 'alumno',
	Usuario: 'usuario',
	Docente: 'docente',
	BorrarUsuario: 'borrarUsuario',
	Video: 'video'
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
});

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
/*Comienzan las funciones que cambian las pestañas del menú principal*/
$("#presentacionHerramientas").hide();
$("#edicionHerramientas").hide();
$("#usuariosHerramientas").hide();
$("#administracionHerramientas").hide();

$("#presentacion").on('click',Presentacion);

function Presentacion(){
	changeClass('#presentacion', 'Menu-ItemSelected');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas").show();
	$("#edicionHerramientas").hide();
	$("#usuariosHerramientas").hide();
	$("#administracionHerramientas").hide();
}

$("#edicion").on('click',Edicion);

function Edicion(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-ItemSelected');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas").hide();
	$("#edicionHerramientas").show();
	$("#usuariosHerramientas").hide();
	$("#administracionHerramientas").hide();
}

$("#usuarios").on('click',Usuarios);

function Usuarios(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-ItemSelected');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas").hide();
	$("#edicionHerramientas").hide();
	$("#usuariosHerramientas").show();
	$("#administracionHerramientas").hide();
}

$("#administracion").on('click',Administracion);

function Administracion(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#administracion', 'Menu-ItemSelected');
	
	$("#presentacionHerramientas").hide();
	$("#edicionHerramientas").hide();
	$("#usuariosHerramientas").hide();
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


$("#dominio").on("click", GetComboDominio);

//Esta función controla el logout.
$(".CuadroUsuarioP").on("click", OpenlogOut);
function OpenlogOut(){
	if ($(".CuadroUsuarioLogOut").is(":visible")) {
		$(".CuadroUsuarioLogOut").slideUp();
	}else
	{
		$(".CuadroUsuarioLogOut").slideDown();
	}
}
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
			$(".Foo2,.Foo3,.Foo4,.Foo5").hide();
		break;
		case ".Foo2":
			$(".Foo1,.Foo3,.Foo4,.Foo5").hide();
		break;
		case ".Foo3":
			$(".Foo1,.Foo2,.Foo4,.Foo5").hide();
		break;
		case ".Foo4":
			$(".Foo1,.Foo2,.Foo3,.Foo5").hide();
		break;
		case ".Foo5":
			$(".Foo1,.Foo2,.Foo3,.Foo4").hide();
		break;
		case "":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5").hide();
		break;
	}
}

function showClass(clase)
{
	$(clase).css('display', 'inline-block');
}

function createDominio()
{
	$("#alertBody").removeClass("AlertBodyBig").addClass("AlertBody"); 
	$(".AlertContainer").fadeIn();
	showClass(".Foo1");
	hideFormsLess(".Foo1");
	formParametros(false, true, true, "Añadir Dominio", "Clic en agregar para añadir dominio.", Name.Dominio);
	$("#foo11").attr('name',"dominio");
	$("#foo11").attr('placeholder',"Dominio");
	$("#selectDominio").hide();
}

function borrarEscenario()
{
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").fadeIn();
	showClass(".Foo2");
	hideFormsLess(".Foo2");
	formParametros(true, false, true, "Borrar Escenarios", "Elija los escenarios que desee borrar.", Name.Escenario);
}

function createClase()
{
	$("#alertBody").removeClass("AlertBodyBig").addClass("AlertBody"); 
	$(".AlertContainer").fadeIn();
	showClass(".Foo1");
	hideFormsLess(".Foo1");
	formParametros(false, true, true,  "Añadir Clase", "Clic en agregar para añadir clase.", Name.Clase);
	$("#foo11").attr('name',"clase");
	$("#foo11").attr('placeholder',"Clase");
	$("#selectDominio").show();
	getDominios();
}

function createAlumno()
{
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").css('display', 'inline-block');
	showClass(".Foo3");
	hideFormsLess(".Foo3");
	formParametros(true, false, true,  "Añadir Alumno", "Rellene los campos y pulse aceptar.", Name.Alumno);
}

function closeAlert()
{
	$(".AlertContainer").fadeOut();
}

function editUsuario()
{
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").fadeIn();
	showClass(".Foo4");
	hideFormsLess(".Foo4");
	formParametros(true, false, true,  "Editar Usuario", "Rellene los campos y pulse aceptar.", Name.Usuario);
}

function deleteUsuario()
{
	$("#alertBody").removeClass("AlertBodyBig").addClass("AlertBody"); 
	$(".AlertContainer").fadeIn();
	showClass(".Foo1");
	hideFormsLess(".Foo1");
	formParametros(true, false, true,  "Eliminar Usuario", "Introduzca el usuario a eliminar y pulse aceptar.", Name.BorrarUsuario);
	$("#foo11").attr('name',"borrarUsuario");
	$("#foo11").attr('placeholder',"Usuario");
	$("#selectDominio").hide();
}

function createProfesor()
{
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	$(".AlertContainer").fadeIn();
	showClass(".Foo3");
	hideFormsLess(".Foo3");
	formParametros(true, false, true,  "Añadir Docente", "Rellene los campos y pulse aceptar.", Name.Docente);
}

function grabarAlert()
{
	$("#alertBody").removeClass("AlertBodyBig").addClass("AlertBody"); 
	showClass(".Foo5");
	hideFormsLess(".Foo5");
	$(".AlertContainer").fadeIn();
	formParametros(true, false, true, "Grabar Video", "Se va a comenzar a grabar un video cuya duración no podrá superar 5 minutos", Name.Video);
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

	$.ajax({
		data: {data: data},
		url: url, 
		dataType: 'json',
		type: method,
		beforeSend: function(){
			$(id).text(befSendText);				
		},
		timeout: 3000,
		success: function(response){
			ajaxData = response;					

			$(id).text(responseText);

		},
		error: function (jqXHR,estado,error) {
			console.log(estado);
			console.log(error);
		}
	});


}

/*------------COMIENZAN LAS FUNCIONES QUE USAN AJAX PARA INTERACTUAR CON EL CONTENIDO------------*/

var dominio = $("#dominio"), clase = $('[id*=clase]'), dominioOption = $('[id*=dom]'), prevDomVal, 
working = false;

//SI SE HACE CLICK EN LOS OPTIONS DEL SELECT CON ID 'dominio' SE LLAMA A LA FUNCIÓN

dominioOption.click(getClasses); // on("change")??

//FUNCIÓN ENCARGADA DE TRAER LAS CLASES DEPENDIENDO DEL DOMINIO SELECCIONADO

function getClasses()
{	
	if ( ! working)
	{
		working   = true;
		var val   = dominio.val();	

		if (val != prevDomVal)
		{
			prevValue = val;
			if (val != "")
			{			
				var url = serverURL+'/mostrar-clases';

				createAjaxRequest(val, url, '#claseOption', 'Cargando...', 'Clase');

				setTimeout(function () {						
					clase.text("");				
					clase.append('<option id="clase" value="">Clase</option>');				

					$.each(ajaxData, function (i, value){				
						clase.append('<option id="clase'+(parseInt(i)+1)+'" value="'+value['id']+'">'+value['Nombre']+'</option>');				
					});

				}
				, 500);
			}
			else
			{
				$('#clase1').text('Clase');
			}			
		}

		working = false;
	}
}

//FUNCIÓN ENCARGADA DE TRAER LOS DOMINIOS

function getDominios()
{
	var url = serverURL+'/mostrar-dominios';

	createAjaxRequest("", url, '#selectDominio', 'Cargando...', 'Dominio');

	setTimeout(function () {

		var selectDom = $('#selectDominio');
		selectDom.text("");				

		selectDom.append('<option value="">Dominio</option>');
		$.each(ajaxData, function (i, value){				
			selectDom.append('<option id="clase'+value['id']+'" value="'+value['id']+'">'+value['Nombre']+
			'</option>');				
		});

	}
	, 500);
}

function showMenuImages(idMenu, idAlert, idForm, idInput, iFunction, uFunction, carpet)
{
	var menu = $(idMenu),
	alert    = $(idAlert);

	menu.text("");				
	alert.text("");

	$.each(ajaxData, function (i, value)
	{			
		menu.append('<article class="Article">'+
						'<img onClick="'+iFunction+'()" src="images/'+carpet+'/'+value['fullname']+'" height="80" width="80">'+
						'<p id="menuleftTitulo"></p>'+
					'</article>');				
		alert.append('<tr>'+
						'<td><img src="images/'+carpet+'/'+value['fullname']+'" height="40" width="40"></td>'+
						'<td>'+value['Nombre']+'</td>'+
						'<td><input type="Checkbox" name="checkbox[]" value="'+value['id']+'" /></td>'+
					'</tr>');
	});
	
	ajaxData.length = 0;		

	menu.append('<article class="AddArticle">'+
						'<img class="AddArticle-Image" src="images/addEscenario.png" height="80" width="80">'+
						'<form method="POST" id="'+idForm+'" enctype="multipart/form-data">'+
							'<input type="file" id="'+idInput+'" name="'+idInput+'" onChange="'+uFunction+'()"'+
							'style="width: 160px;"'+
						'</form>'+
				'</article>');
}

var getEndDir = 
{
	Escenarios: '/mostrar-escenarios',
 	Elementos:  '/mostrar-elementos'
}

function getMenuImages(endDir)
{
	var url = serverURL + endDir;	

	createAjaxRequest("", url, '', '', '');	

	setTimeout(function () 
	{
		if (endDir === getEndDir.Escenarios)
		{
			showMenuImages('#MAC1', '#contentEscenarios', 'fileForm1', 'escenario', 'insertImageToCanvas', 
					       'uploadEscenario', 'Escenarios');
		}
		else if (endDir === getEndDir.Elementos)
		{
			showMenuImages('#MAC2', '#contentElementos', 'fileForm2', 'elemento', 'insertImageToCanvas', 
						   'uploadElemento', 'Elementos');
		}
	}, 500);
}

window.onload = function () 
				{
					getMenuImages(getEndDir.Escenarios); 
					setTimeout(function () 
					{
						getMenuImages(getEndDir.Elementos)
					}, 500);
				}

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
	var file = $(id)[0],
	url = serverURL + '/subir/archivo';

	file = file.files[0];

	var data = new FormData();

	data.append(name, file);
	data.append('clase', $('#clase').val());

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
		}
	});
}

/*-------------------------- TERMINAN FUNCIONES PARA SUBIR ARCHIVOS ---------------------------------------*/

/*------------TERMINAN LAS FUNCIONES QUE USAN AJAX PARA INTERACTUAR CON EL CONTENIDO-----------*/


/*------------ FUNCIÓN DRAG AND DROP-----------------------------------------------------------*/
(function($) {
    $.fn.drags = function(opt) {

        opt = $.extend({handle:"",cursor:"move"}, opt);

        if(opt.handle === "") {
            var $el = this;
        } else {
            var $el = this.find(opt.handle);
        }

        return $el.css('cursor', opt.cursor).on("mousedown", function(e) {
            if(opt.handle === "") {
                var $drag = $(this).addClass('draggable');
            } else {
                var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
            }
            var z_idx = $drag.css('z-index'),
                drg_h = $drag.outerHeight(),
                drg_w = $drag.outerWidth(),
                pos_y = $drag.offset().top + drg_h - e.pageY,
                pos_x = $drag.offset().left + drg_w - e.pageX;
            $drag.css('z-index', 1000).parents().on("mousemove", function(e) {
                $('.draggable').offset({
                    top:e.pageY + pos_y - drg_h,
                    left:e.pageX + pos_x - drg_w
                }).on("mouseup", function() {
                    $(this).removeClass('draggable').css('z-index', z_idx);
                });
            });
            e.preventDefault();
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $(this).removeClass('draggable');
            } else {
                $(this).removeClass('active-handle').parent().removeClass('draggable');
            }
        });

    }
})(jQuery);

/*-------------------------- TERMINA FUNCIÓN DRAG AND DROP ---------------------------------------*/

function dibujoManoAlzada(){
	var p = $('#botonDibujo').position();
	$(".ColorPickerContainer").css('left', p.left);
	$(".ColorPickerContainer").css('top', p.top);
	$(".ColorPickerContainer").toggle();
	$("#closeButton2").on("click",ocultarColorPicker);
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
}

$('.ColorPickerContainer').drags();