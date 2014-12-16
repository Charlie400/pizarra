<!DOCTYPE html>
<html lang="es">
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Pizarra</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:500,300,700,400' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="{{ asset ('js/jquery-1.11.1.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/canvas.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/recorderjs/recorder.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/recorderjs/recorderWorker.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>	
	<header>
		<div class="Titulo">
			<h1>Pizarra Digital</h1>
		</div><div class="MenuTop">
			<nav class="MenuPincipal">
				<ul Class="MenuLista">
					<li id="presentacion" Class="Menu-Item">Presentación</li>
					<li id="edicion" Class="Menu-Item">Edición</li>
					<li id="usuarios" Class="Menu-Item">Usuarios</li>
					<li id="administracion" Class="Menu-Item">Administración</li>
					<div class="CuadroUsuario">
					<p class="CuadroUsuarioP"></p>
					</div>
				</ul>
			</nav>

			<!-- CONECTANDO EL FORMULARIO CON LOS SELECTS A LA BASE DE DATOS -->

			<div id="presentacionHerramientas" class="MenuHerramientas">
				<select id="dominio" class="ComboBoxDominio">
					<option value="">Dominio</option>

					<!-- ESTO ES UN CICLO FOREACH DE PHP CON SINTAXIS DEL MOTOR DE PLANTILLAS BLADE 
					LO UTILIZAMOS PARA AÑADIR LOS OPTIONS NECESARIOS AL SELECT DEPENDIENDO DE LOS
					DOMINIOS DE LA BASE DE DATOS -->

					@foreach($dominios as $d)
						<?php 
							$name = $d->Nombre;
							$id   = $d->id; 
						?>
						<option id="dom{{ $id }}" value="{{ $id }}">{{ $name }}</option>	
					@endforeach

				</select>
				<select id="clase" class="ComboBoxClase">
					<option id="claseOption" value="#">Clase</option>									
				</select>

			<!-- CONECTANDO EL FORMULARIO CON LOS SELECTS A LA BASE DE DATOS -->

				<div class="CuadroInformativo">
					<p class="CuadroP1"></p>
					<p class="CuadroP2"></p>
				</div>
			</div>
			<div id="edicionHerramientas" class="MenuHerramientas">
				<input id="botonNuevoDominio" onClick="createDominio()" type="submit" name="Boton2" 
				value="Nuevo Dominio"/>
				<input id="botonNuevaClase" onClick="createClase()" type="submit" name="Boton2" value="Nueva Clase"/>
				<input id="botonBorrarEscenarios" onClick="borrarEscenario()" type="submit" name="Boton2" 
				value="Borrar Escenarios"/>
			</div>
			<div id="usuariosHerramientas" class="MenuHerramientas">
				<input id="botonAlumnos" onClick="createAlumno()" type="submit" name="Boton2" value="Alumnos"/>
				<input id="botonEditarUsuario" onClick="editUsuario()" type="submit" name="Boton2" value="Editar Usuario"/>
				<input id="botonCaptura" onClick="getCanvasSnapshot()" type="submit" name="Boton2" value="Captura de pantalla"/>
				<input id="botonGrabar" onclick="recordStopVideoAudio()" type="submit" name="Boton2" value="Grabar"/>
				<input id="botonDibujo" onClick="dibujoManoAlzada()" type="submit" name="Boton2" value="Dibujo a mano alzada"/>
				<div id="draggable" class="ui-widget-content">
					<p>Drag me around</p>
				</div
			</div>
			<div id="administracionHerramientas" class="MenuHerramientas">
			</div>
		</div>
	</header>

	<nav class="MenuLeft">
		<ul class="MenuLeft-Lista">
			<li class="MenuLeft-ItemLista-Esc">Escenarios<img src="images/RightArrow.png" id="EscenariosArrow" class="Arrow" width="9" height="9"></li>
			<div class="EscenariosContainer">
				<div class="MenuLeft-ArticlesContainer">
					<article class="Article">
						asd
					</article>
					<article class="Article">
						asd
					</article>
					<article class="AddArticle">
						asd
					</article>
				</div>
			</div>
			<li class="MenuLeft-ItemLista-Ele">Elementos<img src="images/RightArrow.png" id="ElementosArrow" class="Arrow" width="9" height="9"></li>
			<div class="ElementosContainer">
				<div class="MenuLeft-ArticlesContainer">
					<article class="Article">
						asd
					</article>
					<article class="Article">
						asd
					</article>
					<article class="AddArticle">
						asd
					</article>
				</div>
			</div>	
		</ul>
	</nav>
	<div class="Pizarra">

		<canvas id="c">
		</canvas>
	</div>

	<div class="AlertContainer">
		<div class="AlertBody">
			<div class="AlertTittleContainer">
				<h4>Título</h4><img onClick="closeAlert()" src="images/CloseButton.png" height="20" id="closeButton">
			</div>

			{{ Form::open(['route' => 'addFoo', 'method' => 'POST', 'role' => 'form']) }}
				<div class="AlertContent">

				</div>
				<div class="AlertElement">
				</div>
				<div class="ButtonsContainer">					
					<button class="OkButton Button">Aceptar</button>
					<button class="AddButton Button">Agregar</button>
					<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
				</div>
			{{ Form::close() }}			

		</div>
	</div>
		<div class="ColorPickerContainer">
		<h5> Color Picker</h5>
		<div class="ColorPickerBig">
			<div class="ColorPicker" style="background-color:#1ABC9C"></div>
			<div class="ColorPicker" style="background-color:#2ECC71"></div>
			<div class="ColorPicker" style="background-color:#3498DB"></div>
			<div class="ColorPicker" style="background-color:#9B59B6"></div>
			<div class="ColorPicker" style="background-color:#F1C40F"></div>
		</div>
		<div class="ColorPickerBig">
			<div class="ColorPicker" style="background-color:#E67E22"></div>
			<div class="ColorPicker" style="background-color:#E74C3C"></div>
			<div class="ColorPicker" style="background-color:#000"></div>
			<div class="ColorPicker" style="background-color:#FFF"></div>
			<div class="ColorPicker" style="background-color:#95A5A6"></div>
		</div>
		<div class="WidthContainer">
			<h4>Grosor:</h4>
			<img class="LineWidthModifier" src="images/more.png" heigth="20" width="20" id="mas">
			<img class="LineWidthModifier" src="images/less.png" heigth="20" width="20" id="menos">
		</div>
		<div class="WidthContainer">
			<h4>Dibujo:</h4>
			<img class="LineWidthModifier" src="images/pencil.png" heigth="20" width="20" id="pencil">
			<img class="LineWidthModifier" src="images/eraser.png" heigth="20" width="20" id="eraser">
		</div>
		<div class="WidthContainer">
			<h4>Edición:</h4>
			<img class="LineWidthModifier" src="images/goRight.png" heigth="20" width="20" id="goRight">
			<img class="LineWidthModifier" src="images/goBack.png" heigth="20" width="20" id="goBack">

	</div>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/pintar.js"></script>

	
</body>
</html>