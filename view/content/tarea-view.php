<style>
  .cont-spin {
    display: flex;
    align-items: center;
    height: 100%;
  }

  .swal2-image {
    border-radius: 5px;    
  }
</style>
<!-- ========== CONTENEDOR MAIN ========== -->
<div class="main">  

<h1>Nana App</h1>

  <!-- ========== Filtro para Lisa de tareas ==========  -->

  <div class="card">
    <div class="card-header">

      <!-- Toggles para filtro -->
      <div class="row">
      
        <div class="col">
          <h3> <i class="fas fa-filter"></i> Filtro</h3>
        </div>

        <div class="col">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="toggleCateFiltro" value="off">
            <label class="form-check-label" for="toggleCategoriaFiltro">Filtrar por categoria</label>
          </div>
        </div>

        <div class="col">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="toggleFechasFiltro" value="off">
            <label class="form-check-label" for="toggleFechasFiltro">Filtrar por fecha</label>
          </div>
        </div>

      </div>


    </div>

    <div class="card-body">

      <!-- Select de filtros de categoría y subcategoria -->
      <div id="contFiltros" class="row" style="display: none;">

        <div class="col-4">
          <label for="selCategoriaFiltro">Categorias</label>
          <select id="selCategoriaFiltro" class="form-select" aria-label="Default select example">
            <option value="" selected="" disabled="">Elije Categoría...</option>>
          </select>
        </div>

        <div id="contFiltroSubcate" class="col-4" style="display: none;">
          <label for="selSubcategoriaFiltro">Subcategorias </label>
          <div class="input-group">        
            <button id="btnOcultarFiltroSubcate" class="btn btn-outline-secondary" type="button"><i class="fas fa-times"></i></button>
            <select id="selSubcategoriaFiltro" class="form-select" aria-label="Default select example">
              <option value="" selected="" disabled="">Elije Subcategoría...</option>
            </select>
          </div>
        </div>

      </div> 

      <!-- Filtro de fecha -->
      <div id="contFiltroFecha" class="row" style="display: none;">

        <div class="col-4">
          <label for="inpFechaInicioFiltro">Fecha inicio </label>
          <input id="inpFechaInicioFiltro" type="date" class="form-control" name="cFechaTarea" value="<?php echo date('Y-m-d');?>">
          <div class="box-feedback" data-elemForm="#inpFechaInicioFiltro"><i class="fas fa-exclamation-circle me-1"></i>No olvides la fecha!</div>
        </div>

        <div class="col-4">
          <label for="inpFechaFinFiltro">Fecha fin </label>
          <input id="inpFechaFinFiltro" type="date" class="form-control" name="cFechaTarea" value="<?php echo date('Y-m-d');?>">
          <div class="box-feedback" data-elemForm="#inpFechaFinFiltro"><i class="fas fa-exclamation-circle me-1"></i>No olvides la fecha!</div>
        </div>
      </div>

      <a id="btnFiltrarTareas" class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</a>

    </div>

  </div>

  <!-- ========== Lisa de tareas ==========  -->
  <div class="row cont-tareas">
    <!-- Esto se rellena con las cartas de tareas -->
  </div>

  <h2>Tareas hechas hoy <span id="cantTareasHoy">0</span> </h2>
  <h2>Tareas hechas este mes <span id="cantTareasMes">0</span> </h2>
  <h2>Total tareas del año <span id="cantTareasAgno">0</span> </h2>

  <!-- ========== MODALES ==========  -->

  <!-- Button trigger modal Agregar tarea -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCTarea">Agrega tarea</button>

  <!-- Modal Agregar tarea-->
  <div class="modal fade" id="modalCTarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agrega una tarea Nanita!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
          <form class="form-ctarea" action="<?php echo SERVERURL; ?>ajax/tarea-ajax.php" method="POST" data-form="create" autocomplete="on">

            <div class="container">

              <div class="row">

                <div class="col-12 form-group">
                  <label for="selCategoria">Categoría</label>
                  <select class="form-select" id="selCategoria" name="cCategoriaTarea">
                    <option value="" selected disabled>Elije...</option>
                    <option value="NuevaCategoria">Nueva categoría</option>
                  </select>
                  <div id="feedCategoria" class="box-feedback vali" data-elemForm="#selCategoria"><i class="fas fa-exclamation-circle me-1"></i>Te olvidas de elegirme!</div>
                </div>

                <div id="contNuevaCategoria" class="col-12">
                  <label for="inpNuevaCategorria">Nueva categoría</label>
                  <input id="inpNuevaCategorria" type="text" class="form-control" placeholder="Nueva categoría" name="cNuevaCategoria">
                  <div id="feedNuevaCategoria" class="box-feedback" data-elemForm="#inpNuevaCategorria"><i class="fas fa-exclamation-circle me-1"></i>Ingresa la nueva categoría Nana</div>
                </div>

                <div class="col-12 form-group">
                  <label for="selSubcategoria">Subcategoría</label>
                  <select id="selSubcategoria" class="form-select" name="cSubcategoriaTarea">
                    <option value="" selected disabled>Elije...</option>
                    <option value="NuevaSubCategoria">Nueva subcategoría</option>
                  </select>
                  <div class="box-feedback vali" data-elemForm="#selSubcategoria"><i class="fas fa-exclamation-circle me-1"></i>Ay dios nanita olvidadiza!</div>
                </div>

                <div id="contNuevaSubCategoria" class="col-12">
                  <label for="inpNuevaSubCategoria">Nueva subcategoría</label>
                  <input id="inpNuevaSubCategoria" type="text" class="form-control" placeholder="Nueva subcategoría" name="cNuevaSubcategoriaTarea">
                  <div id="feedNuevaSubcategoria" class="box-feedback" data-elemForm="#inpNuevaSubCategoria"><i class="fas fa-exclamation-circle me-1"></i>Seleccioname una!</div>
                </div>

                <div class="form-group">
                  <label for="textDescripcion">Describiendo mi tarea </label>
                  <textarea id="textDescripcion" class="form-control" id="exampleFormControlTextarea1" rows="3" name="cDescripcionTarea"></textarea>
                  <div class="box-feedback vali" data-elemForm="#textDescripcion"><i class="fas fa-exclamation-circle me-1"></i>Describeme porfavor!</div>
                </div>

                <div class="col-12">
                  <label for="dateFecha">¿Cuando hice la tarea? </label>
                  <input id="dateFecha" type="date" class="form-control" name="cFechaTarea" value="<?php echo date('Y-m-d');?>">
                  <div class="box-feedback vali" data-elemForm="#dateFecha"><i class="fas fa-exclamation-circle me-1"></i>No olvides la fecha!</div>
                </div>

                <div class="col-12"> 
                  <button id="btnAgregarTarea" type="submit" class="btn btn-primary">Lista esta tarea!</button>
                </div>

              </div>
            </div>

            </form>

          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Actualizar tarea-->
  <div class="modal fade" id="modalUTarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edita esta tarea Nanita!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
          <form class="form-utarea" action="<?php echo SERVERURL; ?>ajax/tarea-ajax.php" method="POST" data-form="update" autocomplete="on">

            <div class="container">

              <div class="row">

                <div class="col-12" hidden="true">
                  <input type="text" id="inpTareaIdU" name="uTareaId">
                </div>

                <div class="col-12 form-group">
                  <label for="selCategoriaU">Categoría</label>
                  <select class="form-select" id="selCategoriaU" name="uCategoriaTarea">
                    <option value="" selected disabled>Elije...</option>
                    <option value="NuevaCategoria">Nueva categoría</option>
                  </select>
                  <div id="feedCategoria" class="box-feedback vali" data-elemForm="#selCategoriaU"><i class="fas fa-exclamation-circle me-1"></i>Te olvidas de elegirme!</div>
                </div>

                <div id="contNuevaCategoria" class="col-12">
                  <label for="inpNuevaCategoriaU">Nueva categoría</label>
                  <input id="inpNuevaCategoriaU" type="text" class="form-control" placeholder="Nueva categoría" name="uNuevaCategoria">
                  <div id="feedNuevaCategoria" class="box-feedback" data-elemForm="#inpNuevaCategoriaU"><i class="fas fa-exclamation-circle me-1"></i>Ingresa la nueva categoría Nana</div>
                </div>

                <div class="col-12 form-group">
                  <label for="selSubcategoriaU">Subcategoría</label>
                  <select id="selSubcategoriaU" class="form-select" name="uSubcategoriaTarea">
                    <option value="" selected disabled>Elije...</option>
                    <option value="NuevaSubCategoria">Nueva subcategoría</option>
                  </select>
                  <div class="box-feedback vali" data-elemForm="#selSubcategoriaU"><i class="fas fa-exclamation-circle me-1"></i>Ay dios nanita olvidadiza!</div>
                </div>

                <div id="contNuevaSubCategoria" class="col-12">
                  <label for="inpNuevaSubcategoriaU">Nueva subcategoría</label>
                  <input id="inpNuevaSubcategoriaU" type="text" class="form-control" placeholder="Nueva subcategoría" name="uNuevaSubcategoriaTarea">
                  <div id="feedNuevaSubcategoria" class="box-feedback" data-elemForm="#inpNuevaSubcategoriaU"><i class="fas fa-exclamation-circle me-1"></i>Seleccioname una!</div>
                </div>

                <div class="form-group">
                  <label for="textDescripcionU">Describiendo mi tarea </label>
                  <textarea id="textDescripcionU" class="form-control" id="exampleFormControlTextarea1" rows="3" name="uDescripcionTarea"></textarea>
                  <div class="box-feedback vali" data-elemForm="#textDescripcionU"><i class="fas fa-exclamation-circle me-1"></i>Describeme porfavor!</div>
                </div>

                <div class="col-12">
                  <label for="inpFechaU">¿Cuando hice la tarea? </label>
                  <input id="inpFechaU" type="date" class="form-control" name="uFechaTarea" value="<?php echo date('Y-m-d');?>">
                  <div class="box-feedback vali" data-elemForm="#inpFechaU"><i class="fas fa-exclamation-circle me-1"></i>No olvides la fecha!</div>
                </div>

                <div class="col-12"> 
                  <button id="btnActualizarTarea" type="submit" class="btn btn-primary">Guarda cambios!</button>
                </div>

              </div>
            </div>

            </form>

          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ---------- VENTENAS MODALES --------- -->

