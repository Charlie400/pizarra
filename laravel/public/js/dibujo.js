
var canvasn, contextt, canvaso, contexto, img;
var sGrosor = 3;
var sLastColorPicked = '#000000';
var sPintarActivo = true;
var sEscribirActivo = true;
var sFormatText = "normal 12px verdana";
var sX;
var sY;

if(window.addEventListener) {
window.addEventListener('load', function () {
  

  // Herramienta activa al comenzar
  var tool;
  var tool_default = 'line';

  function init () {
    // Find the canvas element.
    canvaso = document.getElementById('c');
    if (!canvaso) {
      alert('Error: I cannot find the canvas element!');
      return;
    }

    if (!canvaso.getContext) {
      alert('Error: no canvas.getContext!');
      return;
    }

    // Obtiene el 2d del canvas
    contexto = canvaso.getContext('2d');
    if (!contexto) {
      alert('Error: failed to getContext!');
      return;
    }

    // Añade Canvas Temporal
    var container = canvaso.parentNode;
    canvasn = document.createElement('canvas');
    if (!canvasn) {
      alert('Error: I cannot create a new canvas element!');
      return;
    }

    canvasn.id     = 'imageTemp';
    canvasn.width  = canvaso.width;
    canvasn.height = canvaso.height;
    container.appendChild(canvasn);

    contextt = canvasn.getContext('2d');

    // Obtiene la herramienta seleccionada
    var tool_select = document.getElementById('dtool');
    if (!tool_select) {
      alert('Error: failed to get the dtool element!');
      return;
    }
    tool_select.addEventListener('change', ev_tool_change, false);

    // Se activa la herramienta por defecto
    if (tools[tool_default]) {
      tool = new tools[tool_default]();
      tool_select.value = tool_default;
    }

    // Eventos
    canvasn.addEventListener('mousedown', ev_canvas, false);
    canvasn.addEventListener('mousemove', ev_canvas, false);
    canvasn.addEventListener('mouseup',   ev_canvas, false);
  }

  // Determina la posición relativa del canvas. Propósito genera: event handler.
  function ev_canvas (ev) {
    if (ev.layerX || ev.layerX == 0) { // Firefox
      ev._x = ev.layerX;
      ev._y = ev.layerY;
    } else if (ev.offsetX || ev.offsetX == 0) { // Opera
      ev._x = ev.offsetX;
      ev._y = ev.offsetY;
    }

    // Llama al handler de la herramienta
    var func = tool[ev.type];
    if (func) {
      func(ev);
    }
  }

  // El 'event handler' para los cambios en la herramienta de selección.
  function ev_tool_change (ev) {
    if (tools[this.value]) {
      tool = new tools[this.value]();
    }
  }

  // Esta función pinta #imageTemp canvas encima de #c, después de que 
  // #imageTemp es borrado. Esta función se  llama cada vez que el usuario  
  // complete una función de pintado.
  function img_update () {
    contexto.drawImage(canvasn, 0, 0);
    contextt.clearRect(0, 0, canvasn.width, canvasn.height);
  }

  // Este objeto guarda la implementación para cada herramienta de pintado
  var tools = {};


  // El lápiz de pintar
  tools.pencil = function () {
    var tool = this;
    this.started = false;

    // Comienza cuando pulsas el botón del ratón
    // Comienza el pintar del lápiz
    this.mousedown = function (ev) {
        contextt.beginPath();
        contextt.moveTo(ev._x, ev._y);
        tool.started = true;
    };

    // Esta función es llamada cada vez que se mueve el ratón. Obviamente 
    // dibuja si el estado de tool.starder está a true(cuando se pulsa el botón del ratón)
    this.mousemove = function (ev) {
      if (tool.started) {
      if(!sPintarActivo){
        return;
      }
        contextt.lineTo(ev._x, ev._y);
        contextt.stroke();
      }
    };

    this.mouseup = function (ev) {
      if (tool.started) {
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };
  };

  $('#canvasText').change(TypeText);
   function TypeText(){
    contextt.font = sFormatText;
    contextt.fillText($('#canvasText').val(), sX, sY);
    img_update();
  }

//Herramienta texto
tools.text = function () {
  var tool = this;

  this.started = false;

  this.mousedown = function (ev) {
    tool.started = true;
    tool.x0 = ev._x;
    tool.y0 = ev._y;
  };

  this.mousemove = function (ev) {
    if (!tool.started) {
      return;
    }

    if(!sEscribirActivo){
      return;
    }

    var x = Math.min(ev._x,  tool.x0),
        y = Math.min(ev._y,  tool.y0),
        w = Math.abs(ev._x - tool.x0),
        h = Math.abs(ev._y - tool.y0);

    contextt.clearRect(0, 0, canvasn.width, canvasn.height);

    if (!w || !h) {
      return;
    }

    contextt.strokeRect(x, y, w, h);
    sX = x;
    sY = y;
  };

  this.mouseup = function (ev) {
    if (tool.started) {
      tool.mousemove(ev);
      tool.started = false;
      contextt.clearRect(0, 0, canvasn.width, canvasn.height);
      $('.TempTypeText').show();
      $('.TempTypeText').draggable();
      $('#canvasText').val('');
    }
  };
};


// Herramienta de círculo
  tools.circ = function () {
    var tool = this;
    this.started = false;

    this.mousedown = function (ev) {
      tool.started = true;
      tool.x0 = ev._x;
      tool.y0 = ev._y;
      contextt.beginPath();
    };

    this.mousemove = function (ev) {
      if (!tool.started) {
        return;
      }

      if(!sPintarActivo){
        return;
      }

      var x = Math.min(ev._x,  tool.x0),
          y = Math.min(ev._y,  tool.y0),
          w = Math.abs(ev._x - tool.x0),
          h = Math.abs(ev._y - tool.y0);

      canvasn.width = canvasn.width;
      
      if (!w || !h) {
        return;
      }

      contextt.strokeStyle = sLastColorPicked;
      contextt.arc(x + (w/2), y + (h/2), w/2, 0, Math.PI*2, false);
      contextt.lineWidth = sGrosor;
      contextt.stroke();

    };

    this.mouseup = function (ev) {
      if (tool.started) {
        contextt.stroke();
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };
  };

  // Herramienta de rectángulo
  tools.rect = function () {
    var tool = this;
    this.started = false;

    this.mousedown = function (ev) {
      tool.started = true;
      tool.x0 = ev._x;
      tool.y0 = ev._y;
    };

    this.mousemove = function (ev) {
      if (!tool.started) {
        return;
      }

      if(!sPintarActivo){
        return;
      }

      var x = Math.min(ev._x,  tool.x0),
          y = Math.min(ev._y,  tool.y0),
          w = Math.abs(ev._x - tool.x0),
          h = Math.abs(ev._y - tool.y0);

      contextt.clearRect(0, 0, canvasn.width, canvasn.height);

      if (!w || !h) {
        return;
      }

      contextt.strokeRect(x, y, w, h);
    };

    this.mouseup = function (ev) {
      if (tool.started) {
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };
  };

  // Herramienta línea
  tools.line = function () {
    var tool = this;
    this.started = false;



    this.mousedown = function (ev) {
      tool.started = true;
      tool.x0 = ev._x;
      tool.y0 = ev._y;
    };

    this.mousemove = function (ev) {
      if (!tool.started) {
        return;
      }

      if(!sPintarActivo){
        return;
      }

      contextt.clearRect(0, 0, canvasn.width, canvasn.height);
      contextt.beginPath();
      contextt.moveTo(tool.x0, tool.y0);
      contextt.lineTo(ev._x,   ev._y);
      contextt.stroke();
      contextt.closePath();
    };

    this.mouseup = function (ev) {
      if (tool.started) {
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };

    sPintarActivo = false;

  };

  init();

}, false); }


$('.ColorPicker').on('click', cambiarColor);

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function cambiarColor(){
  contextt.strokeStyle = rgb2hex($(this).css('background-color'));
  sLastColorPicked = rgb2hex($(this).css('background-color'));
}
 
$('#mas').on('click', cambiaTrazado);
$('#menos').on('click', cambiaTrazado);

function cambiaTrazado(){

  var sValor = $(this).attr('id')
  var sSuma;

  if (sValor == "mas"){
    sSuma = sGrosor + 1
    if (sSuma <21){
      contextt.lineWidth= sSuma;
    }
  }else if(sValor == "menos"){
    sSuma = sGrosor - 1
    if (sSuma > 0){
      contextt.lineWidth= sSuma;
    }
  }

  sGrosor = sSuma;
}

var clickImage = $(".clickImage").click(insertImageToCanvas);
//Dado que al cargar por primera vez esta función aún no existen los escenarios porque no se ha seleccionado clase ni
//dominio lo definiremos en una variable para luego redefinirlo con los datos reales cargados en escenarios y elementos
//esto se hará en la función showMenuImages de script.js

function insertImageToCanvas(){
  img = $(this);
  contexto.drawImage(img[0],0,0);
}


/*------------------------ FUNCIONAL MOVER OBJETOS PIZARRA ----------------------------*/
function canvasElement(capa, tipo, camino, coordenadas, puntos, circulo, elemento) { 
  this.capa = capa;
  this.tipo = tipo;
  this.camino = camino;
  this.coordenadas = coordenadas;
  this.puntos = puntos;
  this.circulo = circulo;
  this.elemento = elemento;
};


/*-------------------------------------------------------------------------------------*/
function eraseCanvas(){
  if(confirm('¿Seguro que desea borrar la pizarra?')){

   contexto.clearRect(0, 0, canvaso.width, canvaso.height);
   
  }else{
    return false;
  }
  
}

$('#pencil').on('click', ActivarPintar);

function ActivarPintar(){
  sPintarActivo = true;
}

$('#type').on('click', ActivarEscribir);

function ActivarEscribir(){
  sEscribirActivo = true;
}

$('#sizeTtool').change(TextSize);

function TextSize(){
  var sCadena = sFormatText.split(' ');
  sFormatText = sCadena[0] + " " + $("#sizeTtool option:selected").text() +  "px" + " " + sCadena[2];
}

$('#fontTtool').change(TextFont);

function TextFont(){
  var sCadena = sFormatText.split(' ');
  sFormatText = sCadena[0] + " " + sCadena[1] + " " + $("#fontTtool option:selected").text();
}

$('#typeTtool').change(TextTypeFun);

function TextTypeFun(){
  var sCadena = sFormatText.split(' ');
  sFormatText = $("#typeTtool option:selected").text() + " " + sCadena[1] + " " + sCadena[2];
}



