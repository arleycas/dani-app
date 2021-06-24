<h1>Usuario: dani / dani123 </h1>

<div class="row justify-content-center">

  <div class="col-sm-7 col-md-8 col-lg-4 col-xl-3">
    <div class="login">
      <div class="login__msg"></div>

        <span id="btnToggleLogin" class="btn-logres">Registrarme</span>

        <div class="cont-login" style="display: block;">

          <form class="form-rusuario" action="<?php echo SERVERURL; ?>ajax/login-ajax.php" data-form="read" method="POST" autocomplete="off">

            <input id="inpUsuario" class="login-form__input" placeholder="Usuario" type="text" name="rNombreUsuario">
            <input id="inpContrasena" class="login-form__input" placeholder="Contraseña" type="password" name="rContrasenaUsuario">

            <button id="btnIniciarSesion" class="login-form__btn-ingresar" type="submit">Ingresar</button>

          </form>
        
        </div>

        <div class="cont-registro" style="display: none;">

          <form class ="form-cusuario" action="<?php echo SERVERURL; ?>ajax/user-ajax.php" method="POST" data-form="create" autocomplete="off">

            <input id="inpCUsuario" class="inp-text" placeholder="Nombre de usuario" type="text" name="cNombreUsuario">
            <input id="inpCCorreo" class="inp-text" placeholder="Correo" type="text" name="cCorreoUsuario">
            <input id="inpCContrasena1" class="inp-text" placeholder="Contraseña" type="password" name="cContrasena1Usuario">
            <input id="inpCContrasena2" class="inp-text" placeholder="Repita contraseña" type="password" name="cContrasena2Usuario">

            <button type="submit" class="btn-form form-cusuario__btnc">Registrar</button>

          </form>
        
        </div>

    </div>
  </div>
</div>

<script>
  /* -------- Fn. Carga inicial de la página -------- */
  document.addEventListener('DOMContentLoaded', function(){

    ponerEscuchaForms();

  }, false);

  /* -------- Fin carga incial -------- */

  function ponerEscuchaForms() {
    //Submit para crear usuario
    document.querySelectorAll('.form-cusuario').forEach(forms => {
      forms.addEventListener('submit', crearUsuario);
    });

    //Submit para iniciar sesión
    document.querySelectorAll('.form-rusuario').forEach(forms => {
      forms.addEventListener('submit', iniciarSesion);
    });
  }

  /* FUNCIÓN TOGGLE PARA OCULTAR/MOSTRAR FORMULARIO DE LOGIN/REGISTRO */
  document.querySelector('#btnToggleLogin').addEventListener('click', function() {
    let contLogin = document.querySelector('.cont-login');
    let contRegistro = document.querySelector('.cont-registro');

    if(contLogin.style.display == 'block') {
      contLogin.style.display = 'none';
      contRegistro.style.display = 'block';
      document.querySelector('#btnToggleLogin').innerHTML = 'Login';
    }else if(contRegistro.style.display = 'block'){
      contRegistro.style.display = 'none';
      contLogin.style.display = 'block';
      document.querySelector('#btnToggleLogin').innerHTML = 'Registrarme';
    }
  });

  function crearUsuario(e) {
    e.preventDefault();
    document.querySelector('.form-cusuario__btnc').innerHTML = '<div class="spinner"></div>';

    let dataForm = new FormData(this);
    let method = this.getAttribute('method');
    let action = this.getAttribute('action'); //url a donde se va a enviar la info
    let tipoForm = this.getAttribute('data-form'); //tipo de formulario
    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    dataForm.append('tipoForm', tipoForm);

    let config = {
      method: method,
      header: header,
      mode: 'cors',
      cache: 'no-cache',
      body: dataForm
    }

    let promesaCrearUsuario = fetch(action, config);

    promesaCrearUsuario.then(res => res.json())
    .then(phpJsonRes => {

      if(phpJsonRes.res == 'ok') {
        alert('Usuario creado!');
      }else {        
        if(phpJsonRes.res == 'fail') {
          alert('No se pudo crear el usuario'); 
          console.log('Error: ', phpJsonRes.error);
        } else if(phpJsonRes.res == 'yaExisteUs'){
          alert('Lo sentimos, el usuario ya existe!');
        } else if(phpJsonRes.res == 'yaExisteCorreo'){
          alert('El correo digitado ya existe!');
        } else if(phpJsonRes.res == 'correoFalse'){
          alert('Digite un correo valido!');
        } else if(phpJsonRes.res == 'passNoCoincide'){
          alert('Las claves no coinciden!');
        } else {
          alert('No hubo respuesta del servidor');
        }

      }
      
      //ponerEscuchaForms();
      //iniciarModales();
      document.querySelector('.form-cusuario__btnc').innerHTML = 'Registrar';
    }); 


  }

  function iniciarSesion(e) {
    e.preventDefault();

    //Obtener elementos
    let btnIniciarSesion = document.querySelector('#btnIniciarSesion');
    let msgLogin = document.querySelector('.login__msg');

    msgLogin.style.display = 'none';
    btnIniciarSesion.innerHTML = '<div class="spinner"></div>';

    let dataForm = new FormData(this);
    let method = this.getAttribute('method');
    let action = this.getAttribute('action'); //url a donde se va a enviar la info
    let tipoForm = this.getAttribute('data-form'); //tipo de formulario
    let header = new Headers();
    header.append('Content-Type', 'text/html; charset=utf-8');
    dataForm.append('tipoForm', tipoForm);

    let config = {
      method: method,
      header: header,
      mode: 'cors',
      cache: 'no-cache',
      body: dataForm
    }

    let promesaLogin = fetch(action, config);

     promesaLogin.then(res => res.json())
    .then(phpJsonRes => {

      console.log(phpJsonRes);

      if(phpJsonRes.res == 'ok') {
        window.location.href='<?php echo SERVERURL; ?>tarea/';
      }else {
        msgLogin.style.display = 'block'

        if(phpJsonRes.res == 'fail') {
          msgLogin.innerHTML = 'Usuario o Contraseña incorrectos';
          console.log(phpJsonRes.error);
        }else if(phpJsonRes.res == 'nadaOk') {
          msgLogin.innerHTML = 'El usuario no existe!';
        }else if(phpJsonRes.res == 'empty') {
          msgLogin.innerHTML = 'Por favor llene los campos vacios';
        }else if(phpJsonRes.res == 'maxLenPass') {
          msgLogin.innerHTML = 'La contraseña es demasiado larga!';
        }else {
          msgLogin.innerHTML = 'No hubo respuesta del servidor';
        }

        //Reestablecer texto botón
        btnIniciarSesion.innerHTML = 'Ingresar';
      }
      
    });//fin promesa

  }

</script>