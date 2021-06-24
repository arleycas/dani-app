<?php
  if($ajaxRequest) {
    require_once '../model/UserModel.php';
  }else {
    require_once './model/UserModel.php'; //Si entra acá queire decir que se está ejecutando desde index.php
  }

  class UserController extends UserModel {

    /* ---------- Controlador agregar usuario ---------- */
    public function agregarUsuarioController() {
      $nombre = MainModel::cleanString($_POST['cNombreUsuario']);
      $correo = MainModel::cleanString($_POST['cCorreoUsuario']);
      $contrasena1 = MainModel::cleanString($_POST['cContrasena1Usuario']);
      $contrasena2 = MainModel::cleanString($_POST['cContrasena2Usuario']);

      /* -- Comprobar si el USUARIO existe -- */
      $validarUsuario = MainModel::runSimpleQuery("SELECT USU_NOMBRE FROM indegwgj_db_daniapp.tbl_usuario WHERE USU_NOMBRE = '$nombre'");
      if($validarUsuario->rowCount() > 0) { //Verifica si existe un registro con esa consulta
        //Ya existe usuario
        return json_encode(['res' => 'yaExisteUs']);
        exit;
      }else if($validarUsuario->errorInfo()[0] != 0) { //Controlador de errores sql
        return json_encode(['res' => 'fail', 'error' => $validarUsuario->errorInfo()]);
        exit;
      }

      /* -- Comprobar email -- */
      if($correo != '' ) {
        if(filter_var($correo, FILTER_VALIDATE_EMAIL)) { //Funcion de php para validar emails?
          $validarCorreo = MainModel::runSimpleQuery("SELECT USU_CORREO FROM indegwgj_db_daniapp.tbl_usuario WHERE USU_CORREO = '$correo'");

          if($validarCorreo->rowCount() > 0) {
            //Email repetido
            return json_encode(['res' => 'yaExisteCorreo']);
            exit;
          }else if($validarCorreo->errorInfo()[0] != 0) { //Controlador de errores sql
            return json_encode(['res' => 'fail', 'error' => $validarCorreo->errorInfo()]);
            exit;
          }

        }else {
          //Email invalido
          return json_encode(['res' => 'correoFalse']);
          exit;
        }
      }

      /* -- Comprobar claves -- */
      if($contrasena1 != $contrasena2) {
          //Claves no coinciden
          return json_encode(['res' => 'passNoCoincide']);
          exit;
      } else {
        /* Se enctripta la clave */
        $encriptedPass = MainModel::encryption($contrasena1);
      }

      /* Este array debe tener el mismo formato que el que se pasa por parametro a la función addUserModel del modelo */
      $arrUserData = [
        "nombre"=>$nombre,
        "correo"=>$correo,
        "contrasena"=>$encriptedPass,
        "sesion" => 0
      ];

      $addUser = UserModel::addUserModel($arrUserData);

      if($addUser->rowCount() == 1) {
        //Usuario registrado satisfactoriamente
        return json_encode(['res' => 'ok']);
      }else {
        //No se ha podido registrar el usuario
        return json_encode(['res' => 'fail', 'error' => $addUser->errorInfo()]);
      }
    }
    

  }