<?php
  require_once 'MainModel.php';

  class UserModel extends MainModel{

    /* ---------- Modelos agregar usuario - https://www.youtube.com/watch?v=3gML8QjZUfk&ab_channel=CarlosAlfaro ---------- */
    protected static function addUserModel($arrDatos) {
      $sql = MainModel::connectDB()->prepare("INSERT INTO indegwgj_db_daniapp.tbl_usuario(USU_NOMBRE, USU_CORREO, USU_CONTRASENA, USU_SESION) VALUES(:m_nombre, :m_correo, :m_contrasena, :m_sesion)");
      $sql->bindParam(':m_nombre', $arrDatos['nombre']);
      $sql->bindParam(':m_correo', $arrDatos['correo']);
      $sql->bindParam(':m_contrasena', $arrDatos['contrasena']);
      $sql->bindParam(':m_sesion', $arrDatos['sesion']);
      $sql->execute();

      return $sql; //Estos métodos retornan un objeto PDOStatement
    }
    
  }