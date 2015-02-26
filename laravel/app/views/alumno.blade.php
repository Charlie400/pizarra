<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8"/>
	<title>Pizarra</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:500,300,700,400' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="{{ asset ('js/jquery-1.11.1.js') }}"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script type="text/javascript" src="{{ asset ('js/utils.js') }}"></script>
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
					<li id="presentacion" Class="Menu-Item">Tareas a realizar</li>
					<li id="edicion" Class="Menu-Item">Material de apoyo</li>
					<li id="usuarios" Class="Menu-Item">Calificaciones</li>
				</ul>
				<div class="CuadroUsuario">
					<?php $user = Auth::user(); ?>
					<p class="CuadroUsuarioP">{{ ucfirst(strtolower($user->username)) }}</p>
					<p class="CuadroUsuarioLogOut">
						<a style="text-decoration:none; color:black" href="{{ route('logout') }}">
							LogOut
						</a>
					</p>
				</div>
				<div class="CuadroInformativo">
					<p class="CuadroP1"></p>
					<p class="CuadroP2"></p>
				</div>
			</nav>
		</div>
	</header>
	<nav class="MenuLeft">
		<ul class="MenuLeft-Lista">
			<div id="testTreeContainer">
				<div class="TestTreeTittles">
					<input type="radio" name="PreguntaTest"><label>Pregunta 1</label><img src="images/RightArrow.png" class="TestArrow" width="9" height="9">
				</div>
				<div class="TestTreeBody">
					<p>Respuesta 1</p>
					<p>Respuesta 2</p>
					<p>Respuesta 3</p>
				</div>
				<div class="TestTreeTittles">
					<input type="radio" name="PreguntaTest"><label>Pregunta 2</label><img src="images/RightArrow.png" class="TestArrow" width="9" height="9">
				</div>
				<div class="TestTreeBody">
					<p>Respuesta 1</p>
					<p>Respuesta 2</p>
					<p>Respuesta 3</p>
				</div>
			</div>
		</ul>
	</nav>
	<div class="AreaTrabajo">
		<section id="testSection1">
			<div id="preguntasContainer">
				<table>
					<td><h3>Pregunta 1</h3></td>
					<tr>
						<th><textarea></textarea></th>
						<th class="IconTh"><img class="TestIcon" src="images/SubirLocal.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconovideo.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconoimagen.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoEscenario.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoElemento.png"></th>
					</tr>
				</table>
				<table>
					<tr class="RespuestaTable">
						<th><input class="MultiRespuestaTest" type="checkbox"></th>
						<th><input class="MonoRespuestaTest" name="SeleccionarRespuesta" type="radio"></th>
						<th></th>
						<th><textarea></textarea></th>
						<th class="IconTh"><img class="TestIcon" src="images/SubirLocal.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconovideo.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconoimagen.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoEscenario.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoElemento.png"></th>
					</tr>
					<tr class="RespuestaTable">
						<th><input class="MultiRespuestaTest" type="checkbox"></th>
						<th><input class="MonoRespuestaTest" name="SeleccionarRespuesta"  type="radio"></th>
						<th></li></th>
						<th><textarea></textarea></th>
						<th class="IconTh"><img class="TestIcon" src="images/SubirLocal.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconovideo.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconoimagen.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoEscenario.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoElemento.png"></th>
					</tr>
					<tr class="RespuestaTable">
						<th><input class="MultiRespuestaTest" type="checkbox"></th>
						<th><input class="MonoRespuestaTest" name="SeleccionarRespuesta"  type="radio"></th>
						<th></li></th>
						<th><textarea></textarea></th>
						<th class="IconTh"><img class="TestIcon" src="images/SubirLocal.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconovideo.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/Iconoimagen.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoEscenario.png"></th>
						<th class="IconTh"><img class="TestIcon" src="images/IconoElemento.png"></th>
					</tr>
				</table>
				<div class="TestButtonsContainer">
					<input type="submit" class="OkButton Button TestButton" value="Finalizar Test">
					<input type="submit" class="CancelButton Button TestButton" onClick="closeAlert()" value="Cancelar">
				</div>
			</div>
		</section>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>