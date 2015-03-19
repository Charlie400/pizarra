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
								   'preguntas', 'respuestas', 'calificacionTest'], ['titulo', 'id_clase', 
								   'id_category', 'multirespuesta', 'preguntas', 'respuestas', 'puntuacion']);

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
					console.log('Esto es:'+testObject.errors);
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
	var content  = $("#preguntasContainer"),
	mono  = responseType == 'mono',
	multi = responseType == 'multi';

	object.preguntas  = parseInt(object.preguntas);
	object.respuestas = parseInt(object.respuestas);

	for (var i = 1; i <= object.preguntas; i++)
	{	
		content.append('<table id="preguntasContainerTable">'+
					'<td><h3>Pregunta ' + i + '</h3></td>'+
					'<tr>'+
						'<th><textarea id="pregunta' + i + '" class="pregunta' + i + '" placeholder="<<Escriba su pregunta aquí>>"></textarea></th>'+
						'<th class="DeleteButtonTable"><input class="DeleteButton" type="submit" value="Eliminar"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/SubirLocal.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/Iconovideo.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/Iconoimagen.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/IconoEscenario.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../../images/IconoElemento.png"></th>'+
					'</tr>'+
					'</table>');

		for (var a = 1; a <= object.respuestas; a++)
		{
			if (mono)
			{
				var id = 'formres' + i;
				content.append('<form id="' + id + '"></form>');
				$('#' + id).append('<table id="respuestasContainer">'+
							'<tr class="RespuestaTable">'+								
								'<th><input id="checkradio' + i + a + '" class="MonoRespuestaTest pregunta' + i + ' checkradio' + i + ' checkradio" onChange="changeValue(this.id,' + i + ')" name="SeleccionarRespuesta" type="radio" '+
								'value="0"></th>'+
								'<th></th>'+
								'<th><textarea id="respuesta' + i + a + '" class="pregunta' + i + '" placeholder="<<Escriba su respuesta aquí>>"></textarea></th>'+
								'<th class="TestValue"><input placeholder="Valor" type="number"></th>'+
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
				content.append('<table id="respuestasContainer">'+
							'<tr class="RespuestaTable">'+
								'<th><input id="checkradio' + i + a + '" class="MultiRespuestaTest pregunta' + i + ' checkradio' + i + ' checkradio" onChange="changeValue(this.id,' + i + ',' + true + ')" type="checkbox" value="0"></th>'+
								'<th></th>'+
								'<th><textarea id="respuesta' + i + a + '" placeholder="<<Escriba su respuesta aquí>>"></textarea></th>'+
								'<th class="TestValue"><input placeholder="Valor" type="number"></th>'+
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

	content.append('<div class="TestButtonsContainer">'+
						'<div type="submit" onClick=crearPregRes() class="OkButton Button TestButton">Finalizar Test</div>'+
						'<div class="BackButton Button TestButton" onClick="volverTest()">Volver Configuración Test</div>'+
						'<input type="submit" class="CancelButton Button TestButton" onClick="closeAlert()" value="Cancelar">'+
					'</div>');
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
		respuestas = ajax.constructData(ids.respuestas);

	console.log(preguntas);

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
						var ajax = new AjaxManager();

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