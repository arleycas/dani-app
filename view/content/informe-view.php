<style>
	#tale_id tr td {
		color: white !important;
	}
</style>

<div class="main container">

	<table id="tablaInforme" class="table display" style="background-color: oldlace;">
		<thead>
			<tr>
				<th scope="col">Descripción</th>
				<th scope="col">Categoría</th>
				<th scope="col">Subcategoría</th>
				<th scope="col">Fecha</th>
			</tr>
		</thead>
		<tbody id="tablaBody">
		</tbody>
	</table>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// title de la página para que quede así el nombre del informe
		const hoy = new Date()
		fechaHoy = `${hoy.getFullYear()}${hoy.getMonth()+1}${hoy.getDate()}`
		document.querySelector('#tituloPagina').innerHTML = `Informe${fechaHoy}`;

		// obtenerTareas();

		const tablaInforme = new DataTable('#tablaInforme', {
			responsive: 'true',
			dom: 'Bfrtilp',
			buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fas fa-file-excel"></i>',
					titleAttr: 'Exportar a Excel',
					className: 'btn btn-success',
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fas fa-file-pdf"></i>',
					titleAttr: 'Exportar a PDF',
					className: 'btn btn-danger'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print"></i>',
					titleAttr: 'Imprimir',
					className: 'btn btn-info'
				}
			],
			ajax: {
				url: '<?php echo SERVERURL; ?>ajax/tarea-ajax.php',
				// dataSrc: function(obj) {
				// 	//const body = d;
				// 	// console.log('body', body);
				// 	return obj;

				// 	document.querySelector('#tablaBody').innerHTML = `
				// 	<tr> 
				// 		<td> ${obj.body[0].descripcion} </td>
				// 		<td> ${obj.body[0].categoria} </td>
				// 		<td> ${obj.body[0].subcategoria} </td>
				// 		<td> ${obj.body[0].fecha} </td>
				// 	</tr>`;
				// },
				dataSrc: 'body',
				method: 'POST',
				data: {
					tipoForm: 'read',
					rTareasInforme: 'rTareasInforme'
				}
			},
			// ajax: function(data, callback, settings) {
			// 	console.log('data', data);
			// 	console.log('settings', settings);
			// 	settings.ajax.
			// 	callback(
			// 		JSON.parse(localStorage.getItem('dataTablesData'))
			// 	);
			// },
			columns: [{
					body: 'descripcion'
				},
				{
					body: 'categoria'
				},
				{
					body: 'subcategoria'
				},
				{
					body: 'fecha'
				}
			]

		});



	});

	function obtenerTareas() {

		let dataForm = new FormData();

		dataForm.append('tipoForm', 'read');
		dataForm.append('rTareasInforme', 'rTareasInforme');

		let header = new Headers();
		header.append('Content-Type', 'text/html; charset=utf-8');
		let config = {
			method: 'POST',
			header,
			mode: 'cors',
			cache: 'no-cache',
			body: dataForm
		}

		fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
			.then(res => res.json())
			.then(phpJsonRes => {

				if (phpJsonRes.res == 'ok') {
					//document.querySelector('.char-list').innerHTML = phpJsonRes.body;

					// document.querySelector('#tablaBody').innerHTML = phpJsonRes.body;

					console.log(phpJsonRes.body);

				} else {
					//msgLogin.style.display = 'block'
					if (phpJsonRes.res == 'fail') {
						Swal.fire({
							icon: 'error',
							text: 'No se pudieron traer las tareas!'
						});
						console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
					} else if (phpJsonRes.res == 'nadaOk') {
						Swal.fire({
							icon: 'info',
							text: 'No hay datos con esa consulta!'
						});
						console.log('Query: ', phpJsonRes.queryString, '\nLugar: ', phpJsonRes.lugar);
					} else {
						Swal.fire({
							icon: 'error',
							text: 'No hubo respuesta del servidor al traer las tareas!'
						});
					}

					//Reestablecer texto botón

				}
			}); //Fin promesa

	}
</script>