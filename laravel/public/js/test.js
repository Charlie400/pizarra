;//Esta función añade un cuadro de texto para agregar clase a un test.
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

function modificarTest()
{
	// Borramos el contenido html del tbody
	cleanInnerHTML('tbodySendAsignacion');

	var clase = ".Foo9";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase); 
	$(".td1").show();
	$(".td2").hide();
	$(".td3").show();
	$(".ComboBoxAsignadas").hide();
	$(".ContentOverflow").show();
	$(".AlertContainer").fadeIn();
	formParametros(false,true,true,"Modificar Test","Seleccione test a modificar y pulse aceptar para eliminar", Name.ModificarTest);
}
function eliminarTest()
{
	// Borramos el contenido html del tbody
	cleanInnerHTML('tbodySendAsignacion');
	
	var clase = ".Foo9";
	$("#alertBody").removeClass("AlertBody").addClass("AlertBodyBig"); 
	showClass(clase);
	hideFormsLess(clase);
	$(".td1").show();
	$(".td2").hide();
	$(".td3").show();
	$(".ComboBoxAsignadas").hide();
	$(".ContentOverflow").show();
	$(".AlertContainer").fadeIn();
	formParametros(true,false,true,"Modificar Test","Seleccione test a modificar y pulse aceptar para eliminar", Name.ModificarTest);
}

var pacience = 0,
testObject   = [];
//Esta función muestra los formularios para los tests.
function crearTest(){
	$(".contentTest ul").css("display","none");
	var ajax = new AjaxManager();

	var data = ajax.constructData(['tituloTest', 'claseTest1', 'categoryTest', 'multirespuesta',
								   'preguntas', 'respuestas', 'calificacionTest', 'idDominioConfigTest'], ['titulo', 'id_clase', 
								   'id_category', 'multirespuesta', 'preguntas', 'respuestas', 'puntuacion', 'id_dominio']);

	if (document.getElementById('monorespuesta').checked) data['multirespuesta'] = 0;
	else if (document.getElementById('multirespuesta').checked) data['multirespuesta'] = 1;

	typeTest(data['id_category'] == '2', data['multirespuesta'], function(id){

		data['id_category'] = id;

		ajax.request({
			data: data,
			url: '/crear/test',
			responseType: 'json',
			success: function(test){

				console.log(test);

				if (testObject.length > 0)
				{
					var self = this;
					console.log("Variable ocupada, proceso en cola");
					setTimeout(function(){
						++pacience;						

						if (pacience > 3) 
						{
							testObject = [];
							pacience = 0;
						}

						self.success(test);					
					}, 500);
				}
				else
				{

					testObject = test;

					if ( ! testObject.errors)
					{						
						$("#liTest1Content1").css("display","none");
						$("#liTest1Content2").css("display","block");

						var tipoTest = testObject.id_category;

						if (tipoTest === "1" || tipoTest === "2"){
							insertPregResContent(testObject, 'mono');
							$(".MultiRespuestaTest").css("display","none")
							$(".MonoRespuestaTest").css("display","initial")
						}else if (tipoTest === "3"){
							insertPregResContent(testObject, 'multi');
							$(".MultiRespuestaTest").css("display","initial")
							$(".MonoRespuestaTest").css("display","none")
						};
					}
					else
					{
						console.log(testObject);
					}
				}

			},
			errors: function(err)
			{
				console.log("error: " + err);
			}
		});
	});	
}

