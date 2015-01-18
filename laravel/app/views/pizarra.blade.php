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
	<script type="text/javascript" src="{{ asset ('js/utils.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/canvas.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/recorderjs/recorder.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/recorderjs/recorderWorker.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<!-- PENSAR QUE HACER CON EL GENERADOR DE CONTRASEÑAS -->
	@if(\Session::has('password'))
		<!-- <input value="{{ \Session::get('password') }}" -->
		<script type="text/javascript">
			alert("{{ \Session::get('password') }}");
		</script>
	@endif
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
				<div id="botonCapturaDiv" onClick="getCanvasSnapshot()">
					<input id="botonCaptura"  type="image" src="images/snapShot.png"/>
				</div>
				<div id="botonGrabarDivOff" class="BotonGrabarOff" onclick="grabarAlert()">
					<input id="botonGrabar"  type="image" src="images/rec.png"/>
				</div>
				<div id="botonGrabarDivOn" class="BotonGrabarOn" >
					<input id="botonGrabar"  type="image" src="images/rec.png"/>
				</div>
				<div id="botonStopDiv" class="BotonStopDivVisible BotonStopDivHidden" onclick="stopButtom()">
					<input id="botonStop"  type="image" src="images/stop.png"/>
				</div>
				<div id="botonDibujoDiv" onClick="dibujoManoAlzada()">
					<input id="botonDibujo" type="image" src="images/draw.png"/>
				</div>
				<div id="draggable" class="ui-widget-content">
					<p>Drag me around</p>
				</div>

			<!-- CONECTANDO EL FORMULARIO CON LOS SELECTS A LA BASE DE DATOS -->
			</div>
			<div id="edicionHerramientas" class="MenuHerramientas">
				<input id="botonNuevoDominio" onClick="createDominio()" type="submit" name="Boton2" 
				value="Nuevo Dominio"/>
				<input id="botonNuevaClase" onClick="createClase()" type="submit" name="Boton2" value="Nueva Clase"/>
				<input id="botonBorrarEscenarios" onClick="borrarEscenario()" type="submit" name="Boton2" 
				value="Borrar Escenarios"/>
				<input id="botonBorrarElementos" onClick="borrarElementos()" type="submit" name="Boton2" 
				value="Borrar Elementos"/>
			</div>
			<div id="usuariosHerramientas" class="MenuHerramientas">
				<input id="botonAlumnos" onClick="createAlumno()" type="submit" name="Boton2" value="Crear Usuario"/>
				<input id="botonEditarUsuario" onClick="editUsuario()" type="submit" name="Boton2" value="Editar Usuario"/>
				<input id="botonEliminarUsuario" onClick="deleteUsuario()" type="submit" name="Boton2" value="Eliminar Usuario"> 
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
				<div id="MAC1" class="MenuLeft-ArticlesContainer">

				</div>
			</div>
			<li class="MenuLeft-ItemLista-Ele">Elementos<img src="images/RightArrow.png" id="ElementosArrow" class="Arrow" width="9" height="9"></li>
			<div class="ElementosContainer">
				<div id="MAC2" class="MenuLeft-ArticlesContainer">
					
				</div>
			</div>	
		</ul>
	</nav>
	<div class="Pizarra">
		<canvas id="c">
		</canvas>
	</div>

	<div class="AlertContainer">
		
			<div id="alertBody" class="AlertBodyBig, AlertBody">
				<div class="AlertTittleContainer">
					<h4>Título</h4><img onClick="closeAlert()" src="images/CloseButton.png" height="20" id="closeButton">
				</div>
				<div class="AlertContent">
					
				</div>
				<div class="AlertElement">
					{{ Form::open(['method' => 'POST', 'role' => 'form', 'class' => 'Foo1', 
								   'id' => 'createDomClass']) }}

						{{ Field::select('selectDominio', null, ['input' => ['class' => 'ComboBoxDominio']]) }}
						{{ Field::text('foo11') }}
						<p id="foo1Fail"><p>

						<div class="ButtonsContainer">					
							<button class="OkButton Button">Aceptar</button>
							<div class="AddButton Button" id="addButtomFoo1" onClick="">Agregar</div>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}	
					{{ Form::open(['method' => 'POST', 'role' => 'form', 'class' => 'Foo2']) }}						
						<div class="ContentOverflow">
							<table>
								<thead>
									<tr>
										<td><strong>Imagen</strong></td>
										<td><strong>Escenario</strong></td>
										<td><strong>Seleccionar</strong></td>
									</tr>
								</thead>
								<tbody id="" class="content">
										
								</tbody>
							</table>
						</div>	
						<div class="ButtonsContainer">	
							<div  class="UncheckButton">Aceptar</div>
							<button class="CheckButton">Aceptar</button>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>						
					{{ Form::close() }}
					{{ Form::open(['method' => 'POST', 'role' => 'form', 'class' => 'Foo3']) }}								
						<select id="roles1" class="ComboBoxClase" name="roles">
							<option value="alumno">Alumno</option>
							<option value="admin">Docente</option>
						</select>
						<div id="contentOverflow-Usuario" class="ContentOverflow">
							{{ Field::text('firstname', null, ['input' => ['id' => 'firstname1', 
							'placeholder' => 'Nombre']]) }}
							{{ Field::text('lastname', null, ['input' => ['id' => 'lastname1', 
							'placeholder' => 'Apellidos']]) }}
							<p id="firstname1Error" class="CU_errors"></p>
							<p id="lastname1Error" class="CU_errors"></p>
							{{ Field::text('username', null, ['input' => ['id' => 'username1', 
							'placeholder' => 'Username']]) }}
							{{ Field::text('nif', null, ['input' => ['id' => 'nif1', 'placeholder' => 'Dni']]) }}
							<p id="username1Error" class="CU_errors"></p>
							<p id="nif1Error" class="CU_errors"></p>
							{{ Field::text('adress', null, ['input' => ['id' => 'adress1', 
							'placeholder' => 'Dirección']]) }}
							{{ Field::text('locality', null, ['input' => ['id' => 'locality1', 
							'placeholder' => 'Localidad']]) }}
							<p id="adress1Error" class="CU_errors"></p>
							<p id="locality1Error" class="CU_errors"></p>
							{{ Field::text('province', null, ['input' => ['id' => 'province1', 
							'placeholder' => 'Provincia']]) }}
							{{ Field::text('cp', null, ['input' => ['id' => 'cp1', 
							'placeholder' => 'Código postal']]) }}
							<p id="province1Error" class="CU_errors"></p>
							<p id="cp1Error" class="CU_errors"></p>
							{{ Field::text('phone', null, ['input' => ['id' => 'phone1', 'placeholder' => 'Tlf']]) }}
							{{ Field::email('email', null, ['input' => ['id' => 'email1', 
							'placeholder' => 'E-mail']]) }}
							<p id="phone1Error" class="CU_errors"></p>
							<p id="email1Error" class="CU_errors"></p>
							{{ Field::date('borndate', null, ['input' => ['id' => 'borndate1']]) }}
							{{ Field::text('obs', null, ['input' => ['id' => 'obs1', 
							'placeholder' => 'Observaciones']]) }}
							<p id="borndate1Error" class="CU_errors"></p>
							<p id="obs1Error" class="CU_errors"></p>
							{{ Field::password('password', ['input' => ['id' => 'password1', 
							'placeholder' => 'Nueva Contraseña']]) }}
							{{ Field::password('password_confirmation', 
							['input' => ['id' => 'password_confirmation1', 'placeholder' => 'Repite Contraseña']]) }}
							<p id="password1Error" class="CU_errors"></p>
							<p id="password_confirmation1Error" class="CU_errors"></p>
						</div>
						<div class="ButtonsContainer">					
							<div class="OkButton Button" onClick="createUser()">Aceptar</div>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}

					{{ Form::model($user, ['method' => 'POST', 'role' => 'form', 
								   'class' => 'Foo4']) }}						
						<select id="roles" class="ComboBoxClase" name="roles">
							@if($user->roles === "alumno")
								<option value="alumno">Alumno</option>
								<option value="admin">Docente</option>
							@else
								<option value="admin">Docente</option>
								<option value="alumno">Alumno</option>
							@endif
						</select>
						<div id="contentOverflow-Usuario" class="ContentOverflow">
							{{ Field::text('firstname', null, ['input' => ['placeholder' => 'Nombre', 
										   'value' => $user->firstname ]]) }}
							{{ Field::text('lastname', null, ['input' => ['placeholder' => 'Apellidos', 
										   'value' => $user->lastname ]]) }}
							<p id="firstnameError" class="EU_errors"></p>
							<p id="lastnameError" class="EU_errors"></p>
							{{ Field::text('username', null, ['input' => ['placeholder' => 'Username', 
										   'value' => $user->username ]]) }}
							{{ Field::text('nif', null, ['input' => ['placeholder' => 'Dni', 
										   'value' => $user->nif ]]) }}
							<p id="usernameError" class="EU_errors"></p>
							<p id="nifError" class="EU_errors"></p>
							{{ Field::text('adress', null, ['input' => ['placeholder' => 'Dirección', 
										   'value' => $user->adress ]]) }}
							{{ Field::text('locality', null, ['input' => ['placeholder' => 'Localidad', 
										   'value' => $user->locality ]]) }}
							<p id="adressError" class="EU_errors"></p>			   
							<p id="localityError" class="EU_errors"></p>
							{{ Field::text('province', null, ['input' => ['placeholder' => 'Provincia', 
										   'value' => $user->province ]]) }}
							{{ Field::text('cp', null, ['input' => ['placeholder' => 'Código postal', 
										   'value' => $user->cp ]]) }}
							<p id="provinceError" class="EU_errors"></p>
							<p id="cpError" class="EU_errors"></p>
							{{ Field::text('phone', null, ['input' => ['placeholder' => 'Tlf', 
										   'value' => $user->phone ]]) }}
							{{ Field::email('email', null, ['input' => ['placeholder' => 'E-mail', 
										   'value' => $user->email ]]) }}
							<p id="phoneError" class="EU_errors"></p>
							<p id="emailError" class="EU_errors"></p>
							{{ Field::date('borndate', null, ['input' => [ 'value' => $user->borndate ]]) }}
							{{ Field::text('obs', null, ['input' => ['placeholder' => 'Observaciones', 
										   'value' => $user->obs ]]) }}
							<p id="borndateError" class="EU_errors"></p>
							<p id="obsError" class="EU_errors"></p>										   
							{{ Field::password('oldpassword', ['input' => ['placeholder' => 'Contraseña actual']]) }}
							{{ Field::password('password', ['input' => ['placeholder' => 'Nueva Contraseña']]) }}
							<p id="oldpasswordError" class="EU_errors"></p>
							<p id="passwordError" class="EU_errors"></p>
							{{ Field::password('password_confirmation', 
							['input' => ['placeholder' => 'Repite Contraseña']]) }}
							<p id="password_confirmationError" class="EU_errors"></p>
						
						</div>
						<div class="ButtonsContainer">					
							<div class="OkButton Button" onClick="editUser()">Aceptar</div>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}
					{{ Form::open(['class' => 'Foo5']) }}
						<div class="ButtonsContainer">					
							<div class="RecordButton Button" onclick="recordButtom()">Grabar</div>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}
					{{ Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'Foo6', 
								   'id' => 'fileForm1']) }}
						{{ Field::text('name', null, ['input' => ['id' => 'foo61'], 
									   'label' => ['style' => 'display:inline-block;']]) }}<br>
						Seleccionar imagen <p id="fileContainer1"></p> <p id="fileContainer2"></p>
						<!-- <input id="foo62" name="" src="images/upload.png" type="image"> -->
						<div class="ButtonsContainer">					
							<button class="OkButton Button">Aceptar</button>
							<button class="AddButton Button">Agregar</button>
							<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
						</div>	
					{{ Form::close() }}
					</form>
						<form class="Foo7">
						<!-- <img width="100%" src="images/escenarios/fondo1.jpg"> -->
						<input id="foo71" name="" type="button" value="Publicar">
						<input id="foo72" name="" type="button" value="descargar">
						<input id="foo73" onClick="closeAlert()" type="button" value="Cancelar">
					</form>
				</div>													
			</div>		
	</div>
	<div class="ColorPickerContainer">
		<h5> Color Picker</h5>
		<img onClick="closeAlert()" src="images/CloseButton2.png" height="20" id="closeButton2">
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
			<div>
				<img class="LineWidthModifier" src="images/more.png" heigth="20" width="20" id="mas">
				<img class="LineWidthModifier" src="images/less.png" heigth="20" width="20" id="menos">
			</div>
		</div>
		<div class="WidthContainer">
			<h4>Dibujo:</h4>
			<div>
				<img class="LineWidthModifier" src="images/pencil.png" heigth="20" width="20" id="pencil">
				<img class="LineWidthModifier" src="images/eraser.png" heigth="20" width="20" id="eraser">
			</div>
		</div>
		<div class="WidthContainer">
			<h4>Dibujo:</h4>
			 <select id="dtool">
		        <option value="line">Linea</option>
		        <option value="rect">Rectangulo</option>
	        	<option value="pencil">Lápiz</option>
	        	<option value="circ">Circulo</option>
			</select>
		</div>
		<div class="WidthContainer">
			<h4>Edición:</h4>
			<div>
				<img class="LineWidthModifier" src="images/goRight.png" heigth="20" width="20" id="goRight">
				<img class="LineWidthModifier" src="images/goBack.png" heigth="20" width="20" id="goBack">
			</div>
		<div>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/dibujo.js"></script>
</body>
</html>