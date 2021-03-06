; /*  AQUÍ SOLO SE ESCRIBIRÁN FUNCIONES QUE SIRVAN DE AYUDA AL RESTO DE ARCHIVOS, PERO NUNCA UNA FUNCIONALIDAD  */ 

//url del servidor
var serverURL = window.location.protocol+'//'+window.location.hostname+'/pizarra/laravel/public';

function empty(ids)
{
	var element;
	for (var i in ids)
	{
		element = document.getElementById(ids[i]);
		if (element.type != 'checkbox')
		{
			element.value = "";			
		}
		else
		{
			element.checked = false;
		}
	}
}

function cleanInnerHTML(id)
{
	document.getElementById(id).innerHTML = "";
}

function cleanClassInnerHTML(clase)
{
	var elements = document.getElementsByClassName(clase), i;

	for (i in elements)
	{
		elements[i].innerHTML = "";
	}
}

function setInnerHTML(id, value)
{
	document.getElementById(id).innerHTML = value;
}

function changeAction(formID, action)
{
	var form = document.getElementById(formID);

	if ( form && action && form.getAttribute('role') == 'form' )
	{
		form.action = serverURL + action;

		console.log(form.action);		

		return true;
	}

	return false;
}

//Encuentra un valor en un array y devuelve su índice
function findValue(array, value)
{	
	if ( typeof(value) )
	{
		if (typeof array.indexOf === 'function') return array.indexOf(value);
		else if(array instanceof Array)
		{
			for (i in array)
			{
				if (array[i] === value) return i;
			}
		}
	}

	return -1;	
}

function simulateClick(id)
{
	document.getElementById(id).click();
}

// Devuelve un array con las keys de un objeto o array
function getKeys(object, recursive, exceptDimension)
{
	// Comprobamos si es un objeto, en caso contrario retornamos null
	if ( typeof(object) !== 'object' ) return null;

	// Comprobamos si se ha pedido que se extraigan las keys de forma recursiva
	if (recursive) return getKeysRecursive(object, exceptDimension);

	// En keys almacenaremos las claves del objeto o array.
	var keys = [], i;

	// Añadimos al array las keys de la primera dimensión.
	for (i in object)
	{
		keys.push(i);
	}

	return keys;
}

/* 
* 	Devuelve las keys conseguidas de forma recursiva, también se puede decidir que una dimensión se ignore.
*/
function getKeysRecursive(object, exceptDimension, dimension)
{
	// Comprobamos si la variable object es un objeto.
	if ( typeof(object) !== 'object' ) return null;

	// Instanciamos las variables necesarias.
		// En keys almacenaremos las claves del objeto o array.
		// En getKeys guardaremos las keys obtenidas al volver a llamar a la función.
	var keys  = [], getKeys, 
	// Aquí almacenaremos la dimensión en la que nos encontramos, considerando a la primera como 1.
	dimension = dimension || 1,
	// La dimensión que queremos excluir, si no hay ninguna se asignará -1, así ninguna será excluida.
	exceptDimension   = exceptDimension || -1,
	// Comprobamos si hay que ignorar la dimesión actual
	saveThisDimension = exceptDimension != dimension;

	for (i in object)
	{
		if( saveThisDimension ) 
		{
			// Aquí entramos si está dimensión no será ignorada
			keys.push(i);
		}

		// Llamamos recursivamente a la función para obtener las keys del resto de dimensiones.
		getKeys = getKeysRecursive(object[i], exceptDimension, ++dimension);

		if ( ! isNull(getKeys) )
		{	
			// Aquí entramos para guardar las keys obtenidas de forma recursiva.
			for (k in getKeys)
			{
				keys.push(getKeys[k]);
			}
		}
	}

	return keys;
}

function isCheckbox(id)
{
	if (document.getElementById(id).type == 'checkbox')
	{
		return true;
	}

	return false;
}

function isNull(bar)
{
	return bar === null;
}

function isUndefined(bar)
{
	return bar === undefined;
}

function isEmpty(bar)
{
	bar = bar.replace(/ /g, '');

	if (bar === '') return true;
	
	return false;
}

function isNumeric(bar)
{
	return ! isNaN( parseFloat(bar) );
}

function isString(bar)
{
	return typeof(bar) === 'string';
}

function isChecked(id)
{
	if (isCheckbox(id))
	{
		return document.getElementById(id).checked;
	}

	return null;
}