function insertPregResContent(object, responseType)
{
	// Apuntamos al elemento que contendrá las preguntas
	var content  = $("#preguntasContainer"),
	// Evaluamos si es mono o multirespuesta la pregunta
	mono  = responseType == 'mono',
	multi = responseType == 'multi';

	// Nos aseguramos de que las preguntas sean tratadas como enteros.
	object.preguntas  = parseInt(object.preguntas);
	object.respuestas = parseInt(object.respuestas);

	// Dos ciclos para mostrar los campos de preguntas y respuestas en base a la cantidad indicada por el object.
	for (var i = 1; i <= object.preguntas; i++)
	{	
		// Añadimos el código HTML con un campo para cada pregunta, uno por vuelta del ciclo.
		content.append('<table id="preguntasContainerTable">'+
					'<td><h3>Pregunta ' + i + '</h3></td>'+
					'<tr>'+
						'<th><textarea id="pregunta' + i + '" class="pregunta' + i + '" placeholder="<<Escriba su pregunta aquí>>"></textarea></th>'+
						'<th><span id="pregunta' + i + 'Error" class="CU_errors pregResSpansForErrors"></span></th>'+
						'<th class="DeleteButtonTable"><input class="DeleteButton" type="submit" value="Eliminar"></th>'+
						'<th class="TestValue"><input class="TestPregValue" placeholder="Valor" type="number"></th>'+
						'<th><span id="pregunta' + i + 'valorError" class="CU_errors pregResSpansForErrors"></span></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/SubirLocal.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/Iconovideo.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/Iconoimagen.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/IconoEscenario.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/IconoElemento.png"></th>'+
					'</tr>'+
					'</table>');

		for (var a = 1; a <= object.respuestas; a++)
		{
			// Verificamos si es mono o multirespuesta para cargar el HTML adecuado.
			if (mono)
			{
				// Aquí entramos si es una pregunta monorespuesta, aquí usaremos radios.

				/* 
				*	Construimos la id del formulario que contendrá de forma interesada los radios y checkboxs
				*	cada pregunta contendrá todos sus radios en un formulario, para evitar que los radios
				*	se mezclen con los de otras preguntas destruyendo la experiencia visual.
				*/
				var id = 'formres' + i;

				// Añadimos el código HTML con un campo para cada respuesta, uno por vuelta del ciclo.
				content.append('<form id="' + id + '"></form>');
				$('#' + id).append('<table id="respuestasContainer">'+
							'<tr class="RespuestaTable">'+								
								'<th><input id="checkradio' + i + a + '" class="MonoRespuestaTest pregunta' + i + ' checkradio' + i + ' checkradio" onChange="changeValue(this.id,' + i + ')" name="SeleccionarRespuesta" type="radio" '+
								'value="0"></th>'+
								'<th></th>'+
								'<th><textarea id="respuesta' + i + a + '" class="pregunta' + i + '" placeholder="<<Escriba su respuesta aquí>>"></textarea></th>'+								
								'<th><span id="respuesta' + i + a + 'Error" class="CU_errors pregResSpansForErrors"></span></th>'+
								'<th class="DeleteButtonTable"><input class="DeleteButton" type="submit" value="Eliminar"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/SubirLocal.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/Iconovideo.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/Iconoimagen.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/IconoEscenario.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/IconoElemento.png"></th>'+
							'</tr>'+
						'</table>');
			}
			else if (multi)
			{
				// Aquí entramos si es una pregunta multirespuesta, aquí usaremos checkboxs.

				// Añadimos el código HTML con un campo para cada respuesta, uno por vuelta del ciclo.
				content.append('<table id="respuestasContainer">'+
							'<tr class="RespuestaTable">'+
								'<th><input id="checkradio' + i + a + '" class="MultiRespuestaTest pregunta' + i + ' checkradio' + i + ' checkradio" onChange="changeValue(this.id,' + i + ',' + true + ')" type="checkbox" value="0"></th>'+
								'<th></th>'+
								'<th><textarea id="respuesta' + i + a + '" placeholder="<<Escriba su respuesta aquí>>"></textarea></th>'+
								'<th><span id="respuesta' + i + a + 'Error" class="CU_errors pregResSpansForErrors"></span></th>'+
								'<th class="DeleteButtonTable"><input class="DeleteButton" type="submit" value="Eliminar"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/SubirLocal.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/Iconovideo.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/Iconoimagen.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/IconoEscenario.png"></th>'+
								'<th class="IconTh"><img class="TestIcon" src="../../images/IconoElemento.png"></th>'+
							'</tr>'+
						'</table>');
			}
		}
	}

	// Finalmente añadimos los botones.
	
	content.append('<span id="generalTestError" class="CU_errors pregResSpansForErrors"></span>'+
					'<div class="TestButtonsContainer" class="CU_errors pregResSpansForErrors">'+
						'<div type="submit" onClick=crearPregRes() class="OkButton Button TestButton">Finalizar Test</div>'+
						'<div class="BackButton Button TestButton" onClick="volverTest()">Volver Configuración Test</div>'+
						'<input type="submit" class="CancelButton Button TestButton" onClick="closeAlert()" value="Cancelar">'+
					'</div>');
}

