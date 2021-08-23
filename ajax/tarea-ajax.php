<?php
  $ajaxRequest = true;

  require_once '../config/app.php';

  if(isset($_POST['tipoForm'])) {
    /* Como esto se ejecuta desde el index.php, se escribe así la ruta: */
    require_once '../controller/TareaController.php';
    /* SESION 1.1. Si están seteadas, se usa el controlador el cual crea la sesión con la función de aquí [sigue en LoginController.php] */
    $insTarea = new TareaController();
    $tipoForm = $_POST['tipoForm'];

    if($tipoForm == 'create') {
      if(isset($_POST['cCategoriaTarea'])) {
        echo $insTarea->agregarTareaController(); 
      }
    }

    if($tipoForm == 'read') {
      if(isset($_POST['rLista'])) {
        echo $insTarea->obtenerListados();
      }

      if(isset($_POST['rListaIDCategoria'])) {
        echo $insTarea->obtenerListaSubcategoriaFiltro();
      }

      if(isset($_POST['rTareas'])) {
        echo $insTarea->obtenerTareasController();
      }

      if(isset($_POST['rUnaTarea'])) {
        echo $insTarea->obtenerUnaTareaController();
      }

      if(isset($_POST['rCantidadTareas'])) {
        echo $insTarea->obtenerCantidadTareas();
      }

      if(isset($_POST['rGeneraPDF'])) {
        echo $insTarea->generarPDFController();
      }
      
    }

    if($tipoForm == 'delete') {
      if(isset($_POST['dTarea'])) {
        echo $insTarea->eliminarTareaController();
      }

      if(isset($_POST['dCat'])) {
        echo $insTarea->eliminarCategoriaController();
      }

      if(isset($_POST['dSubcat'])) {
        echo $insTarea->eliminarSubcategoriaController();
      }
    }

    if($tipoForm == 'update') {
      if(isset($_POST['uCategoriaTarea'])) {
        echo $insTarea->actualizarTareaController(); 
      }
    }

  }else {
    session_start(['name'=>'daniapp']);
    session_unset();
    session_destroy();
    header('Location: ' . SERVERURL . 'login/');
    exit();
  }