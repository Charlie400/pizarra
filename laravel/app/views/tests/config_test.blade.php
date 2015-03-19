<html>
<head>	
	<meta charset="UTF-8"/>
	<title>Nuevo Test</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ asset ('/css/normalize.css') }}">
	<link href='http://fonts.googleapis.com/css?family=Roboto:500,300,700,400' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="{{ asset ('/js/jquery-1.11.1.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('/js/utils.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset ('/css/style.css') }}">
</head>
<body class="BodyTest">
	{{-- Aquí almacenamos el id_dominio --}}
	<input type="hidden" id="idDominioConfigTest" value="{{ $id_dominio }}" />

	<div class="TituloTest">
		<h1>Generación de Tests</h1>
	</div>
	<div class="AlertTestContent">
		<div class="AlertTestContain">
			<p>¡Test creado con éxito!</p>
			<div class="OkButton Button TestButton">Aceptar</div>
		</div>
	</div>
	<div class="ContentTest">
		<ul>
			<li id="liTest1" Class="ItemTest">Generación Manual</li>
			<li id="liTest2" Class="ItemTest">Generación Automática Test de Repaso Preguntas Falladas por alumno</li>
			<li id="liTest3" Class="ItemTest">Generación Automática Test de Repaso Preguntas Falladas en general</li>
			<li id="liTest4" Class="ItemTest">Generación Automática Test Temático</li>
			<li id="liTest5" Class="ItemTest">Generación Automática Test General</li>
		</ul>
		<div id="liTest1Content">
			<div id="liTest1Content1">
				<div id="marcadorTestContainer">
					<p>Test Nº</p>
					<div id="marcadorTest">
						<p>1</p>
					</div>
				</div>
				<form>
					<ul>
						<li><label>Título</label><input id="tituloTest" type="text"></li>
						<li><label>Clase(opcional)</label>
							<select id="claseTest1" class="ComboBoxClase">
								<option id="claseOption" value="#">Clase</option>
								
								@foreach($clases as $clase)								
									<option value="{{ $clase->id }}">{{ $clase->Nombre }}</option>				
								@endforeach
							
							</select>
							<input id="testOtros" type="text" placeholder="Indique tema">
						</li>
						<li><label>Tipo de Test</label>
							<select id="categoryTest" class="ComboBoxTest">
								<option value="1">Test sin penalizacion</option>
								<option value="2">Test con penalizacion</option>
							</select>
							<div id="formTest">
								<input id="monorespuesta" type="radio" name="TipoRespuesta" value="0" checked/>Monorespuesta</br>
								<input id="multirespuesta" type="radio" name="TipoRespuesta" value="1"/>Multirespuesta</br>
							</div>
						</li>
						<li><label>Numero de preguntas</label><input id="preguntas" type="number" min="1" max=""></li>
						<li><label>Numero de respuestas</label><input id="respuestas" type="number" min="1" max=""></li>
						<li><label>Calificacion test</label>
						<input id="calificacionTest" type="number" min="1" max=""><p class="Testp1">Seleccione el número de preguntas correctas necesarias para aprobar el test.</p>
						<p class="Testp2">Indique la puntuacion necesaria para aprobar el test.</p>
						</li>
						<li><div class="OkButton Button TestButton" onClick="crearTest()">Crear nuevo test</div>
						<div class="CancelButton Button TestButton" onClick="closeAlert()">Cancelar</div></li>
					</ul>	
				</form>
			</div>
			<div id="liTest1Content2">
				<section id="testSection1">
					<div id="botonEsconder1" onclick="slideRight()">
						<img src="{{ asset ('/images/RightArrowWhite.png') }}">
					</div>
					<div id="botonEsconder2" onclick="slideDown()">
						<img src="{{ asset ('/images/DownArrowWhite.png') }}">
					</div>
					<div id="preguntasContainer">
						
					</div>
					<div id="explicacionContainer">
						<p>Explicación de la pregunta</p>
						<textarea></textarea>
						<div id="explicacionIcons">
							<img class="TestIcon" src="{{ asset ('/images/SubirLocal.png') }}">
							<img class="TestIcon" src="{{ asset ('/images/Iconovideo.png') }}">
							<img class="TestIcon" src="{{ asset ('/images/Iconoimagen.png') }}">
							<img class="TestIcon" src="{{ asset ('/images/IconoEscenario.png') }}">
							<img class="TestIcon" src="{{ asset ('/images/IconoElemento.png') }}">
						</div>
					</div>
				</section>
				<section id="testSection2">
					<div id="testTreeContainer">
						<div class="TestTreeTittles">
							<input type="radio" name="PreguntaTest"><label>Pregunta 1</label><img src="{{ asset ('/images/RightArrow.png') }}" class="TestArrow" width="9" height="9">
						</div>
						<div class="TestTreeBody">
							<p>Respuesta 1</p>
							<p>Respuesta 2</p>
							<p>Respuesta 3</p>
						</div>
						<div class="TestTreeTittles">
							<input type="radio" name="PreguntaTest"><label>Pregunta 2</label><img src="{{ asset ('/images/RightArrow.png') }}" class="TestArrow" width="9" height="9">
						</div>
						<div class="TestTreeBody">
							<p>Respuesta 1</p>
							<p>Respuesta 2</p>
							<p>Respuesta 3</p>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="LiTestAutomatico">
			<div class="LiTestAutomatico1">
				<div id="marcadorTestContainer">
					<p>Test Nº</p>
					<div id="marcadorTest">
						<p>1</p>
					</div>
				</div>
				<form>
					<ul>
						<li><label>Título</label><input id="tituloTest" type="text"></li>
						<li class="AlumnoTest"><label>Alumno</label>
							<select id="alumnoTest" class="ComboBoxAlumno">
								<option id="claseOption" value="#">Alumno</option>								

								@foreach($pivots as $pivot)
									<?php $user = $pivot->user; ?>
									<option value="{{ $user->id }}">
										{{ $user->firstname . ' ' . $user->lastname }}
									</option>
								@endforeach
									
							</select>
						</li>
						<li><label>Clase(opcional)</label>
							<select id="claseTest2" class="ComboBoxClase">
								<option id="claseOption" value="#">Clase</option>
								
								@foreach($clases as $clase)								
									<option value="{{ $clase->id }}">{{ $clase->Nombre }}</option>			
								@endforeach		
								
							</select>
						</li>
						<li><label>Tipo de Test</label>
							<select class="ComboBoxTest">
								<option value="1">Test sin penalizacion</option>
								<option value="2">Test con penalizacion</option>
							</select>
						</li>
						<li><label>Numero de preguntas</label><input type="number" min="1" max=""></li>
						<li><label>Calificacion test</label>
						<input id="calificacionTest1" type="number" min="1" max=""><p class="Testp1">Seleccione el número de preguntas correctas necesarias para aprobar el test.</p>
						<input id="calificacionTest2" type="number" min="0" max=""></br><p class="Testp2">Indique la puntuacion necesaria para aprobar el test.</p>
						</li>
						<li><div id="generarTest1" class="OkButton Button TestButton" onClick="generarTest()">Generar</div><input type="submit" class="CancelButton Button TestButton" onClick="closeAlert()" value="Cancelar"></li>
					</ul>	
				</form>
			</div>
			<div class="LiTestAutomatico2">
				<div id="preguntasContainer">
					<section>
						<h3>Pregunta 1</h3>
						<p>Cras id eleifend erat, a consequat libero. Curabitur nec nibh enim. Aliquam maximus dapibus tristique. Mauris et tincidunt orci</p>
					</section>
					<div>
						<section>
							Mauris nec massa tincidunt, pellentesque neque at, luctus massa. Nullam pharetra nibh ac lorem feugiat suscipit. Pellentesque sit amet rhoncus nisi.
						</section>
						<section>
							Mauris nec massa tincidunt, pellentesque neque at, luctus massa. Nullam pharetra nibh ac lorem feugiat suscipit. Pellentesque sit amet rhoncus nisi.
						</section>
						<section>
							Mauris nec massa tincidunt, pellentesque neque at, luctus massa. Nullam pharetra nibh ac lorem feugiat suscipit. Pellentesque sit amet rhoncus nisi.
						</section>
					</div>
				</div>
				<div class="TestButtonsContainer">
						<input type="submit" class="OkButton Button TestButton TestButton2_1" value="Finalizar Test">
						<div class="BackButton Button TestButton TestButton2_2" onClick="volverTest()">Volver Configuración Test</div>
						<input type="submit" class="CancelButton Button TestButton TestButton2_3" onClick="closeAlert()" value="Cancelar">
					</div>
			</div>
		</div>
	</div>
		<script type="text/javascript" src="{{ asset ('/js/script.js') }}"></script>
		<script type="text/javascript" src="{{ asset ('/js/test.js') }}"></script>
</body>
</html>