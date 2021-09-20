<!-- Esta variable se guarda en la función de Login Controller -->
<!-- <p><b> Bienvenido/a: <?php echo $_SESSION['nombre_daniapp'] ?></b></p> -->

<nav class="navbar navbar-expand-lg navbar-light primary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a id="navTarea" class="nav-link" href="<?php echo SERVERURL; ?>tarea/1/"><i class="fas fa-book"></i> Tareas</a>
        </li>
        <li class="nav-item">
          <a id="navInforme" class="nav-link" href="<?php echo SERVERURL; ?>informe/"><i class="fas fa-file-download"></i> Informe</a>
        </li>
        <li class="nav-item">
          <a id="navSettings" class="nav-link" href="<?php echo SERVERURL; ?>settings/"><i class="fas fa-cog"></i> Settings</a>
        </li>
        <li class="nav-item">
          <a id="btnLogout" class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', () => {

    document.querySelector('#btnLogout').addEventListener('click', function(e) {
      e.preventDefault();

      let url = '<?php echo SERVERURL; ?>ajax/logout-ajax.php';
      /* 1. Se encriptan acá */
      let token = '<?php echo $lc->encryption($_SESSION['token_daniapp']); ?>';
      let user = '<?php echo $lc->encryption($_SESSION['nombre_daniapp']); ?>';

      let objFD = new FormData();
      objFD.append('token', token);
      objFD.append('user', user);

      fetch(url, {
          method: 'POST',
          body: objFD /* 2. Se mandan encriptados a ajax.php */
        })
        .then(res => res.json())
        .then(phpJsonRes => {

          if (phpJsonRes.res == 'ok') {
            window.location.href = '<?php echo SERVERURL; ?>login/';
          } else if (phpJsonRes.res == 'fail') {
            alert('Por alguna mondá no se pudo cerrar sesión');
          } else {
            alert('No hubo respuesta del servidor');
          }

        });

    });

    //Controlador color de link según la página
    let vistaActual = '<?php echo $_GET['view']; ?>'

    if (vistaActual.includes('tarea/')) {
      document.querySelector('#navTarea').classList.add('active')
    } else if (vistaActual.includes('informe/')) {
      document.querySelector('#navInforme').classList.add('active')
    } else if (vistaActual.includes('settings/')) {
      document.querySelector('#navSettings').classList.add('active')
    }

    console.log('<?php echo $_GET['view']; ?>');

  })
</script>