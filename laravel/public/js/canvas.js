;
var recording = false, serverURL = window.location.protocol+'//'+window.location.hostname+'/pizarra/laravel/public';

function getElementById(id)
{
    return document.getElementById(id);
}

function recordVideoAudio()
{
    /*------------------RECORDING VIDEO AND AUDIO--------------------*/

    if ( ! recording)
    {
        audioRecording(); 
        recording = true;
    }
        
};

function stopVideoAudio()
{
    if (recording)
    {
        clearInterval(record);  
        stopAudioRecording();
        recording = false;
    }
       
}

/*------------------GETTING CANVAS SNAPSHOT--------------------*/

var imageId;

function getCanvasSnapshot()
{
    var snapshot   = getDataURL(), url = serverURL+'/save-snapshot', data, req,
        id_dominio = getSelectedDomain();

    if ( ! isEmpty(id_dominio) )
    {

        req  = createXMLHttpRequest('post', url, 'application/x-www-form-urlencoded');

        data = 'data='+encodeURIComponent(snapshot)+'&limit=1&packages=1&id_dominio=' + id_dominio;

        req.send(data);

        req.onreadystatechange = function () {
                                    if (req.readyState === 4 && req.status === 200)
                                    {
                                        imageId  = req.responseText;
                                        var slug = '/snapshots/' + imageId + '.png';
                                        saveSnapshot();

                                        document.getElementById("foo72").addEventListener("click", function(){
                                            downloadFile(slug);
                                            closeAlert();
                                        });
                                        
                                    }   
                                }
    }
    else
    {
        alert('Debes seleccionar un dominio.');
    }
}

function deleteSnapshot()
{
    var ajax = new AjaxManager();

    ajax.request({
            url: '/delete-snapshot/' + imageId,
            success: function()
            {
                closeAlert();
            },
            errors: function(err)
            {
                console.log("Aquí tienes el error: " + err);
            }
        });
}

//DOWNLOADS FUNCTION
function downloadFile(dir)
{       
    window.location.href = serverURL + '/descargar' + dir;
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
    var canvas = getElementById('c');

    return canvas.toDataURL();
}

function getFrames()
{    
    var data = getDataURL();
      
    frames.push(data);
}


/*------------------STOP RECORDING AND GETTING VIDEO--------------------*/

function stopSequenceRecording()
{
    a = 0;       
    if (frames.length > 0)
    {
        /*------------------GETTING URL FROM PHP METHOD FOR CREATE A VIDEO--------------------*/
        url = serverURL+'/save-video';        

        sendWithAjax('post', url, 'application/x-www-form-urlencoded', 0, "");        
    }
}

var stream = false, rec;

function audioRecording() {
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

    //Tras iniciar el recorder de audio iniciamos la captura de frames del canvas
    sequenceRecording();
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

        sendWithAjax('POST', url, 'application/x-www-form-urlencoded', 0, e);

    //Recorder.forceDownload(e, "filename.wav");
        stream = false;  
    });

}

var a = 0;

function sendWithAjax(method, url, header, b, archivo)
{

    var req = createXMLHttpRequest(method, url, header), data;    

    if (archivo == "")
    {
        //Aquí entramos cuando tenemos que guardar la secuencia de imágenes   
        var limit = parseInt(frames.length-1), perPackage = 200, 
        packages  = Math.ceil(limit/perPackage), data = '';

        console.log(limit);        

        for (var i = 0; i < perPackage && a <= limit; i++)
        {
            data += encodeURIComponent(frames[a]);            
            frames[a] = null; 
            ++a;
        }

        data = 'data='+data+'&limit='+limit+'&packages='+b;

        ++b;  

        /*------------------HEADERS--------------------*/      

        req.setRequestHeader('processData', false);
        req.setRequestHeader('cache', false);
        //req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

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
            req.onreadystatechange = function ()
            {                                
                if (req.readyState === 4 && req.status === 200)
                {

                    saveRecord();
                    document.getElementById("foo72").addEventListener("click", function(){
                        downloadFile('/video/vid.avi');
                    });
                    
                    frames.length = 0;
                    a = 0;
                    //Aquí se reactiva el botón de grabar
                    console.log('TERMINADO');
                }
            };
        }
    }
    else
    {
        //Aquí entramos para guardar el audio
        reader  = new FileReader();         

        reader.onload = function (e) 
        {
        // Enviamos el contenido del archivo de audio y lo codificamos para evitar errores al enviar vía HTTP
            data = reader.result;

            sendAudio(data, method, url, header);                    
            
        };

        // Leemos el archivo
        // reader.readAsDataURL(archivo); 
        reader.readAsBinaryString(archivo);

        // var web = (window.URL || window.webkitURL).createObjectURL(archivo);       
        // console.log(web);
    }

}

function sendAudio(data, method, url, header, length, perPackage, packages, b)
{
    if ( ! working)
    {
        working = true;
        if (isNaN(b)) 
        {     
            var length = data.length,
            perPackage = 2000000,
            packages   = Math.ceil(parseInt(length)/perPackage),
            b = 0;
        }

        var req = createXMLHttpRequest(method, url, header),
        part = data.slice(perPackage * b, perPackage * (b + 1));

        ++b;

        req.setRequestHeader('processData', false);
        req.setRequestHeader('cache', false);
        //req.setRequestHeader('Content-Type', false);

        part = btoa(part);
        part = 'data:audio/wav;base64,' + part;

        req.send('sound=' + encodeURIComponent(part) + '&current=' + b /*+ '&packages=' + packages*/);

        if (b < packages)
        {

            req.onreadystatechange = function ()
            {
                if (req.readyState === 4 && req.status === 200)
                { 
                    working = false;              
                    sendAudio(data, method, url, header, length, perPackage, packages, b);
                }
            }; 
        }
        else
        {            
            req.onreadystatechange = function ()
            {
                if (req.readyState === 4 && req.status === 200)
                {    
                    working = false;             
                    stopSequenceRecording();
                }
            }; 
        }           
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