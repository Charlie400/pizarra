; /*  AQUÍ SOLO SE ESCRIBIRÁN FUNCIONES QUE SIRVAN DE AYUDA AL RESTO DE ARCHIVOS, PERO NUNCA UNA FUNCIONALIDAD  */ 

function isEmpty(bar)
{
	bar = bar.replace(/ /g, '');

	if (bar === '') return true;
	
	return false;
}

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