<!-- Esta variable se guarda en la función de Login Controller -->
<!-- <p><b> Bienvenido/a: <?php echo $_SESSION['nombre_daniapp']?></b></p> -->

<nav class="navbar">
  <div class="navbar__cont">
    <a class="navbar__link" href="<?php echo SERVERURL; ?>tarea/">Tareas</a>
    <a class="navbar__link" href="<?php echo SERVERURL; ?>settings/">Settings</a>
    <a id="btnLogout" class="navbar__link" href="#">Cerrar sesión</a>
  </div>
</nav>

<script>
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

      if(phpJsonRes.res == 'ok') {
        window.location.href='<?php echo SERVERURL; ?>login/';
      }else if(phpJsonRes.res == 'fail') {
        alert('Por alguna mondá no se pudo cerrar sesión');
      }else {
        alert('No hubo respuesta del servidor');
      }

    });

  });
</script>
