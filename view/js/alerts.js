/* https://www.youtube.com/watch?v=Cu8S1Mz3G2M&ab_channel=CarlosAlfaro */
/* document.querySelectorAll('.form-ajax').forEach(forms => {
  forms.addEventListener('submit', sendFormAjax);
});; */

function sendFormAjax(e) {
  e.preventDefault();

  //alert('sirve el ajax');

  let data = new FormData(this); //Se guardan los datos de todos los inputs del formulario
  let method = this.getAttribute('method');
  let action = this.getAttribute('action');
  let tipo = this.getAttribute('data-form');
  let contRes = this.getAttribute('data-res');
  let header = new Headers();
  header.append('Content-Type', 'text/html; charset=utf-8');

  //console.log(data.get('regName'), data.get('regEmail'), data.get('regPass1'), data.get('regPass2'));
  //Ojó si el input está disabled no lo deja tomar el valor

  let config = {
    method: method,
    header: header,
    mode: 'cors',
    cache: 'no-cache',
    body: data
  }

  let alertText;

  if(tipo === 'save') {
    alertText = 'Los datos quedarán guardados en el sistema';
  }else if(tipo == 'delete') {
    alertText = 'Los datos serán eliminados completamente';
  }else if(tipo === 'update') {
    alertText = 'Los datos del sistema serán actualizados';
  } else if(tipo === 'search') {
    alertText = 'Se eliminará el termino de busqueda y tendras que escribir no nuevo';
  }else if(tipo === 'loans') {
    alertText = 'Desea remover los datos seleccionados para prestamos o reservaciones'
  }else {
    alertText = 'Quieres realizar la operación solicitada'
  }

  let p = fetch(action, config);

  console.log(action);

  /* Modificar si algúna propiedad de objeto JSON viene vacia que no se reemplaze */

  p.then(res => res.json())
  .then(objJson => {
    document.querySelector('.res-server').innerHTML = `
    <b style="color: #772c2c"> Respuesta del servidor: </b> <br> <br>
    ${objJson.message}
    action del form: ${action}`;

    document.querySelector(contRes).innerHTML = `
    ${objJson.body}
    `;

    /* NOTA MUY IMPORTANTE:
    Tengo respuestas del servidor que me traen código que en su interior tienen relación con JavaScript
    por ejemplo al hacer la petición de traer la lista de libros, cada libro tiene su botón de borrar y editar
    estos botones tienen un manejador de eventos (addEventListener) vinculado a este script de JS, por lo que 
    al actualizar la lista esta información se re-escribe (o sea se crean nuevos objetos en la pagina) por lo tanto para JavaScript 
    estos objetos ya desaparecieron y por lo tanto hay que volver a asignarle el manejador de eventos a estos nuevos objetos
    que traigo de la respuesta:
    */
    document.querySelectorAll('.form-ajax').forEach(forms => {
      forms.addEventListener('submit', sendFormAjax);
    });

    /* Ej: Existe una lista de personaje con sus botones correspondientes y cada botón tiene su manejador de eventos (addEvenlistener)
    Le doy eliminar a un personaje, la lista se actualiza (desde php se traen toda la lista nueva de pjs con sus botones correspondientes)
    JS se pone loco por que sus botones desaparecieron (aunque hayan unos nuevos botones identicos a los anteriores),
    por lo tanto hay que ponerle de nuevo el manejador de eventos a los nuevos botones  */

    /* NOTA: Ejemplo de función "finally" en la carpeta APIRo (para poner mensaje de carga) */

  });

}

function alertAjax(alerta) { //Recibe un JSON
  /* if(alerta.Alerta === 'simple') {

  } */

  alert(alerta);
}
