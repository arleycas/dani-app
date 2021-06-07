<?php
  require_once './config/app.php';
  require_once './controller/VistaController.php';

  $template = new VistaController();
  $template->obtenerTemplateController();