<!-- Scripts -->
<script>

  /* -------- Fn. Carga inicial de la página -------- */
  document.addEventListener('DOMContentLoaded', function(){
  
    initEscuchaElementos();
    rellenarListas();
    obtenerCantidadTareas();
    obtenerTareas();

    //Toggle selects categoría
    document.querySelector('#selCategoria').addEventListener('change', (e) => {
      let valorSelect = e.currentTarget.value;
      const contSelNuevaCategoria = document.querySelector('#contNuevaCategoria');
      const feedback = document.querySelector('#feedNuevaCategoria');
      
      if(valorSelect == 'NuevaCategoria') {
        contSelNuevaCategoria.style.display = 'block';
        feedback.classList.add('vali');
      }else {
        contSelNuevaCategoria.style.display = 'none';
        feedback.classList.remove('vali');
      }

    });//Fin Toggle select categoría
    
    //Toggle select subcategoria
    document.querySelector('#selSubcategoria').addEventListener('change', (e) => {
      let valorSelect = e.currentTarget.value;
      const contSelNuevaSubCategoria = document.querySelector('#contNuevaSubCategoria');
      const feedback = document.querySelector('#feedNuevaSubcategoria');
      
      if(valorSelect == 'NuevaSubCategoria') {
        contSelNuevaSubCategoria.style.display = 'block';
        feedback.classList.add('vali');
      }else {
        contSelNuevaSubCategoria.style.display = 'none';
        feedback.classList.remove('vali');
      }
    });//Fin toggle select subcategoría 

    //Toggle select categoria filtro
    document.querySelector('#selCategoriaFiltro').addEventListener('change', (e) => {
      //let valorSelect = e.currentTarget.value; Hacer la función con paso de parametro?
      rellenarListaSubcategoriaFiltro();
    });

    //Toggle para mostrar o ocultar filtro de categoria
    document.querySelector('#toggleCateFiltro').addEventListener('click', (e) => {

      let valorToggle = e.currentTarget.value; 
      let contFiltros = document.querySelector('#contFiltros');

      if(valorToggle == 'off') {
        e.currentTarget.value = 'on';
        console.log('muestra');
        contFiltros.style.display = 'flex';
        //AGREGAR LA CLASE DE VALIDAR MAS ADELANTE A LAS FECHAS FILTRO
      }else if(valorToggle == 'on') {
        e.currentTarget.value = 'off';
        console.log('oculta');
        contFiltros.style.display = 'none';
        //QUITRAR LA CLASE DE VALIDAR MAS ADELANTE A LAS FECHAS FILTRO
      }
    });

    //Toggle para mostrar o ocultar filtro de fechas
    document.querySelector('#toggleFechasFiltro').addEventListener('click', (e) => {
      let valorToggle = e.currentTarget.value; 
      let contFiltrosFecha = document.querySelector('#contFiltroFecha');

      if(valorToggle == 'off') {
        e.currentTarget.value = 'on';
        console.log('muestra');
        contFiltroFecha.style.display = 'flex';
        //AGREGAR LA CLASE DE VALIDAR MAS ADELANTE A LAS FECHAS FILTRO
      }else if(valorToggle == 'on') {
        e.currentTarget.value = 'off';
        console.log('oculta');
        contFiltroFecha.style.display = 'none';
        //QUITRAR LA CLASE DE VALIDAR MAS ADELANTE A LAS FECHAS FILTRO
      }
    });

    //boton filtrar tareas
    document.querySelector('#btnFiltrarTareas').addEventListener('click', (e) => {
      e.preventDefault();
      obtenerTareas();
    });

    //boton ocultar filtro subcategoría
    document.querySelector('#btnOcultarFiltroSubcate').addEventListener('click', (e) => {
      document.querySelector('#contFiltroSubcate').style.display = 'none';
    });
    
  }, false); //Fin carga inicial

  function initEscuchaElementos() {
    /* Es importante volver a llamar esta función luego de traer elementos DOM del php
    para volverlos a reestablecer */

    //Previene que al presionar enter en los formularios se envien, sin embargo si está focuseado
    //un textarea, si se permite que se ejecute el enter, de lo contrario no dejaría hacer 
    //saltos de linea
    document.querySelectorAll('form').forEach(formulario => {

      formulario.addEventListener('keydown', function(e) {
        
        if((e.key == 'Enter') && (document.activeElement.type != 'textarea')) {
          e.preventDefault();
        }
      });
    });

    //Escucha a botones de agregar tarea
    document.querySelectorAll('.form-ctarea').forEach(forms => {
      forms.addEventListener('submit', agregarTarea);
    });

    //Escucha a botones de actualizar tarea
    document.querySelectorAll('.form-utarea').forEach(forms => {
      forms.addEventListener('submit', actualizarTarea);
    });

    //Escucha a botones para sacar Swal de confirmación eliminación de tarea
    document.querySelectorAll('.btn-swal-dtarea').forEach(btnSwal => {

      btnSwal.addEventListener('click', (e) => {

        let tareaId = e.currentTarget.id;
        tareaId = tareaId.replace('btnIdEliTarea', '');

        Swal.fire({
          title: `¿Segura que quieres eliminar la tarea?`,
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
            eliminarTarea(tareaId);
          }
        })
      });

    }); //Fin escucha botones Swal eliminar tarea

    //Escucha botones para rellenar los datos del modal de Editar Tarea
    document.querySelectorAll('.btn-utarea').forEach(btnEdit => {
      
      btnEdit.addEventListener('click', () => {
        let tareaId = btnEdit.getAttribute('data-id-utarea');
        obtenerUnaTarea(tareaId);
      });
    });

  } //Fin initEscuchaElementos

  function agregarTarea(e) {
    //alert('SI sirve? 1');
    e.preventDefault();

    let dataForm = new FormData(this);
    let method = this.getAttribute('method');
    let action = this.getAttribute('action'); //url a donde se va a enviar la info
    let tipoForm = this.getAttribute('data-form'); //tipo de formulario
    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    //let codLibro = document.querySelector('#inpCodLibro').value;

   /*  console.log('cate: ', dataForm.get('cCategoriaTarea'));
    console.log('nueva cate: ', dataForm.get('cNuevaCategoria'));
    console.log('subcate', dataForm.get('cSubcategoriaTarea'));
    console.log('nueva subcate', dataForm.get('cNuevaSubcategoriaTarea'));
    console.log('descrip: ', dataForm.get('cDescripcionTarea'));
    console.log('fecha: ', dataForm.get('cFechaTarea')); */

    dataForm.append('tipoForm', tipoForm);
    //dataForm.append('cCodLibro', codLibro);

    let config = {method: method, header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    /* if(validarVacios()) { */

      let promesaCrearTarea = fetch(action, config);

        promesaCrearTarea.then(res => res.json())
        .then(phpJsonRes => {
          document.querySelector('#btnAgregarTarea').innerHTML = '<div class="spinner"></div>';

          if(phpJsonRes.res == 'ok') {
            //document.querySelector('.char-list').innerHTML = phpJsonRes.body;
            obtenerTareas();
            obtenerCantidadTareas();

            //Cerrar modal
            let modalCTarea = bootstrap.Modal.getInstance(document.getElementById('modalCTarea'));
            modalCTarea.hide();

            Swal.fire('Tarea insertada!');
            //document.querySelector('.form-cpersonaje__btnc').innerHTML = 'Agregar';
            //document.querySelector('#' + phpJsonRes.idCard).classList.add('nueva-card'); //Animación apenas se crea!
          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudo insertar la tarea!'});
              console.log('Error: ', phpJsonRes.error, 'Lugar: ', phpJsonRes.lugar);
            } else if(phpJsonRes.res == 'nadaOk'){
              Swal.fire({icon:'info', text: 'Esa tarea no existe! WTF!'});
              console.log('Query: ', phpJsonRes.queryString, '\nLugar: ', phpJsonRes.lugar);
            }else {
              Swal.fire({icon:'error', text: 'No hubo respuesta del servidor al insertar tarea!'});
            }
            
            //Reestablecer texto botón
            document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }
          
          //document.querySelector('.form-addbook__btnadd').innerHTML = 'Agregar';
          initEscuchaElementos();
          //iniciarModales();
        }); //Fin promesa

    //alert('SI sirve? 2');

    /* } */
  } //Fin agregarTarea

  function eliminarTarea(tareaId) {
    let dataForm = new FormData();

    dataForm.append('tipoForm', 'delete');
    dataForm.append('dTarea', 'dTarea');
    dataForm.append('dTareaId', tareaId);
    
    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
      .then(res => res.json())
      .then(phpJsonRes => {

        if(phpJsonRes.res == 'ok') {

            obtenerTareas();
            Swal.fire('!Borrada!', 'Tarea a la caneca!', 'success');

          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudo eliminar la tarea!'});
              console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
            } else if(phpJsonRes.res == 'nadaOk'){
              Swal.fire({icon:'info', text: 'Esa tarea no existe! WTF!'});
              console.log('Query: ', phpJsonRes.queryString, '\nLugar: ', phpJsonRes.lugar);
            } else {
              Swal.fire({
                title: 'Error',
                text: 'No hubo respuesta del servidor al intentar eliminar la tarea! Por favor comunicar a Arlo!',
                imageUrl: '<?php echo SERVERURL . 'view/assets/img/bob01.gif';?>',
                imageWidth: 220,
                imageHeight: 150,
                imageAlt: 'Bob fail',
              });
            }
            
            //Reestablecer texto botón
            document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }

      }); //Fin promesa
  }

  function actualizarTarea(e) {
    e.preventDefault();

    let dataForm = new FormData(this);
    let method = this.getAttribute('method');
    let action = this.getAttribute('action'); //url a donde se va a enviar la info
    let tipoForm = this.getAttribute('data-form'); //tipo de formulario
    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    //let codLibro = document.querySelector('#inpCodLibro').value;

    /*  console.log('cate: ', dataForm.get('cCategoriaTarea'));
    console.log('nueva cate: ', dataForm.get('cNuevaCategoria'));
    console.log('subcate', dataForm.get('cSubcategoriaTarea'));
    console.log('nueva subcate', dataForm.get('cNuevaSubcategoriaTarea'));
    console.log('descrip: ', dataForm.get('cDescripcionTarea'));
    console.log('fecha: ', dataForm.get('cFechaTarea')); */

    dataForm.append('tipoForm', tipoForm);
    //dataForm.append('cCodLibro', codLibro);

    let config = {method: method, header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch(action, config)
    .then(res => res.json())
    .then(phpJsonRes => {
      document.querySelector('#btnAgregarTarea').innerHTML = '<div class="spinner"></div>';

      if(phpJsonRes.res == 'ok') {
        //document.querySelector('.char-list').innerHTML = phpJsonRes.body;
        obtenerTareas();
        obtenerCantidadTareas();
        rellenarListas();

        //Cerrar modal
        let modalUTarea = bootstrap.Modal.getInstance(document.getElementById('modalUTarea'));
        modalUTarea.hide();

        Swal.fire('Tarea actualizada!');
        //document.querySelector('.form-cpersonaje__btnc').innerHTML = 'Agregar';
        //document.querySelector('#' + phpJsonRes.idCard).classList.add('nueva-card'); //Animación apenas se crea!
      }else {
        //msgLogin.style.display = 'block'
        if(phpJsonRes.res == 'fail') {
          Swal.fire({icon:'error', text: 'No se pudo actualizar la tarea!'});
          console.log('Error: ', phpJsonRes.error, 'Lugar: ', phpJsonRes.lugar);
        } else {
          Swal.fire({icon:'error', text: 'No hubo respuesta del servidor al insertar tarea!'});
        }
        
        //Reestablecer texto botón
        document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

      }
      
      //document.querySelector('.form-addbook__btnadd').innerHTML = 'Agregar';
      initEscuchaElementos();
      //iniciarModales();
    }); //Fin promesa



  }

  function validarVacios() {

    let arrVacios = [];

    document.querySelectorAll('.vali').forEach(boxFeed => {

      let elemForm = document.querySelector(boxFeed.getAttribute('data-elemForm'));

      if((elemForm.value == '') || (elemForm.value == null)) {
        boxFeed.style.display = 'block ';
        boxFeed.style.animationName = 'muestraFeed';    
        elemForm.classList.add('fe-invalido');

        arrVacios.push(0); //pushea 0 si es invalido
      }else {
        boxFeed.style.display = 'none ';
        boxFeed.style.animationName = 'none';    
        elemForm.classList.remove('fe-invalido');

        arrVacios.push(1); //pushea 1 si es valido
      }

    });

    //multiplica array
    const res = arrVacios.reduce((p, c) => p*c);

    arrVacios = [];
    if(res == 0) {
      return false; //faltan input
    }else if(res == 1) {
      return true; //elementos form validados
    }else {
      return false;
    }

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

            document.querySelector('#selCategoria').innerHTML = '<option value="" selected disabled>Elije Categoría...</option><option value="NuevaCategoria">Nueva categoría</option>' + phpJsonRes.listaCategorias;
            document.querySelector('#selCategoriaFiltro').innerHTML = '<option value="" selected disabled>Elije Categoría...</option>' + phpJsonRes.listaCategorias;

            document.querySelector('#selSubcategoria').innerHTML = '<option value="" selected disabled>Elije Subcategoría...</option><option value="NuevaSubCategoria">Nueva categoría</option>' + phpJsonRes.listaSubCategorias;

            //Listas del modal de editar
            document.querySelector('#selCategoriaU').innerHTML = '<option value="" selected disabled>Elije Categoría...</option><option value="NuevaCategoria">Nueva categoría</option>' + phpJsonRes.listaCategorias;
            document.querySelector('#selSubcategoriaU').innerHTML = '<option value="" selected disabled>Elije Subcategoría...</option><option value="NuevaSubCategoria">Nueva categoría</option>' + phpJsonRes.listaSubCategorias;


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

  function rellenarListaSubcategoriaFiltro() {

    //let contSpinner = document.querySelector('.cont-spin');
    let idCategoria = document.querySelector('#selCategoriaFiltro').value;

    //contSpinner.style.display = 'block';

    let dataForm = new FormData();
    dataForm.append('tipoForm', 'read');
    dataForm.append('rListaIDCategoria', idCategoria);

    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
      .then(res => res.json())
      .then(phpJsonRes => {

        if(phpJsonRes.res == 'ok') {
            //document.querySelector('.char-list').innerHTML = phpJsonRes.body
            //contSpinner.style.display = 'none';
            document.querySelector('#contFiltroSubcate').style.display = 'block';
            document.querySelector('#selSubcategoriaFiltro').innerHTML = '<option value="" selected disabled>Elije Subcategoría...</option>' + phpJsonRes.listaSubcategorias;

          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudo insertar la Lista de Subcategoría filtros!'});
              console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
            } else {
              Swal.fire({icon:'error', text: 'No hubo respuesta del servidor al traer la lista de subcategoría filtros!'});
            }
            
            //Reestablecer texto botón
            //document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }
      }); //Fin promesa

  }

  function obtenerCantidadTareas(){
    let dataForm = new FormData();
    dataForm.append('tipoForm', 'read');
    dataForm.append('rCantidadTareas', 'rCantidadTareas');

    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
      .then(res => res.json())
      .then(phpJsonRes => {

        if(phpJsonRes.res == 'ok') {
            //document.querySelector('.char-list').innerHTML = phpJsonRes.body;

            document.querySelector('#cantTareasHoy').innerHTML = phpJsonRes.cantTareasHoy;
            document.querySelector('#cantTareasMes').innerHTML = phpJsonRes.cantTareasMes;
            document.querySelector('#cantTareasAgno').innerHTML = phpJsonRes.cantTareasAgno;

          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudo insertar la Lista!'});
              console.log('Error: ', phpJsonRes.error, 'Query: ', phpJsonRes.query,'Lugar: ', phpJsonRes.lugar);
            } else {
              Swal.fire({icon:'error', text: 'No hubo respuesta del servidor al traer las listas!'});
            }
            
            //Reestablecer texto botón
            document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }
      }); //Fin promesa
  }

  function obtenerTareas() {

    let dataForm = new FormData();
    let toggleCateFiltro = document.querySelector('#toggleCateFiltro').value;
    let toggleFechasFiltro = document.querySelector('#toggleFechasFiltro').value;
    let selCategoriaFiltro = document.querySelector('#selCategoriaFiltro').value;
    let selSubcategoriaFiltro = document.querySelector('#selSubcategoriaFiltro').value;
    let inpFechaInicioFiltro = document.querySelector('#inpFechaInicioFiltro').value;
    let inpFechaFinFiltro = document.querySelector('#inpFechaFinFiltro').value;
    let contFiltroSubcate = document.querySelector('#contFiltroSubcate');

    dataForm.append('tipoForm', 'read');
    dataForm.append('rTareas', 'rTareas');

    if((toggleCateFiltro == 'on') && (toggleFechasFiltro == 'off')) {

      if(contFiltroSubcate.style.display == 'none') {
        dataForm.append('rTareasCat', 'rTareasCat');
        dataForm.append('rCateFiltro', selCategoriaFiltro);
      }else{
        dataForm.append('rTareasCatSub', 'rTareasCatSub');
        dataForm.append('rCateFiltro', selCategoriaFiltro);
        dataForm.append('rSubCateFiltro', selSubcategoriaFiltro);
      }

    }else if((toggleFechasFiltro == 'on') && (toggleCateFiltro == 'off')) {

      dataForm.append('rTareasFecha', 'rTareasFecha');
      dataForm.append('rFechaInicioFiltro', inpFechaInicioFiltro);
      dataForm.append('rFechaFinFiltro', inpFechaFinFiltro);

    }else if((toggleCateFiltro == 'on') && (toggleFechasFiltro == 'on')){

      if(contFiltroSubcate.style.display == 'none') {
        dataForm.append('rTareasCat&Fecha', 'rTareasCat&Fecha');
        dataForm.append('rCateFiltro', selCategoriaFiltro);
        dataForm.append('rFechaInicioFiltro', inpFechaInicioFiltro);
        dataForm.append('rFechaFinFiltro', inpFechaFinFiltro);

      }else {
        dataForm.append('rTareasCatSub&Fecha', 'rTareasCatSub&Fecha');
        dataForm.append('rCateFiltro', selCategoriaFiltro);
        dataForm.append('rSubCateFiltro', selSubcategoriaFiltro);
        dataForm.append('rFechaInicioFiltro', inpFechaInicioFiltro);
        dataForm.append('rFechaFinFiltro', inpFechaFinFiltro);
      }
      
    }

    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
      .then(res => res.json())
      .then(phpJsonRes => {

        if(phpJsonRes.res == 'ok') {
            //document.querySelector('.char-list').innerHTML = phpJsonRes.body;
            document.querySelector('.cont-tareas').innerHTML = phpJsonRes.body;
            initEscuchaElementos();

          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudieron traer las tareas!'});
              console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
            } else if(phpJsonRes.res == 'nadaOk'){
              Swal.fire({icon:'info', text: 'No hay datos con esa consulta!'});
              console.log('Query: ', phpJsonRes.queryString, '\nLugar: ', phpJsonRes.lugar);
            } 
            else {
              Swal.fire({icon:'error', text: 'No hubo respuesta del servidor al traer las tareas!'});
            }
            
            //Reestablecer texto botón
            document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }
      }); //Fin promesa

  }

  function obtenerUnaTarea(tareaId) {
    let dataForm = new FormData();

    dataForm.append('tipoForm', 'read');
    dataForm.append('rUnaTarea', 'rUnaTarea');
    dataForm.append('rIdUnaTarea', tareaId)

    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    let config = {method: 'POST', header: header, mode: 'cors', cache: 'no-cache', body: dataForm}

    fetch('<?php echo SERVERURL; ?>ajax/tarea-ajax.php', config)
      .then(res => res.json())
      .then(phpJsonRes => {

        if(phpJsonRes.res == 'ok') {

          document.querySelector('#inpTareaIdU').value = phpJsonRes.idTarea;
          document.querySelector('#selCategoriaU').value = phpJsonRes.idCat;
          document.querySelector('#selSubcategoriaU').value = phpJsonRes.idSubcat;
          document.querySelector('#textDescripcionU').value = phpJsonRes.descripcion;
          document.querySelector('#inpFechaU').value = phpJsonRes.fecha;


          }else {
            //msgLogin.style.display = 'block'
            if(phpJsonRes.res == 'fail') {
              Swal.fire({icon:'error', text: 'No se pudieron traer las tareas!'});
              console.log('Error: ', phpJsonRes.error, phpJsonRes.queryString, 'Lugar: ', phpJsonRes.lugar);
            } else if(phpJsonRes.res == 'nadaOk'){
              Swal.fire({icon:'info', text: 'No hay datos con esa consulta!'});
              console.log('Query: ', phpJsonRes.queryString, '\nLugar: ', phpJsonRes.lugar);
            } 
            else {
              Swal.fire({icon:'error', text: 'No hubo respuesta del servidor al traer las tareas!'});
            }
            
            //Reestablecer texto botón
            document.querySelector('#btnAgregarTarea').innerHTML='Lista!';

          }
      }); //Fin promesa

  }

</script>


