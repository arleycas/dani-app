<?php

require_once 'MainModel.php';

  class LoginModel extends MainModel {

    /* ---------- Modelo iniciar sesión ---------- */
    protected static function iniciarSesionModel($arrData) {
      $sql = MainModel::connectDB()->prepare('SELECT PKUSU_ID, USU_NOMBRE FROM bgu1dxovwo00mnppgke9.tbl_usuario WHERE USU_NOMBRE = :m_nombre AND USU_CONTRASENA = :m_contrasena');
      $sql->bindParam(':m_nombre', $arrData['nombre']);
      $sql->bindParam(':m_contrasena', $arrData['contrasena']);
      $sql->execute();

      return $sql; //Se retorna el objeto PDOStatement ya ejecutado
    }
    
  }