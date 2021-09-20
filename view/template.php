<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <title id="tituloPagina"><?php echo COMPANY; ?></title>
  <!-- Links -->
  <?php include './view/include/link.php'; ?>
  <style>

  </style>
</head>

<body>
  <?php
  $ajaxRequest = false;
  /* Para ir al libro que es */
  /* $book = explode('/', $_GET['view']); //Se saca de el indice 1
    echo 'Libro: ' . $book[1] . '<br>'; */

  require_once './controller/VistaController.php';
  $IV = new VistaController();
  $vista = $IV->obtenerVistaController();


  if ($vista == 'login' || $vista == '404' || $vista == 'register') {
    require_once './view/content/' . $vista . '-view.php';
  } else {
    /* SESION 3. Aquí se verifica al cargar el index.php si hay o no una sesión activa */
    session_start(['name' => 'daniapp']);

    require_once './controller/LoginController.php';
    $lc = new LoginController();

    /* Nota: Estas sesiones se crean al momento de realiza login exitoso */
    /* Si no está definida ninguna variable de estas, se fuerza el cierre de sesión (recordar esto de las sesiones esta en loginController) */
    if (!isset($_SESSION['token_daniapp']) || !isset($_SESSION['nombre_daniapp']) || !isset($_SESSION['id_daniapp'])) {
      echo $lc->forceLogoutController();
    }

    // Navbar y contenido
    //echo 'Sin encriptar => token: ' . $_SESSION['token_charlog'] . ' / user: ' . $_SESSION['nombre_charlog'];
    include './view/include/navbar.php';
    include $vista;


    //Footer
    include './view/include/footer.php';
  }

  //Scripts generales
  include './view/include/script.php';


  ?>
</body>

</html>