function isArray(array)
{
	return array instanceof Array;
}

function arrayEmpty(array)
{	
	if (isArray(array))
	{
		return ! array.length > 0;
	}

	return null;
}

function css(id, property, value)
{
	document.getElementById(id).style[property] = value;
}

function typeTest(penaliza, multirespuesta, callback)
{
	if (penaliza) 
	{
		penaliza = 1;
		multirespuesta = 0;
	}
	else penaliza = 0;

	var ajax = new AjaxManager();

	ajax.request({
			url: '/tipos-de-test/' + penaliza + '/' + multirespuesta,
			success: function(response){
				callback(response);
			},
			errors: function(err)
			{
				console.log("Aquí tienes el error: " + err);
			}
		});	
}

/* En base al número de preguntas y respuestas debe darme las ids que por lógica le fueron asignadas */
function getPregResIds(respuestas, preguntas)
{
	var ids = {
		preguntas: [],
		respuestas: []
	};

	for (var i = 1; i <= preguntas; i++)
	{
		ids.preguntas.push('pregunta' + i);

		for (var a = 1; a <= respuestas; a++)
		{
			ids.respuestas.push('respuesta' + i + a);
		}
	}

	console.log(ids);

	return ids;
}

/*En base al número de pregunta y con el objeto generado en getPregResIds, te dirá cuales son las respuestas
  asociadas a esa pregunta*/
function getResForPreg(object, pregunta)
{
	var begin      = pregunta * 3 - 3,
		end        = pregunta * 3 - 1,
		respuestas = [];

	for (var i = begin; i >= begin && i <= end; i++)
	{
		respuestas.push(object.respuestas[i]);
	}

	console.log(respuestas);

	return respuestas;
}

function getDomainFoo(url, callback)
{
	var domain = getSelectedDomain(),
		ajax   = new AjaxManager();

	ajax.request({
			data: {"id_dominio": domain},
			url: url,
			responseType: 'json',
			success: function(response){
				//AQUI
				callback(response);
			},
			errors: function(err)
			{
				console.log("Aquí tienes el error: " + err);
			}
		});
}

//Trae a los usuarios pertenecientes al dominio seleccionado
function getDomainUsers(callback)
{
	getDomainFoo('/traer/dominio/usuarios', function(res){
		callback(res);
	});
}

//Trae a los materiales pertenecientes al dominio seleccionado
function getDomainMaterials(callback)
{
	getDomainFoo('/traer/dominio/materiales', function(res){
		callback(res);
	});
}


function getClassValues(clase)
{
	var clase  = document.getElementsByClassName(clase),
		count  = clase.length,
		values = [];

	for (var i = 0; i < count; i++)
	{
		values.push(clase[i].value);
	}

	return values;
}

function setClassValues(clase, value)
{
	var clase  = document.getElementsByClassName(clase),
		count  = clase.length;		

	for (var i = 0; i < count; i++)
	{
		clase[i].value = value;
	}	
}

function changeOnClick(id, checkFunction)
{
	var element;

	if ( element = document.getElementById(id) )
	{
		element.setAttribute('onClick', checkFunction);
		return true;
	}

	return false;
}

function changeValue(id, i, checkbox)
{
	var element = document.getElementById(id);

	if (checkbox)
	{
		console.log('dentro');
		if (element.value == '0')
		{			
			element.value = 1;
		}
		else
		{
			element.value = 0;
		}
	}
	else
	{
		console.log('fuera');
		var clase = 'checkradio' + i;
		
		setClassValues(clase, 0);

		element.value = 1;
	}

}

//Objeto ajaxManager

var ajaxManager = {
	constructData: function (id, names)
	{
		if (id instanceof Array)
		{
			var data, tmp, object = {}, 
			names = names || id;		

			for (i in id)
			{
				object[names[i]] = this.getValues(id[i]);
			}

			return object;
		}

		return null;
	},
	getValues: function (id)
	{
		return $('#' + id).val();
	},
	execute: function(url, data, method)
	{
		data   = data || {};
		method = method || 'POST';

		createAjaxRequest(data, url, '', '', '', method);
	},
	shotQuery: function(url, id, names)
	{
		var names = names || id,
		data      = this.constructData(id, names);

		if (data !== null)
		{
			this.execute(url, data);
			//createAjaxRequest(data, url, '', '', '', 'POST');
		}
	}
}

