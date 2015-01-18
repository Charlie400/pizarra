
var canvasn, contextt, canvaso, contexto;
var sGrosor = 3;
var sLastColorPicked = '#000000'
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
    // the mouse button).
    this.mousemove = function (ev) {
      if (tool.started) {
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
 
$('.LineWidthModifier').on('click', cambiaTrazado)

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

  sGrosor = sSuma
}

$('.clickImage').on('click', insertImageToCanvas);

function insertImageToCanvas(){
  var img = new Image();
  img.src = "images/fondo1.jpg";
  contexto.drawImage(img,0,0);
}