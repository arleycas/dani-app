<?php
  class VistaModel {

    /* ----- Modelo para obtener las vistas -----*/

    /* 1. Lista blanca de palabras permitidas para vistas en la url */
    protected static function obtenerVistaModel($vista) {
      $arrListaBlanca = ['tarea', 'lista-tareas'];
      if(in_array($vista, $arrListaBlanca)) {
        
        if(is_file('./view/content/' . $vista . '-view.php')) { //Si el archivo existe
          $content =  './view/content/' . $vista . '-view.php';
        }else {
          $content = '404';
        }
        
      }elseif($vista === 'login' || $vista === 'index') {
        $content = 'login';
      } elseif($vista === 'logout') {
        $content = 'logout';
      }else {
        $content = '404';
      }

      return $content;
    }

  }