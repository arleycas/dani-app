<?php
  $ajaxRequest = true;

  require_once '../config/app.php';

  
  /* SESIÓN: 1. Aquí comienza el viaje de la sessión
  - Se llenan las variables super globales POST con el user y el pass y se verifica están seateadas por el formulario de arriba  */
  if(isset($_POST['tipoForm'])) {
    /* Como esto se ejecuta desde el index.php, se escribe así la ruta: */
    require_once '../controller/LoginController.php';
    /* SESION 1.1. Si están seteadas, se usa el controlador el cual crea la sesión con la función de aquí [sigue en LoginController.php] */
    $insLogin = new LoginController();
    $tipoForm = $_POST['tipoForm'];

    if($tipoForm == 'read') {
      if(isset($_POST['rNombreUsuario'])) {
        echo $insLogin->iniciarSesionController(); 
      }
    }

  }else {
    session_start(['name'=>'daniapp']);
    session_unset();
    session_destroy();
    header('Location: ' . SERVERURL . 'login/');
    exit();
  }


