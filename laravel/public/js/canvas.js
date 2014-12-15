;
window.onload = function() {var botonGrabar = document.getElementById("botonGrabar")};
var recording = false, serverURL = location.protocol+'//'+location.hostname+'/pizarra/laravel/public';

function recordStopVideoAudio()
{
    if (recording)
    {
        /*------------------RECORDING VIDEO AND AUDIO--------------------*/

        clearInterval(record);  
        stopAudioRecording(); 
        recording = false;

        botonGrabar.value = "Grabar";
    }
    else
    {
        /*------------------STOP RECORDING VIDEO AND AUDIO--------------------*/

        audioRecording();
        sequenceRecording();
        recording = true;

        botonGrabar.value = "Grabando...";
    }
}

/*------------------GETTING CANVAS SNAPSHOT--------------------*/

function getCanvasSnapshot()
{
    var snapshot = getDataURL(), url = serverURL+'/image-sequence', data, req;
    
    req  = createXMLHttpRequest('post', url, 'application/x-www-form-urlencoded');

    data = 'data='+encodeURIComponent(snapshot)+'&limit=1&packages=1';

    req.send(data);
}

/*------------------RECORDING CANVAS IMAGES AND STORING IN ARRAY--------------------*/

var frames = [], record;

function sequenceRecording()
{
    var mSecond = 1000/30; //1000ms/30frames          
    record = setInterval(getFrames, mSecond); 
}

function getDataURL()
{
    return document.getElementById('c').toDataURL();
}

function getFrames()
{    
    var data = getDataURL();
      
    // data = data.split(',')[1];
    // data = data.trim();
    frames[a++] = data; 
}


/*------------------STOP RECORDING AND GETTING VIDEO--------------------*/

function stopSequenceRecording()
{
    a = 0;       
    if (frames.length > 0)
    {
        /*------------------GETTING URL FROM PHP METHOD FOR CREATE A VIDEO--------------------*/
        url = serverURL+'/image-sequence';

        getEncodeURIArray(frames);

        sendWithAjax('post', url, 'application/x-www-form-urlencoded', 0, "");        
    }
    else
    {
        alert("Debes grabar primero");
    }
}

var stream = false, rec;

function audioRecording() {
    if (stream) {
        // Parar
        document.getElementById('proof').value = 'Grabar';
        recorder.getRecordedData(EnviarPorAjax);
    } 
    else 
    {
        navigator.getUserMedia = (
            navigator.getUserMedia || 
            navigator.webkitGetUserMedia || 
            navigator.mozGetUserMedia || 
            navigator.msGetUserMedia
        );

        if (navigator.getUserMedia) 
        {
            navigator.getUserMedia({audio: true}, audioMicrophoneGranted,
            function (){console.warn('Error getting audio stream from getUserMedia, have you connected the'+
            ' camera and microphone?')});
        };
    }
}

function audioMicrophoneGranted(e)
{
    stream = e;
     // creates the audio context
    audioContext = window.AudioContext || window.webkitAudioContext;
    context      = new audioContext();
 
    // creates an audio node from the microphone incoming stream
    audioInput = context.createMediaStreamSource(e);
 
    rec = new Recorder(audioInput, {
        workerPath: serverURL+'/js/recorderjs/recorderWorker.js'
    });
 
    rec.record();
}

function stopAudioRecording() {
    // stop the media stream
    stream.stop();

    // stop Recorder.js
    rec.stop();

      // export it to WAV
    rec.exportWAV(function(e){ 

        rec.clear();

        var url = serverURL+'/save-audio';

        sendWithAjax('post', url, 'application/x-www-form-urlencoded', 0, e);

    //Recorder.forceDownload(e, "filename.wav");
    });    
}

var a = 0, play = true;

function sendWithAjax(method, url, header, b, archivo)
{

    var req = createXMLHttpRequest(method, url, header), data;    

    if (archivo == "")
    {
        // Aquí entramos cuando tenemos que guardar la secuencia de imágenes   
        var limit = parseInt(frames.length-1), name = '&data0=', perPackage = 200, 
        packages  = Math.ceil(limit/perPackage);

        console.log(limit);        

        for (var i = 0; i < perPackage && i <= limit; i++)
        {
            name = '&data'+a+'=';
            data = data+name+frames[a];            
            frames[a] = null; 
            ++a;
        }

        data = data+'&limit='+limit+'&packages='+b;

        ++b;        

        /*------------------SENDING DATA--------------------*/

        req.send(data);

        data = null;

        if (b < packages)
        {
            req.onreadystatechange = function ()
            {
                if (req.readyState === 4 && req.status === 200)
                {
                    sendWithAjax('post', url, 'application/x-www-form-urlencoded', b, "");
                }
            };
        }
        else
        {

            frames.length = 0;
        }
    }
    else
    {
        //Aquí entramos para guardar el audio
        reader  = new FileReader();              

        reader.onload = function (e) 
        {
        // Enviamos el contenido del archivo de audio y lo codificamos para evitar errores al enviar vía HTTP
            data = encodeURIComponent(reader.result);
            req.send( 'sound=' + data );
        };


        // Leemos el archivo
        reader.readAsDataURL(archivo);

        req.onreadystatechange = function ()
        {
            if (req.readyState === 4 && req.status === 200)
            {
                stopSequenceRecording();
            }
        }; 
    }

}
function createXMLHttpRequest(method, url, header)
{
    //Creamos el objeto AJAX
    var xmlHttpRequest = new XMLHttpRequest();

    //Abrimos la conexión con el servidor
    xmlHttpRequest.open(method, url);

    //Seleccionamos un header
    xmlHttpRequest.setRequestHeader("Content-Type", header); //Cuando usar multipart/form-data "http://stackoverflow.com/questions/4526273/what-does-enctype-multipart-form-data-mean"

    return xmlHttpRequest;
}

function getEncodeURIArray(array)
{
    for (i in array)
    {
        array[i] = encodeURIComponent(array[i]);
    }

    return array;
}