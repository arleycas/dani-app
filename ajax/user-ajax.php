<?php
  $ajaxRequest = true;

  require_once '../config/app.php';

  if(isset($_POST['tipoForm'])) {
    /* ---------- Instancia del controlador ---------- */
    require_once '../controller/UserController.php';
    $userIns = new UserController();
    $tipoForm = $_POST['tipoForm'];

    /* ---------- Crear usuario ---------- */
    if($tipoForm == 'create') {
      if(isset($_POST['cNombreUsuario'])) {
        echo $userIns->agregarUsuarioController();
      }
    }

  }else {
    session_start(['name'=>'charlog']);
    session_unset();
    session_destroy();
    header('Location: ' . SERVERURL . 'login/');
    exit();
  }

