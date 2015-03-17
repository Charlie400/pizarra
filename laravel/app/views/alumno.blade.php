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
					<li Class="Menu-Item">Presentación</li>
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
			<div class="MenuHerramientas">
				<select id="dominio" class="ComboBoxDominio">
					<option value="">Dominio</option>
				</select>
			</div>
		</div>
	</header>
	<nav class="MenuLeft">
		<ul class="MenuLeft-Lista">
			<li class="MenuLeft-ItemLista-Esc">Material de ayuda<img src="images/RightArrow.png" id="EscenariosArrow" class="Arrow" width="9" height="9"></li>
			<div class="EscenariosContainer">
				<div id="MAC1" class="MenuLeft-ArticlesContainer">
					<div class="AlumnoTreeContainer">
						<div class="TestTreeTittles">
							<label>Pregunta 1</label><img src="{{ asset ('/images/RightArrow.png') }}" class="TestArrow" width="9" height="9">
						</div>
						<div class="TestTreeBody AlumnoAsignacion">
							<p>Respuesta 1</p>
							<p>Respuesta 2</p>
							<p>Respuesta 3</p>
						</div>
					</div>
				</div>
			</div>
			<li class="MenuLeft-ItemLista-Ele">Tareas asignadas<img src="images/RightArrow.png" id="ElementosArrow" class="Arrow" width="9" height="9"></li>
			<div class="ElementosContainer">
				<div id="MAC2" class="MenuLeft-ArticlesContainer">
					<div class="AlumnoTreeContainer">
						<div class="TestTreeTittles">
							<label>Pregunta 1</label><img src="{{ asset ('/images/RightArrow.png') }}" class="TestArrow" width="9" height="9">
						</div>
						<div class="TestTreeBody AlumnoTarea">
							<p>Respuesta 1</p>
							<p>Respuesta 2</p>
							<p>Respuesta 3</p>
						</div>
					</div>
				</div>
			</div>	
		</ul>
	</nav>
	<div class="AreaTrabajo">
		<section id="areaTrabajoSection1">
			<h3>Título</h3>
			<input id="tituloAlumno" name="titulo" type="text" readonly>
			<h3>Descripción</h3>
			<textarea id="textareaAlumno" readonly></textarea>
			<button id="alumnoMaterialAdjunto">Material adjunto</button>
		</section>
		<section id="areaTrabajoSection2">
			<div class="AreaTrabajoSection2Header">
				<div class="Clock">
					<svg width="150" height="150">
						<defs>
							<clipPath id="clipRightAnim">
								<rect width="75" height="150" x="0" y="0" transform="rotate(67.5855 75 75)">
									<animateTransform class="AnimateTransform" attributeName="transform" attributeType="XML" type="rotate" from="0 75 75" to="180 75 75" dur="750" fill="freeze" begin="0s" id="anim1"></animateTransform>
								</rect>
							</clipPath>
							<clipPath id="clipRightStatic">
								<rect width="75" height="150" x="75" y="0" fill="white"></rect>
							</clipPath>
							<clipPath id="clipLeftAnim">
								<rect width="75" height="150" x="75" y="0">
									<animateTransform class="AnimateTransform" attributeName="transform" attributeType="XML" type="rotate" from="0 75 75" to="180 75 75" dur="750" fill="freeze" begin="anim1.end"></animateTransform>
								</rect>
							</clipPath>
							<clipPath id="clipLeftStatic">
								<rect width="75" height="150" x="0" y="0" fill="white"></rect>
							</clipPath>
						</defs>
						<circle cx="75" cy="75" r="53.33" stroke="white" fill="#91BEAC" stroke-width="20"></circle>
						<g clip-path="url(#clipRightAnim)">
							<circle cx="75" cy="75" r="53.33" stroke="#16A085" stroke-width="20" fill="none" clip-path="url(#clipRightStatic)"></circle>
						</g>
						<g clip-path="url(#clipLeftAnim)">
							<circle cx="75" cy="75" r="53.33" stroke="#16A085" stroke-width="20" fill="none" clip-path="url(#clipLeftStatic)"></circle>
						</g>
					</svg>
					<div id="timer"></div>
				</div>
				<h3>título</h3>
				<div class="AreaTrabajoSection2PreguntasContainer">
					hola
				</div>
			</div>
			<div class="AreaTrabajoSection2body">
			</div>
		</section>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/alumno.js"></script>
</body>
</html>