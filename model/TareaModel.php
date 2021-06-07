<?php
  require_once 'MainModel.php';

  class TareaModel extends MainModel{

    /* ---------- Modelo   ---------- */
    protected static function createTareaModel($arrData) { //Este array viene del controlador
      $sql = MainModel::connectDB()->prepare("INSERT INTO bgu1dxovwo00mnppgke9.tbl_tarea(FKUSU_ID , FKSUB_ID, TAR_DESCRIPCION, TAR_FECHA) VALUES(:m_usu_id, :m_sub_id, :m_descripcion, :m_fecha)");
      $sql->bindParam(':m_usu_id', $arrData['usu_id']);
      $sql->bindParam(':m_sub_id', $arrData['sub_id']);
      $sql->bindParam(':m_descripcion', $arrData['descripcion']);
      $sql->bindParam(':m_fecha', $arrData['fecha']);
      $sql->execute();

      return $sql;
    }

    protected static function updateTareaModel($arrData){
      $sql = MainModel::connectDB()->prepare("UPDATE bgu1dxovwo00mnppgke9.tbl_tarea SET FKSUB_ID = :m_sub_id, TAR_DESCRIPCION = :m_descripcion, TAR_FECHA = :m_fecha WHERE PKTAR_ID = :m_tar_id AND FKUSU_ID = :m_usu_id");
      $sql->bindParam(':m_tar_id', $arrData['tar_id']);
      $sql->bindParam(':m_usu_id', $arrData['usu_id']);
      $sql->bindParam(':m_sub_id', $arrData['sub_id']);
      $sql->bindParam(':m_descripcion', $arrData['descripcion']);
      $sql->bindParam(':m_fecha', $arrData['fecha']);
      $sql->execute();

      return $sql;
    }

    //FALTA WHERE DEL USUARIO!!!
    protected static function deleteTareaModel($tarId) {
      $sql = MainModel::connectDB()->prepare("DELETE FROM bgu1dxovwo00mnppgke9.tbl_tarea WHERE PKTAR_ID = :m_tar_id");
      $sql->bindParam(':m_tar_id', $tarId);
      $sql->execute();

      return $sql;
    }

    //FALTA WHERE DE USUAIO??!!
    protected static function selectUnaTareaModel($tarId) {
      $sql = MainModel::connectDB()->prepare("SELECT tt.PKTAR_ID, tt.FKSUB_ID, ts.FKCAT_ID, tt.TAR_DESCRIPCION, tt.TAR_FECHA FROM bgu1dxovwo00mnppgke9.tbl_tarea AS tt JOIN bgu1dxovwo00mnppgke9.tbl_subcategoria AS ts ON tt.FKSUB_ID = ts.PKSUB_ID WHERE PKTAR_ID = :m_tar_id");
      $sql->bindParam(':m_tar_id', $tarId);
      $sql->execute();

      return $sql;
    }
    /* protected static function obtenerTareas() {
      $sql
    } */

  }