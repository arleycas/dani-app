<?php
  $ajaxRequest = true;

  require_once '../config/app.php';

  /* Recordar estas variables vienen del DataForm */
  if(isset($_POST['token']) && isset($_POST['user'])) {

    /* ---------- Instancia del controlador ---------- */
    require_once '../controller/LoginController.php';
    $userIns = new LoginController();

    /* Esta respuesta se devuelve a logout.php y se muestra en un alert allá */
    //echo 'Variables POST: token > ' . $_POST['token'] . 'user > ' . $_POST['user'];
    echo $userIns->logoutController();

  }else {
    session_start(['name'=>'charlog']);
    session_unset();
    session_destroy();
    header('Location: ' . SERVERURL . 'login/');
    exit();
    echo 'Se metió acá la mondá';
  }