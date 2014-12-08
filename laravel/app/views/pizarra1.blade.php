<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Recording Canvas</title>
	<script type="text/javascript" src="{{ asset ('js/canvas.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/recorderjs/recorder.js') }}"></script>
	<script type="text/javascript" src="{{ asset ('js/recorderjs/recorderWorker.js') }}"></script>
</head>
<body>
	<canvas width="600" height="400" id="c"></canvas>
	<h2>Recording Canvas</h2>
	<button name="start" id="iniciar" onclick="iniciar()">Start</button>
	<button name="record" id="grabar" onclick="recordVideoAudio()">Grabar</button>
	<button name="stop" id="parar" onclick="stopRecordVideoAudio()">Parar</button>
</body>
</html>