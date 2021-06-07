<?php
  require_once './model/VistaModel.php';

  class VistaController extends VistaModel {

    /* ----- Controlador para obtener plantilla */
    public function obtenerTemplateController() {
      return require_once './view/template.php';
    }

    /* ----- Controlador para obtener vista */
    public function obtenerVistaController() {
      if(isset($_GET['view'])) { //Esta es la variable que se estableció en .htaccess
        $ruta = explode('/', $_GET['view']);
        $res = VistaModel::obtenerVistaModel($ruta[0]);
      }else {
        $res = 'login';
      }

      return $res;
    }

  }