function checkPregRes(preguntas, respuestas)
{
	// Número de preguntas
	var pregCount  = testObject.preguntas,
	//Número de respuestas
		resCount   = testObject.respuestas,
		// Cantidad de puntos a repartir
		puntuacion = testObject.puntuacion,
		// Objeto que almacenará los errores
		errors	   = {
			preguntas: {},
			respuestas: {},
			active: false
		},
		pregunta, preguntaId, pregValueId, valor, 
		// Esta variable contendrá sumada la puntuación que ha asignado el usuario a cada pregunta.
		totalPuntosAsignados = 0,		
		emptyPregValue;

	for (var i = 1; i <= pregCount; i++)
	{	
		// Construimos la claves del objeto que contiene las preguntas
			// Esta primera es para las preguntas
		preguntaId  = 'pregunta' + i;		
			// Esta otra para los valores de las preguntas
		pregValueId = preguntaId + 'valor';

		// Aquí recuperamos la pregunta actual en base a las claves anteriores
		pregunta = preguntas[preguntaId];

		// Preguntas es un string y no está vacía.

		if ( isEmpty(pregunta) || ! isString(pregunta) )
		{
			errors.preguntas[preguntaId] = "El campo pregunta no puede estar vacío";
			errors.active = true;
		}

		// Almacenamos la puntuación de la pregunta actual
		valor = preguntas[pregValueId];
		console.log(valor);

		// Comprobamos que la puntuación no esté vacía y que sea de tipo numérico
		if ( isEmpty(valor) )
		{						
			// Aquí entramos si la puntuación está vacía
			errors.preguntas[pregValueId] = "El campo valor no puede estar vacío y tiene que ser un número";
			errors.active = true;			
		}
		else
		{
			// Aquí entramos si estamos recibiendo el tipo de datos que queremos

				// Esta variable contendrá sumada la puntuación que ha asignado el usuario a cada pregunta.
			totalPuntosAsignados += parseInt(valor);			
		}
	}

	// Comprobamos si los puntos asignados por el usuario coinciden con los que permite el test

	if ( totalPuntosAsignados != puntuacion )
	{
		errors.preguntas.puntuacion = "Los valores de las preguntas no pueden sumar más ni menos que la " +  
		"puntuación seleccionada al crear test (" + puntuacion + ")";

		errors.active = true;
	}

	// Obtenemos los valores de los checks o radios del tests.
		// La variable counter la usaremos para recorrer el array checkradios.
		// La variable checkRadioActives irá almacenando el número de checks o radios checkeados.
	var checkradios = getClassValues('checkradio'), counter = 0,
	// Si ya hay un error en selección de checks o radios esta variable la usaremos para no revisar más esa parte.
		hasErrorsCheckRadio = false, actualQuestionCheckRadios = [];

	// Buscamos errores en las respuestas.
	for (var i in respuestas)
	{
		// Comprobamos si ya hay algún error, de no ser así continuamos.		
		if ( ! hasErrorsCheckRadio )
		{	
			// Aquí entramos si no hay ningún error aún en la selección de checks o radios.

			// Almacenamos los valores de los checks o radios de la pregunta actual
			actualQuestionCheckRadios.push(parseInt(checkradios[counter++]));

			/*
			*	Comprobamos si counter entre el número de respuestas por pregunta tiene como residuo 0
			*	dado que cuando esto ocurre significa que hemos revisado una pregunta completa.
			*/

			if ( counter%resCount === 0 )
			{
				/*
				*	Comprobamos si hay algún check o radio activo buscando el valor 1 en el array
				* 	"actualQuestionCheckRadios", si no lo hay, se generará un error.
				*/
				if ( findValue(actualQuestionCheckRadios, 1) === -1 )
				{
					// Aquí entramos en caso de error.

					errors.respuestas.generalTest = 'Debes seleccionar al menos una respuesta como correcta '+
					'en cada pregunta';
					hasErrorsCheckRadio = true;
					
					errors.active = true;
				}
				else
				{
					// Aquí entramos en caso de éxito.

					// Vaciamos el array, así no se mezclarán los valores nuevos con los de la pregunta anterior.
					actualQuestionCheckRadios = [];
				}
			}
		}

		// Respuestas es un string y no están vacías.
		if ( isEmpty(respuestas[i]) || ! isString(respuestas[i]))
		{
			errors.respuestas[i] = "El campo respuesta no puede estar vacío";
			errors.active = true;
		}		
	}

	console.log(errors);

	if (errors.active)
	{
		// Aquí entramos si hay algún error.

		//	Mostramos los errores y retornamos false.
		showPregResErrors(errors);
		return false;		
	}

	console.log('SIN ERRORES');
	// Aquí llegamos si no hay ningún error
	return true; 
}

