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
	GuardarGrabacion: 'guardarGrabacion'
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
	$("#edicionHerramientas, #usuariosHerramientas, #administracionHerramientas").hide();
}

$("#edicion").on('click',Edicion);

function Edicion(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-ItemSelected');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas, #usuariosHerramientas, #administracionHerramientas").hide();
	$("#edicionHerramientas").show();
}

$("#usuarios").on('click',Usuarios);

function Usuarios(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-ItemSelected');
	changeClass('#administracion', 'Menu-Item');

	$("#presentacionHerramientas, #edicionHerramientas, #administracionHerramientas").hide();
	$("#usuariosHerramientas").show();
}

$("#administracion").on('click',Administracion);

function Administracion(){
	changeClass('#presentacion', 'Menu-Item');
	changeClass('#edicion', 'Menu-Item');
	changeClass('#usuarios', 'Menu-Item');
	changeClass('#administracion', 'Menu-ItemSelected');
	
	$("#presentacionHerramientas, #edicionHerramientas, #usuariosHerramientas").hide();
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
			$(".Foo2,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7").hide();
		break;
		case ".Foo2":
			$(".Foo1,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7").hide();
		break;
		case ".Foo3":
			$(".Foo1,.Foo2,.Foo4,.Foo5,.Foo6,.Foo7").hide();
		break;
		case ".Foo4":
			$(".Foo1,.Foo2,.Foo3,.Foo5,.Foo6,.Foo7").hide();
		break;
		case ".Foo5":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo6,.Foo7").hide();
		break;
		case ".Foo6":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo7").hide();
		break;
		case ".Foo7":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo6").hide();
		break;
		case "":
			$(".Foo1,.Foo2,.Foo3,.Foo4,.Foo5,.Foo6,.Foo7").hide();
		break;
	}
}

function showClass(clase)
{
	$(clase).css('display', 'inline-block');
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
	formParametros(true, false, true,  "Añadir Alumno", "Rellene los campos y pulse aceptar.", Name.Alumno);
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
						'<img onClick="'+iFunction+'()" src="images/'+carpet+'/'+value['fullname']+'" height="80" width="80">'+
						'<p id="menuleftTitulo"></p>'+
					'</article>');				
		alert.append('<tr>'+
						'<td><img src="images/'+carpet+'/'+value['fullname']+'" height="40" width="40"></td>'+
						'<td>'+value['Nombre']+'</td>'+
						'<td><input type="Checkbox" name="checkbox[]" onchange="comprobarCheck()" class="ContentCheck" value="'+value['id']+'" /></td>'+
					'</tr>');
	});
	
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
				 'email', 'borndate', 'obs', 'password', 'password_confirmation', 'roles'], 
	id   = ['firstname1', 'lastname1', 'username1', 'nif1', 'adress1', 'locality1', 'province1', 'cp1', 'phone1', 
		    'email1', 'borndate1', 'obs1', 'password1', 'password_confirmation1', 'roles1'];

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

//$('.ColorPickerContainer h4').on('mouseover', moverMenu);
//$('.ColorPickerContainer h4').on('mouseleft', noMoverMenu);

//function moverMenu(){
//	$('.ColorPickerContainer').drags();
//}

//function noMoverMenu(){
//	$('.ColorPickerContainer').nodrags();
//}