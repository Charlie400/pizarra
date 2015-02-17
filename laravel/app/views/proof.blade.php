<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	{{ Form::open(['route' => 'uploadDocument', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
		<input type="file" name="documento" />
		<button name="send">Enviar</button>
	{{ Form::close() }}
</body>
</html>