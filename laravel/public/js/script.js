;
var Action = {
    Hide: 0,
    Show: 1
}
ButtonState = {
    NoActive: 0,
    Active: 1
},
Elemento = {
    TextBox: 0,
    OnlyText: 1,
	ListBox: 2
},
Name = {
	Dominio: 'dominio',
	Escenario: 'borrarEscenario',
	Clase: 'clase',
	Alumno: 'alumno',
	Usuarios: 'usuarios'
},
serverURL = location.protocol+'//'+location.hostname+'/laravel/public';

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

$("#presentacionHerramientas").hide();
$("#edicionHerramientas").hide();
$("#usuariosHerramientas").hide();
$("#administracionHerramientas").hide();

$("#presentacion").on('click',Presentacion);

function Presentacion(){
	$("#presentacion").removeClass();
	$("#edicion").removeClass();
	$("#usuarios").removeClass();
	$("#administracion").removeClass();
	$("#presentacion").addClass('Menu-ItemSelected');
	$("#edicion").addClass('Menu-Item');
	$("#usuarios").addClass('Menu-Item');
	$("#administracion").addClass('Menu-Item');

	$("#presentacionHerramientas").show();
	$("#edicionHerramientas").hide();
	$("#usuariosHerramientas").hide();
	$("#administracionHerramientas").hide();
}

$("#edicion").on('click',Edicion);

function Edicion(){
	$("#presentacion").removeClass();
	$("#edicion").removeClass();
	$("#usuarios").removeClass();
	$("#administracion").removeClass();
	$("#presentacion").addClass('Menu-Item');
	$("#edicion").addClass('Menu-ItemSelected');
	$("#usuarios").addClass('Menu-Item');
	$("#administracion").addClass('Menu-Item');

	$("#presentacionHerramientas").hide();
	$("#edicionHerramientas").show();
	$("#usuariosHerramientas").hide();
	$("#administracionHerramientas").hide();
}

$("#usuarios").on('click',Usuarios);

function Usuarios(){
	$("#presentacion").removeClass();
	$("#edicion").removeClass();
	$("#usuarios").removeClass();
	$("#administracion").removeClass();
	$("#presentacion").addClass('Menu-Item');
	$("#edicion").addClass('Menu-Item');
	$("#usuarios").addClass('Menu-ItemSelected');
	$("#administracion").addClass('Menu-Item');

	$("#presentacionHerramientas").hide();
	$("#edicionHerramientas").hide();
	$("#usuariosHerramientas").show();
	$("#administracionHerramientas").hide();
}

$("#administracion").on('click',Administracion);

function Administracion(){
	$("#presentacion").removeClass();
	$("#edicion").removeClass();
	$("#usuarios").removeClass();
	$("#administracion").removeClass();
	$("#presentacion").addClass('Menu-Item');
	$("#edicion").addClass('Menu-Item');
	$("#usuarios").addClass('Menu-Item');
	$("#administracion").addClass('Menu-ItemSelected');
	
	$("#presentacionHerramientas").hide();
	$("#edicionHerramientas").hide();
	$("#usuariosHerramientas").hide();
	$("#administracionHerramientas").show();
}