// Muestra los errores de las preguntas y respuestas al usuario.
function showPregResErrors(errors)
{
	// Conseguimos las claves de los errores para componer la id de los campos que los contendrán.
	var preguntaIds  = getKeys(errors.preguntas), 
		respuestaIds = getKeys(errors.respuestas), 
		pregId, resId, i;

	// Limpiamos los campos contenedores de los errores.
	cleanClassInnerHTML('pregResSpansForErrors');

	for (i in preguntaIds)
	{		
		// En cada vuelta mostramos un error en las preguntas, ya sea en el texto o en la puntuación.
		pregId = preguntaIds[i];

		if ( pregId != 'puntuacion' ) setInnerHTML(pregId + 'Error', errors.preguntas[pregId]);

		for (i in respuestaIds)
		{
			// En cada vuelta mostramos un error en las respuestas.
			resId = respuestaIds[i];

			setInnerHTML(resId + 'Error', errors.respuestas[resId]);
		}
	}
}

// Envía los datos de preguntas y respuestas al servidor para su validación e inserción.
function crearPregRes()
{
	// En base al número de preguntas y respuestas debe darme las ids que por lógica le fueron asignadas.
	var ids  = getPregResIds(testObject.respuestas, testObject.preguntas),
	// Instanciamos el objeto AjaxManager.
		ajax = new AjaxManager(),
		data = {};

	// Obtenemos los datos de las preguntas y respuestas.
	var preguntas  = ajax.constructData(ids.preguntas),
		respuestas = ajax.constructData(ids.respuestas),
		// Valor asignado a las preguntas
		values 	   = getClassValues('TestPregValue'),
		counter	   = 0,
		temp;

		// Obtenemos el valor que se le da a cada pregunta y lo asignamos
		for (var i in preguntas)
		{
			// Asociamos las preguntas con su valor creando una propiedad con la id de la pregunta y 'valor' al final.
			preguntas[i + 'valor'] = values[counter];
			counter++;
		}	

	if ( checkPregRes(preguntas, respuestas) )
	{
		// Petición ajax para enviar las preguntas.
		ajax.request({
						data: preguntas,
						method: 'POST',
						url: '/crear/preguntas/' + testObject.id,
						processData: false,
						responseType: 'json',
						success: function(response){
							console.log(response);
							// Instanciamos el objeto AjaxManager.
							ajax = new AjaxManager();

							// Obtenemos los valores de los checks o los radios para saber cuales están activos.
							respuestas.checkradio = getClassValues('checkradio');

							// Petición ajax para enviar las respuestas.
							ajax.request({
											data: respuestas,
											method: 'POST',
											url: '/crear/respuestas/' + testObject.id,
											processData: false,
											responseType: 'json',
											success: function(response){
												console.log(response);
											},
											errors: function(err)
											{
												console.log("Aquí tienes el error: " + err);
											}
										});
						},
						errors: function(err)
						{
							console.log("Aquí tienes el error: " + err);
						}
					});	
	}
}