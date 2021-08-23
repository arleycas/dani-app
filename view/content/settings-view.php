<div class="main cantainer">
    <h2 class="text-white text-center">Configuraciones</h2>

    <h4 class="text-white"><i class="fas fa-minus-circle"></i>Borrar Sub y Categorías</h4>

		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-md-5">
					<label class="text-white" for="selCategoria">Categorías</label>
					<select name="selCategoria" id="selCategoria">
							<option value="" selected>Elije Categoría...</option>
					</select>
					<button class="btn btn-primary btn-swal-dcate">Eliminar</button>
				</div>

				<div class="col-sm-8 col-md-5">
					<label class="text-white" for="selSubcategoria">Subcategorías</label>
					<select name="selSubcategoria" id="selSubcategoria">
							<option value="" selected>Elije subcategoría...</option>
					</select>
					<button class="btn btn-primary btn-swal-dsubcate">Eliminar</button>
				</div>
			</div>
		</div>

</div>

<script>
  /* -------- Fn. Carga inicial de la página -------- */
  document.addEventListener('DOMContentLoaded', function() {
  
    initEscuchaElementos();
    rellenarListas()
	})

	function initEscuchaElementos() {
		//Escucha a botones para sacar Swal de confirmación eliminación de categoria

		document.querySelector('.btn-swal-dcate').addEventListener('click', (e) => {

			let selectCategoria = document.querySelector('#selCategoria');
			let catId = selectCategoria.value;
			let catNombre = selectCategoria.options[selectCategoria.selectedIndex].text; //Obtener texto del option seleccionado
			
			if((catId === '') || (catId ===  null)) {} else {

				Swal.fire({
					title: `¿Segura que quieres eliminar la categoría <span style="color: #de2b2b"> ${catNombre} </span>?`,
					text: 'No podrás recuperarla luego',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Si, borrala!',
					imageUrl: '<?php echo SERVERURL . 'view/assets/img/kiki01.gif';?>',
					imageWidth: 250,
					imageHeight: 150,
					imageAlt: 'Kiki carga',
				}).then((result) => {
					if (result.isConfirmed) {
						eliminarCategoria(catId);
					}
				})
			}

		}); //Fin escucha botones Swal eliminar tarea

		document.querySelector('.btn-swal-dsubcate').addEventListener('click', (e) => {

			const selectSubCategoria = document.querySelector('#selSubcategoria');
			let subCatId = selectSubCategoria.value;
			let subCatNombre = selectSubCategoria.options[selectSubCategoria.selectedIndex].text; //Obtener texto del option seleccionado
			
			if((subCatId === '') || (subCatId ===  null)) {} else {

				Swal.fire({
					title: `¿Segura que quieres eliminar la subcategoría <span style="color: #de2b2b"> ${subCatNombre} </span>?`,
					text: 'No podrás recuperarla luego',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Si, borrala!',
					imageUrl: '<?php echo SERVERURL . 'view/assets/img/kiki01.gif';?>',
					imageWidth: 250,
					imageHeight: 150,
					imageAlt: 'Kiki carga',
				}).then((result) => {
					if (result.isConfirmed) {
						eliminarSubcategoria(subCatId);
					}
				})
			}

		}); //Fin escucha botones Swal eliminar tarea
	}

	function rellenarListas() {

		let dataForm = new FormData();
		dataForm.append('tipoForm', 'read');
		dataForm.append('rLista', 'rLista');

		let header = new Headers();
		header.append('Content-Type', 'text/html; charset=utf-8');
		let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

		fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
			.then(res => res.json())
			.then(phpJsonRes => {

				if(phpJsonRes.res == 'ok') {
						//document.querySelector('.char-list').innerHTML = phpJsonRes.body;

						document.querySelector('#selCategoria').innerHTML = `<option value="" selected disabled>Elije categoría...</option>'${phpJsonRes.listaCategorias}`;
						document.querySelector('#selSubcategoria').innerHTML = `<option value="" selected disabled>Elije subcategoría...</option>'${phpJsonRes.listaSubCategorias}`;

						//document.querySelector('#selSubcategoria').innerHTML = '<option value="" selected disabled>Elije Subcategoría...</option><option value="NuevaSubCategoria">Nueva categoría</option>' + phpJsonRes.listaSubCategorias;

					}else {
						//msgLogin.style.display = 'block'
						if(phpJsonRes.res == 'fail') {
							Swal.fire({icon:'error', text: 'No se pudo insertar la Lista!'});
							console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
						} else {
							Swal.fire({icon:'error', text: 'No hubo respuesta del servidor al traer las listas!'});
						}
						
						//Reestablecer texto botón
						document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

					}
			}); //Fin promesa
	}

	function eliminarCategoria(catId) {
    let dataForm = new FormData();

    dataForm.append('tipoForm', 'delete');
    dataForm.append('dCat', 'dCat');
    dataForm.append('dCatId', catId);
    
    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
      .then(res => res.json())
      .then(phpJsonRes => {

        if(phpJsonRes.res == 'ok') {
					
						rellenarListas()
            Swal.fire('!Borrada!', 'Categoría a la caneca!', 'success');


          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudo eliminar la categoría!'});
              console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
            } else if(phpJsonRes.res == 'nadaOk'){
              Swal.fire({icon:'info', text: 'Esa categoría no existe! WTF!'});
              console.log('Query: ', phpJsonRes.queryString, '\nLugar: ', phpJsonRes.lugar);
            } else {
              Swal.fire({
                title: 'Error',
                text: 'No hubo respuesta del servidor al intentar eliminar la categoría! Por favor comunicar a Arlo!',
                imageUrl: '<?php echo SERVERURL . 'view/assets/img/bob01.gif';?>',
                imageWidth: 220,
                imageHeight: 150,
                imageAlt: 'Bob fail',
              });
            }
            
            //Reestablecer texto botón
            //document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }

      }); //Fin promesa
  }

	function eliminarSubcategoria(subCatId) {
    let dataForm = new FormData();

    dataForm.append('tipoForm', 'delete');
    dataForm.append('dSubcat', 'dSubcat');
    dataForm.append('dSubcatId', subCatId);
    
    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
      .then(res => res.json())
      .then(phpJsonRes => {

        if(phpJsonRes.res == 'ok') {
					
						rellenarListas()
            Swal.fire('!Borrada!', 'Subcategoría a la caneca!', 'success');

          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudo eliminar la subcategoría!'});
              console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
            } else if(phpJsonRes.res == 'nadaOk'){
              Swal.fire({icon:'info', text: 'Esa subcategoría no existe! WTF!'});
              console.log('Query: ', phpJsonRes.queryString, '\nLugar: ', phpJsonRes.lugar);
            } else {
              Swal.fire({
                title: 'Error',
                text: 'No hubo respuesta del servidor al intentar eliminar la subcategoría! Por favor comunicar a Arlo!',
                imageUrl: '<?php echo SERVERURL . 'view/assets/img/bob01.gif';?>',
                imageWidth: 220,
                imageHeight: 150,
                imageAlt: 'Bob fail',
              });
            }
            
            //Reestablecer texto botón
            //document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }

      }); //Fin promesa
  }
</script>