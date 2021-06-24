<?php
/* Está variable está en el archivo template.php */
  if($ajaxRequest) {
    //Cuando es una petición Ajax, quiere decir que el archivo que está intentando incluir el archivo está dentro de la carpeta Ajax
    require_once '../config/app.php';
  }else {
    //Cuando no es una petición Ajax quiere decir que estamos intentando incluir este archivo desde index.php
    require_once './config/app.php';
  }

  /* Esta clase contiene todas las funciones que vamos a usar en todo el sistemsa: conexion BBDD, evitar inyecciones sql, paginadores etc */
  class MainModel {

    /* ---------- Función conectar a DB ---------- */
    protected static function connectDB() {
      try {
        $connection = new PDO(SGBD, USER, PASS);
        $connection->exec('set names utf8'); //ANTES: SET CHARACTER SET utf8
        return $connection; //Esto solo devuelve la conexión a la DB no el objeto PDOStatement
      }catch(Exception $e) {
        die('No se pudo conectar a la base de datos: ' . $e->getMessage());
        exit;
      }
    }

    /* ---------- Función ejecutar consulta simple [return: Objeto PDOStatement] ---------- */
    protected static function runSimpleQuery($query) {
      $sql = self::connectDB()->prepare($query);
      $sql->execute();
      return $sql;
    }

    /* ---------- Funciones para encriptar y desencriptar strings ----------*/
    public function encryption($string) {
      $output = FALSE;
      $key = hash('sha256', SECRET_KEY);
      $iv = substr(hash('sha256', SECRET_IV), 0, 16);
      $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
      $output = base64_encode($output);
      return $output;
    }

    protected function decryption($string) {
      $key = hash('sha256', SECRET_KEY);
      $iv = substr(hash('sha256', SECRET_IV), 0, 16);
      $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
      return $output;
    }

    /* ---------- Función generar código de 9 caracteres semi-aleatorio (ya que toma las 3 primeras letras de la palabra) ----------*/
    protected function randomNineCode($string) {
      /* 1.*.  Quita especios en blanco de enmedio*/
      $finalCode = str_replace(' ', '', $string);

      /* 1.*. Convertir el nombre en array para contar las letras */
      $arrString = mb_str_split($finalCode);

      /* 1.*. Verificar si tiene más de tres caracteres */
      if(count($arrString) == 1) {
        array_push($arrString, 'x', 'x');
        $finalCode = implode('', $arrString);
      }else if(count($arrString) == 2) {
        array_push($arrString, 'x');
        $finalCode = implode('', $arrString);
      }else {
        $arrStringThree = mb_str_split($finalCode, 3);
        $finalCode = $arrStringThree[0];
      }

      /* 1.*. Convertir en miniscula las tres letras devueltas */
      $finalCode = mb_strtolower($finalCode);

      /* 1.*. Reemplazar tildes y eñes */
      $finalCode = self::deleteAccent($finalCode);

      /* 1.*. Generar numero de 3 digitos y pegarlo a lo que llevamos del string*/
      $finalCode .= rand(100000, 999999);

      return $finalCode;
    }

    /* ---------- Función que devuelve las palabras sin tildes y cambia 'ñ' por 'n' ----------*/
    protected function deleteAccent($string) {
      //Reemplazar A y a
      $string = str_replace(
        ['Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'],
        ['A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'],
        $string);

      //Reemplazar A y a
      $string = str_replace(
        ['É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'],
        ['E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'],
        $string);
        
      //Reemplazamos la I y i
      $string = str_replace(
        ['Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'],
        ['I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'],
        $string);

      //Reemplazamos la O y o
      $string = str_replace(
        ['Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'],
        ['O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'],
        $string);

      //Reemplazamos la U y u
      $string = str_replace(
        ['Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'],
        ['U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'],
        $string);

      //Reemplazamos la N, n, C y c
      $string = str_replace(
        ['Ñ', 'ñ', 'Ç', 'ç'],
        ['N', 'n', 'C', 'c'],
        $string);

      return $string;
    } //fin deleteAccent()


    /* ---------- Función generar código aleatorio ----------*/
    protected function randomCodeGenerator($letter, $length, $num) {
      for ($i=0; $i <= $length; $i++) { 
        $number = rand(0, 9);
        $letter .= $number;
      }

      return $letter . "-$num";
    }

    /* ---------- Función limpiar cadenas de texto ----------*/
    protected function cleanString($string) { /* Ayuda a evitar inyección sql */
      $string = trim($string); /* Quita espacios en blanco al inicio y al final */
      $string = stripslashes($string); /* Quita "slashes" invertidos [ \ ] */
      $string = str_ireplace('<script>', '', $string); /* Remplaza cierto caracter o string, en este caso que no haya JS */
      $string = str_ireplace('</script>', '', $string);
      $string = str_ireplace('<script src>', '', $string);
      $string = str_ireplace('<script type=>', '', $string);
      $string = str_ireplace('SELECT * FROM', '', $string);
      $string = str_ireplace('DELETE FROM', '', $string);
      $string = str_ireplace('INSERT INTO', '', $string);
      $string = str_ireplace('DROP TABLE', '', $string);
      $string = str_ireplace('DROP DATABASE', '', $string);
      $string = str_ireplace('TRUNCATE TABLE', '', $string);
      $string = str_ireplace('SHOW TABLES', '', $string);
      $string = str_ireplace('SHOW DATABASES', '', $string);
      $string = str_ireplace('<?php', '', $string);
      $string = str_ireplace('?>', '', $string);
      $string = str_ireplace('--', '', $string);
      $string = str_ireplace('^', '', $string);
      $string = str_ireplace('[', '', $string);
      $string = str_ireplace(']', '', $string);
      $string = str_ireplace('==', '', $string);
      $string = str_ireplace(';', '', $string);
      $string = str_ireplace('::', '', $string);

      return $string;
    }

    /* ---------- Función validar datos ----------*/
    protected static function checkData($filter, $string) {
      if(preg_match('/^'.$filter.'$/', $string)) {
        return false;
      }else {
        return true;
      }
    }

    /* ---------- Función validar fechas ----------*/
    protected static function checkDate($date) {
      $values = explode('-', $date);

      if(count($values) == 3 && checkdate($values[1], $values[2], $values[0])) {
        return false;
      }else {
        return true;
      }
    }

  }