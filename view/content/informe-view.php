<style>
	#tale_id tr td {
		color: white !important;
	}
</style>

<div class="main container rounded p-4" style="overflow-x: scroll; background-color: #f1f1f1eb;">

	<table id="tablaInforme" class="table display">
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

		obtenerTareas();

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
					const tablaInforme = new DataTable('#tablaInforme', {
						responsive: 'true',
						dom: 'Bfrtilp',
						buttons: [{
								extend: 'excelHtml5',
								text: '<i class="fas fa-file-excel"></i>',
								titleAttr: 'Exportar a Excel',
								type: 'button',
								className: 'btn btn-success bg-success',
							},
							{
								extend: 'pdfHtml5',
								text: '<i class="fas fa-file-pdf"></i>',
								titleAttr: 'Exportar a PDF',
								type: 'button',
								className: 'btn btn-danger bg-danger'
							},
							{
								extend: 'print',
								text: '<i class="fas fa-print"></i>',
								titleAttr: 'Imprimir',
								type: 'button',
								className: 'btn btn-info bg-secondary'
							}
						],
						language: {
							lengthMenu: 'Mostrar _MENU_ registros',
							zeroRecords: 'No se encontraron resultados',
							info: 'Registros en total - _TOTAL_',
							infoEmpty: '0 registros',
							infoFiltered: '(filtrado de un total de _MAX_ registros)',
							sSearch: 'Buscar:',
							oPaginate: {
								sFirst: 'Primero',
								sLast: 'Último',
								sNext: 'Siguiente',
								sPrevious: 'Anterior',
							},
							sProcessing: 'Procesando...',
						},
						aaData: phpJsonRes.body,
						columns: [{
								"data": "descripcion"
							},
							{
								"data": "categoria"
							},
							{
								"data": "subcategoria"
							},
							{
								"data": "fecha"
							}
						]
					});

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