; /*  AQUÍ SOLO SE ESCRIBIRÁN FUNCIONES QUE SIRVAN DE AYUDA AL RESTO DE ARCHIVOS, PERO NUNCA UNA FUNCIONALIDAD  */ 

function isEmpty(bar)
{
	bar = bar.replace(/ /g, '');

	if (bar === '') return true;
	
	return false;
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

		object.data = this.processData(object.data);

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