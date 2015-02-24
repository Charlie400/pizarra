var pacience = 0,
testObject   = [];
//Esta función muestra los formularios para los tests.
function crearTest(){
	var ajax = new AjaxManager();

	var data = ajax.constructData(['tituloTest', 'claseTest', 'categoryTest', 'multirespuesta',
								   'preguntas', 'respuestas', 'calificacionTest1'], ['titulo', 'id_clase', 
								   'id_category', 'multirespuesta', 'preguntas', 'respuestas', 'puntuacion']);

	if (document.getElementById('monorespuesta').checked) data['multirespuesta'] = 0;
	else if (document.getElementById('multirespuesta').checked) data['multirespuesta'] = 1;

	typeTest(data['id_category'] == '2', data['multirespuesta'], function(id){

		data['categoryTest'] = id;

		ajax.request({
			data: data,
			url: '/crear/test',
			responseType: 'json',
			success: function(test){

				console.log(test);

				if (testObject.length > 0)
				{
					var self = this;
					console.log("Variable ajaxData ocupada, proceso en cola");
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
						insertPregResContent(testObject);
						$("#liTest1Content1").css("display","none");
						$("#liTest1Content2").css("display","block");
						var tipoTest = $('input[name=TipoRespuesta]:checked').val();
						if (tipoTest === "0"){
							$(".MultiRespuestaTest").css("display","none")
							$(".MonoRespuestaTest").css("display","initial")
						}else if (tipoTest === "1"){
							$(".MultiRespuestaTest").css("display","initial")
							$(".MonoRespuestaTest").css("display","none")
						};
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

function insertPregResContent(object)
{
	var content  = $("#preguntasContainer");

	object.preguntas  = parseInt(object.preguntas);
	object.respuestas = parseInt(object.respuestas);

	for (var i = 1; i <= object.preguntas; i++)
	{
		console.log(i);
		content.append('<table id="preguntasContainerTable">'+
					'<td><h3>Pregunta ' + i + '</h3></td>'+
					'<tr>'+
						'<th><textarea id="pregunta' + i + '" placeholder="<<Escriba su pregunta aquí>>"></textarea></th>'+
						'<th class="DeleteButtonTable"><input class="DeleteButton" type="submit" value="Eliminar"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../images/SubirLocal.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../images/Iconovideo.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../images/Iconoimagen.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../images/IconoEscenario.png"></th>'+
						'<th class="IconTh"><img class="TestIcon" src="../images/IconoElemento.png"></th>'+
					'</tr>'+
					'</table>');

		for (var a = 1; a <= object.respuestas; a++)
		{
			content.append('<table id="respuestasContainer">'+
						'<tr class="RespuestaTable">'+
							'<th><input id="checkbox' + i + a + '" class="MultiRespuestaTest" type="checkbox" value="0"></th>'+
							'<th><input id="radio' + i + a + '" class="MonoRespuestaTest" name="SeleccionarRespuesta" type="radio" '+
							'value="0"></th>'+
							'<th></th>'+
							'<th><textarea id="respuesta' + i + a + '" placeholder="<<Escriba su respuesta aquí>>"></textarea></th>'+
							'<th class="TestValue"><input placeholder="Valor" type="number"></th>'+
							'<th class="DeleteButtonTable"><input class="DeleteButton" type="submit" value="Eliminar"></th>'+
							'<th class="IconTh"><img class="TestIcon" src="../images/SubirLocal.png"></th>'+
							'<th class="IconTh"><img class="TestIcon" src="../images/Iconovideo.png"></th>'+
							'<th class="IconTh"><img class="TestIcon" src="../images/Iconoimagen.png"></th>'+
							'<th class="IconTh"><img class="TestIcon" src="../images/IconoEscenario.png"></th>'+
							'<th class="IconTh"><img class="TestIcon" src="../images/IconoElemento.png"></th>'+
						'</tr>'+
					'</table>');
		}
	}

	content.append('<div class="TestButtonsContainer">'+
						'<input type="submit" class="OkButton Button TestButton" value="Finalizar Test">'+
						'<div class="BackButton Button TestButton" onClick="volverTest()">Volver Configuración Test</div>'+
						'<input type="submit" class="CancelButton Button TestButton" onClick="closeAlert()" value="Cancelar">'+
					'</div>');
}