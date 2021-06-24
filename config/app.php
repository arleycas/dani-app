<?php
  /* --------------------------------------------------------------------------------
  ----------CONSTANTES QUE USA EL SISTEMA Y CONFIGURACIONES GLOBALES ---------------
  --------------------------------------------------------------------------------*/

  /* -------------------- CREDENCIALES GENERALES -------------------- */

  //const SERVERURL = 'https://indexco.website/'; //servidor online
  const SERVERURL = 'http://localhost/dani-app/'; //servidor local

  // Nombre de la app o la empresa
  const COMPANY = 'DaniApp';

  // definir Zona horaria para las fechas de nuestro sistema en esta página se busca cual es la nuestra https://www.php.net/manual/es/timezones.america.php*/
  date_default_timezone_set('America/Bogota');

  /* -------------------- CREDENCIALES PARA DB -------------------- */

  /* 
  //Credenciales online
  const SERVERDB = 'localhost'; //server270.web-hosting.com (para conectarme remotamente a la db)
  const DB = 'indegwgj_db_daniapp';
  const USER = 'indegwgj_arley';
  const PASS = 'eU#D}-Wo?sDv';
  const SGBD = 'mysql:host='.SERVERDB.';dbname='.DB.';charset=utf8'; */

  //Credenciales locales
  const SERVERDB = 'localhost';
  const DB = 'indegwgj_db_daniapp';
  const USER = 'root';
  const PASS = '';
  const SGBD = 'mysql:host='.SERVERDB.';dbname='.DB.';charset=utf8';

  // Valores unicos para usar en el sistema
  const METHOD = 'AES-256-CBC';
  const SECRET_KEY = '$DANIAPP@2021'; //Se pone lo que se quiera
  const SECRET_IV = '071596'; //Tambien el que se quiera
