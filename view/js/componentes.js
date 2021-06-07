/* ========== Funciones de los componentes de mi mini framework ==========*/

/* ========================================================================
============================= VENTANA MODAL ============================= 
=========================================================================== */
function iniciarModales() {
  /* Clase para los botones que abren el modal */
  document.querySelectorAll('.btn-abrirmodal').forEach(btnAbrirModal => {
    btnAbrirModal.addEventListener('click', mostrarModal);
  });

  /* Cerrar 'modalAddBook' al hacer click fuera de el (uso mousedown porque con click, al hacer click en el modal window tenerlo sostenido y 
  luego moverlo fuera de la ventana  y soltar el click se cierra el modal) */
  document.addEventListener('mousedown', function(e) {
    let elementoDOM = e.target.className;

    if(elementoDOM == 'modal show-modal') {
      cerrarModal();
    }
  });

  /* Cerrar 'modalAddBook' con tecla Esc  */
  document.addEventListener('keyup', function(e) {
    if(e.key === 'Escape') {
      cerrarModal();
    }
  });

  //Inciar botones de cerrar modal
  document.querySelectorAll('.modal__btn-cerrar').forEach(btnCerrarModal => btnCerrarModal.addEventListener('click', cerrarModal));
}

function mostrarModal() {
  let modal = this.getAttribute('data-target');
  document.querySelector(modal).classList.remove('hide-modal');
  document.querySelector(modal).style.display = 'flex';
  document.querySelector(modal).classList.add('show-modal');
}

function cerrarModal() {
  document.querySelectorAll('.modal').forEach(modal => {

    if(modal.classList.contains('show-modal')) {
      modal.classList.remove('show-modal');
      modal.classList.add('hide-modal');

      setTimeout(function(){
        modal.style.display = 'none';
      }, 400);
    }
  });
}