function proof()
{
	var names = ['firstname', 'lastname', 'username', 'nif', 'adress', 'locality', 'province', 'cp', 'phone', 'email', 'borndate', 'obs', 'password', 'password_confirmation'];
	var bar   = ajaxManager.constructData(names);
	alert(bar.lastname);
}

//setTimeout(function () { proof(); }, 5000);

//['firstname', 'lastname', 'username', 'nif', 'adress', 'locality', 'province', 'cp', 'phone', 'email', 'borndate', 'obs', 'password', 'password_confirmation'];

//Clase AjaxManager

function AjaxManager()
{
	var req = new XMLHttpRequest(),
		baseURL = 'http://localhost/pizarra/laravel/public',
	    defaultHeaders = {'Content-Type': 'application/x-www-form-urlencoded'},
		errors = {
					timeout: "Se ha superado el tiempo máximo de envio.(timeout)",
					url: "No se pudo conectar con la url proporcionada"
				 };			

	//Recibe los headers en forma de objecto y los asigna al objeto XMLHttpRequest
	this.headers = function(headers){		
		headers = headers || {};

		headers = this.defaultHeaders(headers);

		for (var i in headers)
		{
			req.setRequestHeader(i, headers[i]);
		}
	}

	//Comprueba si los headers imprescindibles están declarados y si no se les atribuye un valor por defecto
	this.defaultHeaders = function(headers){

		for (i in defaultHeaders)
		{
			if ( headers[i] === undefined ) headers[i] = defaultHeaders[i];
		}

		return headers;
	}

	//Obtiene los valores de un campo por medio de su id
	this.getValues = function(id){
		return document.getElementById(id).value;
	}

	//De un conjunto de ids y names obtiene los valores de los campos y los convierte en un objeto preparado para
	//enviarse con el método request
	this.constructData = function(id, names){

		if (id instanceof Array)
		{
			var data, tmp, object = {}, 
			names = names || id;		

			for (i in id)
			{
				object[names[i]] = this.getValues(id[i]);
			}

			return object;
		}

		return null;
	}

	//Desglosa la data en un string preparado para enviarse vía Ajax
	this.processData = function(data){
		data = data || {};

		if (typeof data === typeof {})
		{
			var tmp = data;
			data = '';

			for (i in tmp)
			{
				data += i + '=' + tmp[i] + '&'; 
			}			
		}

		return data;
	}

	//Atribuye un tiempo máximo a la ejecución del script, si se cumple lanzará un error y abortará el envío
	this.timeout = function(miliseconds, err){
		miliseconds = miliseconds || 1000;

		var self = this;

		setTimeout(function(){

			self.errors(err);
			req.abort();

		}, miliseconds);
	}

	//Da la respuesta en el formato que le indique teniendo por defecto el tipo "text"
	this.response = function(responseType){
		responseType = responseType || 'text';

		switch(responseType.toLowerCase()){
			case 'text':
				return req.responseText;
			case 'json':
				return JSON.parse(req.responseText);
			case 'xml':
				return req.responseXML;
			default:
				return null;
		};
	}

	//Envía los errores a la función errors declara en el objeto para poder manejar el error
	this.errors = function(err)
	{		
		if(req.readyState !== 4) err(errors.timeout);
		else if(req.status !== 200) err(errors.url);	
	}

	/*
		Unifica muchos de los métodos recogidos en esta clase para enviar los datos mediante un objeto con las
		siguientes características:
			
		{
			data: {ejemplo: "Esto es un ejemplo", ejemplo2: "Esto es un segundo ejemplo"},
			method: method,
			url: url,
			processData: true,
			responseType: 'text',
			headers: {header: value},
			success: function(response){
				console.log(response);
			},
			errors: function(err)
			{
				console.log("Aquí tienes el error: " + err);
			}
		}
	*/
	this.request = function(object){
		object.method = object.method || 'POST';
		object.processData = typeof(object.processData) || true;

		if (object.processData) object.data = this.processData(object.data);

		req.open(object.method, baseURL + object.url);

		this.headers(object.headers);

		this.timeout(object.timeout, object.errors);

		req.send(object.data);

		var self = this;

		req.onreadystatechange = function ()
        {
            if (req.readyState === 4 && req.status === 200)
            { 
                object.success(self.response(object.responseType));
            }
        }; 
	}
}