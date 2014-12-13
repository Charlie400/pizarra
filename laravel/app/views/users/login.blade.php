<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html lang="es">
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Pizarra</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:500,300,700,400' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="LoginContainer">
		<h1 class="TituloLogin">LOGIN</h1>
		{{ Form::open(['route' => 'login', 'class' => 'Login', 'method' => 'POST', 'role' => 'form']) }}
			{{ Field::text('username', null, ['input' => ['class' => 'input', 'placeholder' => 'Usuario'], 
			'label' => ['style' => 'display: none']]) }}
			{{ Field::password('password', ['input' => ['class' => 'input', 'placeholder' => 'Contraseña'], 
			'label' => ['style' => 'display: none']]) }}
			<input type="submit" name="Boton1" value="Entrar"/>
		{{ Form::close() }}
	</div>
</body>
</html>