if ($("#dominio").val() == 0){
	$("#clase").prop("disabled", true)
	$("#clase").attr('class', 'ComboBoxDisabled');
}else{
	$("#clase").prop("disabled", false);
	$("#clase").attr('class', 'ComboBoxClase');
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

function createDominio()
{
	ShowHideAlert(Action.Show, false, true, true, Elemento.TextBox, "Añadir Dominio", 
	"Clic en agregar para añadir dominio.", Name.Dominio);
}

function borrarEscenario()
{
	ShowHideAlert(Action.Show, true, false, true, Elemento.ListBox, "Borrar Escenarios", 
	"Elija los escenarios que desee borrar.", Name.Escenario);
}

function createClase()
{
	ShowHideAlert(Action.Show, false, true, true, Elemento.TextBox, "Añadir Clase", 
	"Clic en agregar para añadir clase.", Name.Clase);
}

function createAlumno()
{
	ShowHideAlert(Action.Show, false, true, true, Elemento.TextBox, "Añadir Alumno", 
	"Clic en agregar para añadir alumno.", Name.Alumno);
}

function closeAlert()
{
	ShowHideAlert(Action.Hide);
}

function editUsuario()
{
	ShowHideAlert(Action.Show, true, false, true, Elemento.OnlyText, "Editar Usuario", 
	"Rellene los campos y pulse aceptar.", Name.Usuarios);
}

// $("#botonAlumnos").on("click",ShowHideAlert(Action.Show, true, false, true, Elemento.OnlyText, "Esto es una prueba", "Por favor, indique un nombre válido para el elemento"));

//En la variable n se pasará un nombre para el input dado que es necesario para enviar el formulario.
function ShowHideAlert(pAction, pOkButton, pAddButton, pCancelButton, pElemento, pTitulo, pCuerpo, n){

	if (pAction == Action.Show){
		$('.AlertContent').empty();
		$(".AlertTittleContainer h4").empty();

		if(pElemento == Elemento.TextBox)
		{
			if (n != Name.Escenario)
			{
				$('.AlertContent').append(pCuerpo + '<input type="text" name="'+n+'" />');			

				if (n == 'clase')
				{
					//Añadimos un select a clase para poder elegir a que dominio pertenecerá
					$('.AlertContent').append('<select id="selectDominio" name="dominioVal" class="ComboBoxDominio"></select>');
					getDominios();
				}
				
			}
			else
			{
				$('.AlertContent').append(pCuerpo);				
		}			

		}else if(pElemento == Elemento.OnlyText){
			$('.AlertContent').append(pCuerpo);
				if (n == 'usuarios')
				{
					$('.AlertContent').append("</br><input type='text' placeholder='Nombre'/></br><input type='text' placeholder='Apellidos'/></br><input type='text' placeholder='Usuario'/></br><input type='tel' placeholder='Telefono'/></br><input type='email' placeholder='Email'/></br><input type='password' placeholder='Contraseña'/></br><input type='password' placeholder='Repite Contraseña'/>");
				}
		}else if(pElemento == Elemento.ListBox){
			if (n == Name.Escenario) {
				$('.AlertContent').append(pCuerpo + "<form class='EscenariosAlert'><input type='checkbox' name='escenario'/></br></form>");
			}
			else
			{
			$('.AlertContent').append("");
			}
		}

		$(".AlertTittleContainer h4").append(pTitulo);

		ShowHideButtons(pOkButton, pAddButton, pCancelButton);
		$('.AlertContainer').fadeIn();


	}
	else
	{ /*Al solo haber dos opciones (Hide y Show) es preferible añadir un else a un else if dado que te ahorras 
	la comprobación.*/
		$('.AlertContainer').fadeOut();
	}

}

// $('#closeButton').on('click', ShowHideAlert(Action.Hide));

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
var ajaxData;

function createAjaxRequest(data, url, id, befSendText, responseText)
{
	$.ajax({
		data: {data: data},
		url: url, 
		dataType: 'json',
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
						clase.append('<option id="clase'+(parseInt(i)+1)+'" value="'+value['Nombre']+'">'+value['Nombre']+'</option>');				
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

		$.each(ajaxData, function (i, value){				
			selectDom.append('<option id="clase'+value['id']+'" value="'+value['id']+'">'+value['Nombre']+
			'</option>');				
		});

	}
	, 500);
}

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
	if ($(".ColorPickerContainer").is(":visible")){
		$('#botonDibujo').attr('value','Click aquí para cerrar');
		$('#botonDibujo').css('background-color','#E74C3C');
	}else{
		$('#botonDibujo').attr('value','Dibujo a mano alzada');
		$('#botonDibujo').css('background-color','#3498DB');
	}	
}

$('.ColorPickerContainer').drags();

