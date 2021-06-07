<?php

  if($ajaxRequest) {
    require_once '../model/LoginModel.php';
  }else {
    require_once './model/LoginModel.php'; //Si entra acá quiere decir que se está ejecutando desde index.php
  }

  class LoginController extends LoginModel {

    /* ---------- Controlador iniciar sesión ---------- */
    public function iniciarSesionController() {
      /* -- Limpia impurezas de los valores enviados del form de [ login-view.php ] */
      $nombre = MainModel::cleanString($_POST['rNombreUsuario']);
      $contrasena = MainModel::cleanString($_POST['rContrasenaUsuario']);

      /* -- Comprobar campos vacios -- */
      if($nombre == '' || $contrasena  == '') {
        //$alert = [];
        //Complete campos vacios (como no vamos a usar ajax se ejecuta un script puro)
        return json_encode(['res' => 'empty']);
        exit;
      }

      $encriptedPass = MainModel::encryption($contrasena);
      $arrLoginData = [];

      //NOTA: El pass encriptado no debe pasar de 60 caracteres, es lo maximo que dejé que de pueda guardar en la DB
      if(strlen($encriptedPass) > 60) {
        return json_encode(['res' =>  'maxLenPass']);
        exit;
      }else {
        $arrLoginData = ['nombre'=> $nombre,'contrasena'=> $encriptedPass];
      }

      //$validarLogin = LoginModel::iniciarSesionModel($arrLoginData);
      $PDOLogin = LoginModel::iniciarSesionModel($arrLoginData);

      if($PDOLogin == true) {
        $CantResultados = $PDOLogin->rowCount();

        if($CantResultados > 0) {
          $arrDatosLogin = $PDOLogin->fetch();

          session_start(['name'=>'daniapp']);
          $_SESSION['id_daniapp'] = $arrDatosLogin['PKUSU_ID']; //Le pone el id de usuario de la DB
          $_SESSION['nombre_daniapp'] = $arrDatosLogin['USU_NOMBRE']; //Le pone el nombre de usuario de la DB
          /* Genera un Token aleatorio para cada sesión, con esto nos aseguramos que otra persona en otro lado no pueda cerrar la sesión*/
          $_SESSION['token_daniapp'] = md5(uniqid(mt_rand(), true));
          $PDOLogin = null; //Cierra la conexión

          return json_encode(['res' => 'ok', 'arra' => $arrDatosLogin]);
        }else if($CantResultados < 1) {
          return json_encode(['res' => 'nadaOk']); //USUARIO NO EXISTE
          $PDOLogin = null; //Cierra la conexión
          exit;
        }

      }else {
        return json_encode(['res' => 'fail', 'error' => $PDOLogin->errorInfo(), 'queryString' => $PDOLogin->queryString, 'lugar' => 'archivo '.  __FILE__ . ' / linea ' . __LINE__]);
        $PDOLogin = null;
        exit;
      }
    } /* Fin controlador */

    /* ---------- Controlador forzar cierre sesión ---------- */
    public function forceLogoutController() {
      session_unset();
      session_destroy();

      if(headers_sent()) { //Verifica si se han enviado headers (no sé, investigar)
        return '<script> window.location.href="'. SERVERURL .'login/" </script>';
      }else {
        return header('Location: ' . SERVERURL . 'login/');
      }
    }/* Fin controlador */

    /* ---------- Controlador cierre sesión ---------- */
    public function logoutController() {
      session_start(['name'=>'daniapp']);

      $token = MainModel::decryption($_POST['token']);
      $user = MainModel::decryption($_POST['user']);

      /* ( return o echo ) Esto lo recibe login-ajax y login-ajax es la respuesta del server a la solicitud que hace logout.php */
      //return "Token desencrypt en Login Controller : $token y user: $user";

      if($token == $_SESSION['token_daniapp'] && $user == $_SESSION['nombre_daniapp']) {
        session_unset();
        session_destroy();
        

        return json_encode(['res' => 'ok']);
      }else {

        return json_encode(['res' => 'fail']);
      }
    }
  }