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
	<script type="text/javascript" src="{{ asset ('js/test.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/material.js') }}"></script>
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
					<li id="asignaciones" Class="Menu-Item">Asignaciones</li>
					<li id="generacion" Class="Menu-Item">Generación de Test</li>
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
				<input id="botonEliminarUsuario" onClick="deleteUsuario('contentDeleteUsuario')" type="submit" name="Boton2" value="Eliminar Usuario"> 
			</div>
			<div id="asignacionesHerramientas" class="MenuHerramientas">
				<select id="comboAsignacion" class="ComboBoxClase">
					<option id="materialOption" value="0">Material de apoyo</option>
					<option id="tareaOption" value="1">Tareas a realizar</option>
				</select>
				<input id="botonCrearAsignacion" onclick="createAsignacion()" type="submit" name="Boton2" value="Crear asignación">
				<input id="botonEnviarAsignacion" onclick="sendAsignacion('contentSendAsignacion')" type="submit" name="Boton2" value="Enviar asignación">
				<input id="botonModificarAsignacion" onclick="editAsignacion()" type="submit" name="Boton2" value="Modificar asignación">
				<input id="botonEliminarAsignacion" onclick="deleteAsignacion()" type="submit" name="Boton2" value="Eliminar asignación">
			</div>
			<div id="generacionHerramientas" class="MenuHerramientas">
				<input id="botonCrearTest" onclick="testLocation()" type="submit" name="Boton2" value="Nuevo">
				<input id="botonModificarTest" onclick="modificarTest()" type="submit" name="Boton2" value="Modificar">
				<input id="botonEliminarTest" onclick="eliminarTest()" type="submit" name="Boton2" value="Eliminar">
				<input id="botonImprimirTest" onclick="imprimirTest()" type="submit" name="Boton2" value="Imprimir">
				<input id="botonGuardarTest" onclick="guardarTest()" type="submit" name="Boton2" value="Guardar Como">
			</div>
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

				{{ Form::open(['route' => 'unsubscribe','method' => 'POST', 'role' => 'form', 'class' => 'Foo1', 
							   'id' => 'createDomClass']) }}
			   <div id="Foo1ContentOverflow" class="ContentOverflow">
						<table>
							<thead>
								<tr>
									<td class="td1"><strong>número</strong></td>
									<td class="td2"><strong>Alumno</strong></td>
									<td class="td3"><strong>tipo</strong></td>
									<td><strong>Seleccionar</strong></td>
								</tr>
							</thead>
							<tbody id="tbodySendAsignacion" class="content contentDeleteUsuario">
									
							</tbody>
						</table>
					</div>
				<input type="hidden" id="deleteUserIdDominio" name="id_dominio" value="" />
				{{ Field::select('selectDominio', null, ['input' => ['class' => 'ComboBoxDominio']]) }}
				{{ Field::text('foo11') }}
				<svg class="svg1" width="25" height="25">
					<circle cx="12.5" cy="12.5" r="11" stroke="grey" stroke-width="2" fill="none"></circle>
					<line id="svg1Child1" x1="6" y1="13" x2="12" y2="20" stroke-linecap="round"></line>
					<line id="svg1Child2" x1="12" y1="20" x2="24" y2="7" stroke-linecap="round"></line>
				</svg>
				<svg class="svg2" width="25" height="25">
					<circle cx="12.5" cy="12.5" r="11" stroke="grey" stroke-width="2" fill="none"></circle>
					<line id="svg2Child1" x1="6" y1="6" x2="20" y2="20" stroke-linecap="round"></line>
					<line id="svg2Child2" x1="6" y1="20" x2="20" y2="6" stroke-linecap="round"></line>
				</svg>
					<p id="foo1Fail"><p>
					<span id="deleteUserError" class="CU_errors CU_errorsAsignacion" style="display:none">
						Seleccione un material y al menos un alumno antes de enviar.
					</span>
					<div class="ButtonsContainer">					
						<div class="OkButton Button" onClick="checkDeleteUsuario()">Aceptar</div>
						<button id="OkButtomDeleteUser" style="display:none;">Aceptar</button>
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
					<svg class="svg1" width="25" height="25">
						<circle cx="12.5" cy="12.5" r="11" stroke="grey" stroke-width="2" fill="none"></circle>
						<line id="svg1Child1" x1="6" y1="13" x2="12" y2="20" stroke-linecap="round"></line>
						<line id="svg1Child2" x1="12" y1="20" x2="24" y2="7" stroke-linecap="round"></line>
					</svg>
					<svg class="svg2" width="25" height="25">
						<circle cx="12.5" cy="12.5" r="11" stroke="grey" stroke-width="2" fill="none"></circle>
						<line id="svg2Child1" x1="6" y1="6" x2="20" y2="20" stroke-linecap="round"></line>
						<line id="svg2Child2" x1="6" y1="20" x2="20" y2="6" stroke-linecap="round"></line>
					</svg>
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
					<svg class="svg1" width="25" height="25">
						<circle cx="12.5" cy="12.5" r="11" stroke="grey" stroke-width="2" fill="none"></circle>
						<line id="svg1Child1" x1="6" y1="13" x2="12" y2="20" stroke-linecap="round"></line>
						<line id="svg1Child2" x1="12" y1="20" x2="24" y2="7" stroke-linecap="round"></line>
					</svg>
					<svg class="svg2" width="25" height="25">
						<circle cx="12.5" cy="12.5" r="11" stroke="grey" stroke-width="2" fill="none"></circle>
						<line id="svg2Child1" x1="6" y1="6" x2="20" y2="20" stroke-linecap="round"></line>
						<line id="svg2Child2" x1="6" y1="20" x2="20" y2="6" stroke-linecap="round"></line>
					</svg>
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
				<form class="Foo7">
					<!-- <img width="100%" src="images/escenarios/fondo1.jpg"> -->
					<input id="foo71" onclick="closeAlert()" name="" type="button" value="Publicar">
					<input id="foo72" name="" type="button" value="descargar">
					<!-- Añadir que al cancelar se elimine el vídeo -->
					<input id="foo73" onClick="deleteSnapshot()" type="button" value="Cancelar">
				</form>
				{{ Form::open(['route' => 'supportMaterial', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'Foo8']) }} 
					<div>
						<select name="id_material" id="ComboBoxEditarAsignaciones" class="ComboBoxAsignadas">										
						</select>
						<h3>Título</h3>						
						<input id="foo81" name="titulo" type="text">
					</div>
					<h3>Descripción</h3>
					<textarea id="foo82" name="descripcion" ></textarea>
					<h4 id="foo83">Documento adjunto</h4>
					<input id="foo84" name="documento" type="file">
					<section id="foo85">
						<h3>Test</h3>
						<select class="ComboBoxClase" name="testType">
							<option value="0">Temático</option>
							<option value="1">Generales</option>
							<option value="2">Repaso</option>
						</select>
						<div class="ContentOverflow-Asignacion">
							<table>
								<thead>
									<tr>
										<td><strong>#</strong></td>
										<td><strong>Título</strong></td>
									</tr>
								</thead>
								<tbody id="" class="">
										
								</tbody>
							</table>
						</div>	
						<h4>Modo exámen</h4>
						<input id="foo851" type="checkbox" name="examen" value="1">
						<h4 id="foo852">Duración(minutos)</h4>
						<input id="foo853" type="number" name="time" min="1" max="60">
					</section>
					<h3>fecha desde</h3>
					<h3>fecha hasta</h3>
					<input type="text" id="foo86" name="desde" class="Datepicker" readonly="readonly" size="12">	
					<input type="text" id="foo87" name="hasta" class="Datepicker" readonly="readonly" size="12">
					<h4>siempre visible</h4>
					<input id="foo88" type="checkbox" name="visible" value="1">
					<input type="hidden" value="0" id="typeAsignacion" name="typeAsignacion" />
					<input type="hidden" value="" id="supportTaskDominio" name="id_dominio" />
					<div class="ButtonsContainer">					
						<button class="OkButton Button">Aceptar</button>
						<button class="AddButton Button">Agregar</button>
						<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
					</div>	
				{{ Form::close() }}
				{{ Form::open(['route' => 'asignarMaterial', 'method' => 'POST', 'class' => 'Foo9']) }}
					<select name="id_material" id="ComboBoxAsignaciones" class="ComboBoxAsignadas">										
					</select>
					<div class="ContentOverflow">
						<table>
							<thead>
								<tr>
									<td class="td1"><strong>número</strong></td>
									<td class="td2"><strong>Alumno</strong></td>
									<td class="td3"><strong>tipo</strong></td>
									<td><strong>Seleccionar</strong></td>
								</tr>
							</thead>
							<tbody id="tbodySendAsignacion" class="content contentSendAsignacion">
									
							</tbody>
						</table>
					</div>
					<span id="asignacionError" class="CU_errors CU_errorsAsignacion" style="display:none">
						Seleccione un material y al menos un alumno antes de enviar.
					</span>
					<div class="ButtonsContainer">
						<div class="OkButton Button" onClick="checkSendAsignacion()" >Aceptar</div>
						<button id="OkButtomSimulateClick" style="display: none;"></button>
						<button onclick="window.open('http://localhost/pizarra/laravel/public/config/test');" class="AddButton Button">Aceptar</button>
						<div onClick="closeAlert()" class="CancelButton Button">Cancelar</div>
					</div>	
				</form>
			</div>													
		</div>		
	</div>
	<div class="ColorPickerContainer">
		<h5> Mano Alzada</h5>
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
				<img class="LineWidthModifier" onClick = "eraseCanvas()" src="images/eraser.png" heigth="20" width="20" id="eraser">
				<img src="images/A.png" heigth="20" width="20" id="type">
			</div>
		</div>
		<div class="WidthContainer">
			<h4>Dibujo:</h4>
			 <select id="dtool">
		        <option value="line">Linea</option>
		        <option value="rect">Rectangulo</option>
	        	<option value="pencil">Lápiz</option>
	        	<option value="circ">Circulo</option>
	        	<option value="text">Texto</option>
			</select>
		</div>
		<div class="WidthContainer">
			<h4>Edición:</h4>
			<div>
				<img class="LineWidthModifier" src="images/goRight.png" heigth="20" width="20" id="goRight">
				<img class="LineWidthModifier" src="images/goBack.png" heigth="20" width="20" id="goBack">
			</div>
		</div>
	</div>
	<div class="TempTypeText">
		Escriba un texto:<img onClick="closeAlert()" src="images/CloseButton2.png" height="15" id="closeButton4"><br>
		<input id="canvasText" type="text">
	</div>
	<div class="TypeContainer">
		<h5>Editor de texto</h5>
		<img onClick="closeAlert()" src="images/CloseButton2.png" height="20" id="closeButton3">
		<span>Tamaño:</span>
		 <select id="sizeTtool">
	        <option value="8px">8</option>
	        <option value="10px">10</option>
        	<option value="12px">12</option>
        	<option value="14px">14</option>
        	<option value="16px">16</option>
        	<option value="18px">18</option>
        	<option value="20px">20</option>
        	<option value="22px">22</option>
        	<option value="24px">24</option>
        	<option value="26px">26</option>
        	<option value="28px">28</option>
        	<option value="36px">36</option>
        	<option value="48px">48</option>
        	<option value="72px">72</option>
		</select>
		<span>Fuente:</span>
		 <select id="fontTtool">
	        <option value="verdana">verdana</option>
	        <option value="monospace">monospace</option>
        	<option value="cursive">cursive</option>
        	<option value="serif">serif</option>
        	<option value="fantasy">fantasy</option>
        	<option value="arial">arial</option>
        	<option value="arial">calibri</option>
		</select>
		<span>Tipo:</span>
		 <select id="typeTtool">
	        <option value="normal">normal</option>
	        <option value="italic">italic</option>
        	<option value="bold">bold</option>
		</select>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/dibujo.js"></script>
</body>
</html>