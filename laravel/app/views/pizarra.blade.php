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
						<?php $user = Auth::user(); ?>
						<p class="CuadroUsuarioP">{{ $user->username }}</p>
						<p class="CuadroUsuarioLogOut">LogOut</p>
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
				<input id="botonAlumnos" onClick="createAlumno()" type="submit" name="Boton2" value="Crear Usuario"/>
				<input id="botonEditarUsuario" onClick="editUsuario()" type="submit" name="Boton2" value="Editar Usuario"/>
				<input id="botonCaptura" onClick="getCanvasSnapshot()" type="submit" name="Boton2" value="Captura de pantalla"/>
				<input id="botonGrabar" onclick="recordStopVideoAudio()" type="submit" name="Boton2" value="Grabar"/>
				<input id="botonDibujo" onClick="dibujoManoAlzada()" type="submit" name="Boton2" value="Dibujo a mano alzada"/>
				<div id="draggable" class="ui-widget-content">
					<p>Drag me around</p>
				</div>
			</div>
			<!-- <div id="administracionHerramientas" class="MenuHerramientas">
				<input id="botonProfe" onClick="createProfesor()" type="submit" name="Boton2" value="Usuarios"/>
			</div> -->
		</div>
	</header>

	<nav class="MenuLeft">
		<ul class="MenuLeft-Lista">
			<li class="MenuLeft-ItemLista-Esc">Escenarios<img src="images/RightArrow.png" id="EscenariosArrow" class="Arrow" width="9" height="9"></li>
			<div class="EscenariosContainer">
				<div class="MenuLeft-ArticlesContainer">
					<article class="Article">
						<img src="images/fondo1.jpg" height="80" width="80">
					</article>
					<article class="AddArticle">
						<img class="AddArticle-Image" src="images/addEscenario.png" height="80" width="80">
					</article>
				</div>
			</div>
			<li class="MenuLeft-ItemLista-Ele">Elementos<img src="images/RightArrow.png" id="ElementosArrow" class="Arrow" width="9" height="9"></li>
			<div class="ElementosContainer">
				<div class="MenuLeft-ArticlesContainer">
					<article class="Article">
						<img src="images/fondo1.jpg" height="80" width="80">
					</article>
					<article class="Article">
						<img src="images/fondo1.jpg" height="80" width="80">
					</article>
					<article class="AddArticle">
						<img class="AddArticle-Image" src="images/addEscenario.png" height="80" width="80">
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
				<div class="AlertContent">
					
				</div>
				<div class="AlertElement">
					{{ Form::open(['route' => 'addFoo', 'method' => 'POST', 'role' => 'form', 
								   'class' => 'Foo1']) }}
						<select id="selectDominio" name="dominioVal" class="ComboBoxDominio">
						</select>
						<input id="foo11" type="text" placeholder=""/>

						<div class="ButtonsContainer">					
							<button class="OkButton Button">Aceptar</button>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}	
					{{ Form::open(['route' => 'borrarEscenario', 'method' => 'POST', 'role' => 'form', 
								   'class' => 'Foo2']) }}						
						<div class="ContentOverflow">
							<table>
								<thead>
									<tr>
										<td><strong>Imagen</strong></td>
										<td><strong>Escenario</strong></td>
										<td><strong>Seleccionar</strong></td>
									</tr>
								</thead>
								<tbody>
									@foreach($escenarios as $e)
										<tr>
											<td><img src=""/></td>
											<td>
												{{ $e->Nombre }}
											</td>
											<td>
												<input type="Checkbox" name="checkbox[]" value="{{ $e->id }}" />
											</td>
										</tr>
																			
									@endforeach
								</tbody>
							</table>
						</div>	
						<div class="ButtonsContainer">					
							<button class="OkButton Button">Aceptar</button>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>						
					{{ Form::close() }}
					{{ Form::open(['route' => 'createUser', 'method' => 'POST', 'role' => 'form', 
								   'class' => 'Foo3']) }}								
						<select id="selectUser" class="ComboBoxClase" name="roles">
							<option value="alumno">Alumno</option>
							<option value="admin">Docente</option>
						</select>
						<div class="ContentOverflow">
							<input name="firstname" type="text" placeholder="Nombre"/>
							<input name="lastname" type="text" placeholder="Apellidos"/>
							<input name="username" type="text" placeholder="Username"/>
							<input name="nif" type="text" placeholder="Dni"/>
							<input name="direction" type="text" placeholder="Direccion"/>
							<input name="city" type="text" placeholder="Localidad"/>
							<input name="state" type="text" placeholder="Provincia"/>
							<input name="Cp" type="number" placeholder="Cp"/>
							<input name="phone" type="tel" maxlength="9" placeholder="Tlf"/>
							<input name="email" type="email" placeholder="E-mail"/>
							<input name="date" type="text" placeholder="Fecha Nacimiento"/>
							<input name="obs" type="text" placeholder="Observaciones"/>
							<input name="password" type="password" placeholder="Contraseña"/>
							<input name="password_confirmation" type="password" placeholder="Repite Cotraseña"/>
						</div>
						<div class="ButtonsContainer">					
							<button class="OkButton Button">Aceptar</button>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}

					{{ Form::model($user, ['route' => 'editUser', 'method' => 'POST', 'role' => 'form', 
								   'class' => 'Foo4']) }}						
						<select id="selectUser" class="ComboBoxClase" name="roles">
							@if($user->roles === "alumno")
								<option value="alumno">Alumno</option>
								<option value="admin">Docente</option>
							@else
								<option value="admin">Docente</option>
								<option value="alumno">Alumno</option>
							@endif
							</select>
						<div class="ContentOverflow">
							<input name="firstname" type="text" placeholder="Nombre" value="{{ $user->firstname }}"/>
							<input name="lastname" type="text" placeholder="Apellidos" value="{{ $user->lastname }}"/>
							<input name="username" type="text" placeholder="Username" value="{{ $user->username }}"/>
							<input name="nif" type="text" placeholder="Dni"/>
							<input name="direction" type="text" placeholder="Direccion"/>
							<input name="city" type="text" placeholder="Localidad"/>
							<input name="state" type="text" placeholder="Provincia"/>
							<input name="Cp" type="number" placeholder="Cp"/>
							<input name="phone" type="tel" maxlength="9" placeholder="Tlf" value="{{ $user->phone }}"/>
							<input name="email" type="email" placeholder="E-mail" value="{{ $user->email }}"/>
							<input name="date" type="text" placeholder="Fecha Nacimiento"/>
							<input name="obs" type="text" placeholder="Observaciones"/>
							<input name="oldpassword" type="password" placeholder="Contraseña actual"/>
							<input name="password" type="password" placeholder="Nueva Contraseña"/>
							<input name="password_confirmation" type="password" placeholder="Repite Contraseña"/>
						</div>
						<div class="ButtonsContainer">					
							<button class="OkButton Button">Aceptar</button>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}
				</div>													
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