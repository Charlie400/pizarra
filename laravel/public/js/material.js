//Trae un material de la base de datos por su id
function getMaterial(id, callback)
{
	var ajax = new AjaxManager();

	ajax.request({
					url: '/traer/material/' + id,
					responseType: 'json',
					success: function(response){
						callback(response);
						console.log(response);
					},
					errors: function(err)
					{
						console.log("Aquí tienes el error: " + err);
					}
				});
}

//Rellena los campos de la asignación con un material obtenido en base a una id
function fillWithAsignacion(id)
{
	var material = getMaterial(id, function(material){

		$('#foo81').val(material.titulo);
		$('#foo82').val(material.descripcion);
		$('#foo86').val(material.desde);
		$('#foo87').val(material.hasta);
		if(material.visible) $('#foo88').prop('checked', 'checked');
		if(material.examen) $('#foo88').prop('checked', 'checked');

	});

}