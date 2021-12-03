<?php
if ($ajaxRequest) {
  require_once '../model/TareaModel.php';
} else {
  require_once './model/TareaModel.php'; //Si entra acá queire decir que se está ejecutando desde index.php
}

class TareaController extends TareaModel
{

  /* ---------- Controlador nueva tarea [return: json] ---------- */
  public function agregarTareaController()
  {

    /* 1. Limpiar cadenas */
    $categoria = MainModel::cleanString($_POST['cCategoriaTarea']);
    $nuevaCategoria = MainModel::cleanString($_POST['cNuevaCategoria']);
    $subcategoria = MainModel::cleanString($_POST['cSubcategoriaTarea']);
    $nuevaSubcategoria = MainModel::cleanString($_POST['cNuevaSubcategoriaTarea']);
    $descripcion = MainModel::cleanString($_POST['cDescripcionTarea']);
    $fecha = MainModel::cleanString($_POST['cFechaTarea']) . ' ' . date('H:i:s');

    /* return json_encode(['res' => 'ok', 
      'categoria' => $categoria,
      'nuevaCategoria' => $nuevaCategoria,
      'subcategoria' => $subcategoria,
      'nuevaSubCategoria' => $nuevaSubCategoria,
      'descripcion' => $descripcion,
      'fecha' => $fecha
      ]);
      exit; */

    /* Organizar mayusculas y minusculas de categoria y subcategoria */
    $nuevaCategoria = mb_strtolower($nuevaCategoria); // todo a minsculas
    $nuevaCategoria = ucfirst($nuevaCategoria); // primera a mayus
    $nuevaSubcategoria = mb_strtolower($nuevaSubcategoria); // convirte todo a minsculas
    $nuevaSubcategoria = ucfirst($nuevaSubcategoria); // primera letra c/palabra a mayus 

    //Validación e inserción de Categoria
    if ($categoria == 'NuevaCategoria') {
      $categoria = self::filtrarCategoriaController($nuevaCategoria);
    } //Fin validación categoría

    //Validación e inserción de SubCategoria
    if ($subcategoria == 'NuevaSubCategoria') {
      $subcategoria = self::filtrarSubcategoriaController($categoria, $nuevaSubcategoria);
    } //Fin validación de subcategoría

    /* 5. Crear el array que se va a pasar para realizar la consulta */
    session_start(['name' => 'daniapp']);

    $arrDatosTarea = [
      "usu_id" => $_SESSION['id_daniapp'],
      "sub_id" => $subcategoria,
      "descripcion" => $descripcion,
      "fecha" => $fecha
    ];

    $PDOTarea = TareaModel::createTareaModel($arrDatosTarea);
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        $PDOTarea = null;
        return json_encode(['res' => 'ok']);
        exit;
      } else if ($CantResultados > 0) {
        return json_encode(['res' => 'nadaOk', 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }
  }

  public function actualizarTareaController()
  {
    $tareaId = MainModel::cleanString($_POST['uTareaId']);
    $categoria = MainModel::cleanString($_POST['uCategoriaTarea']);
    $nuevaCategoria = MainModel::cleanString($_POST['uNuevaCategoria']);
    $subcategoria = MainModel::cleanString($_POST['uSubcategoriaTarea']);
    $nuevaSubcategoria = MainModel::cleanString($_POST['uNuevaSubcategoriaTarea']);
    $descripcion = MainModel::cleanString($_POST['uDescripcionTarea']);
    $fecha = MainModel::cleanString($_POST['uFechaTarea']) . ' ' . date('H:i:s');

    /* Organizar mayusculas y minusculas de categoria y subcategoria */
    $nuevaCategoria = mb_strtolower($nuevaCategoria); // todo a minsculas
    $nuevaCategoria = ucfirst($nuevaCategoria); // primera a mayus
    $nuevaSubcategoria = mb_strtolower($nuevaSubcategoria); // convirte todo a minsculas
    $nuevaSubcategoria = ucfirst($nuevaSubcategoria); // primera letra c/palabra a mayus 

    //Validación e inserción de Categoria
    if ($categoria == 'NuevaCategoria') {
      $categoria = self::filtrarCategoriaController($nuevaCategoria);
    } //Fin validación categoría

    //Validación e inserción de SubCategoria
    if ($subcategoria == 'NuevaSubCategoria') {
      $subcategoria = self::filtrarSubcategoriaController($categoria, $nuevaSubcategoria);
    } //Fin validación de subcategoría

    /* 5. Crear el array que se va a pasar para realizar la consulta */
    session_start(['name' => 'daniapp']);

    $arrDatosTarea = [
      "tar_id" => $tareaId,
      "usu_id" => $_SESSION['id_daniapp'],
      "sub_id" => $subcategoria,
      "descripcion" => $descripcion,
      "fecha" => $fecha
    ];

    $PDOTarea = TareaModel::updateTareaModel($arrDatosTarea);

    if ($PDOTarea->rowCount() > 0) {
      return json_encode(['res' => 'ok']);
      exit;
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      exit;
    }
  }

  /* ---------- Controlador obtener lista en formato de option de categorias [return: json] ---------- */
  public function obtenerListados()
  {

    /* EL CODIGO DE ESTA FUNCIÓN HAY QUE ARREGLARLO, GUIARME POR EL DE obtenerCantidadTareas QUE ESE ESTÁ BIEN */

    $listaCategorias = '';
    $listaSubCategorias = '';

    //Lista Categorias
    $PDOSelCategorias = MainModel::runSimpleQuery("SELECT PKCAT_ID, CAT_NOMBRE FROM indegwgj_db_daniapp.tbl_categoria ORDER BY CAT_NOMBRE");
    if ($PDOSelCategorias->rowCount() > 0) {
      $arrCategorias = $PDOSelCategorias->fetchAll();

      for ($i = 0; $i < count($arrCategorias); $i++) {
        $listaCategorias .= '<option value="' . $arrCategorias[$i]['PKCAT_ID'] . '"> ' . $arrCategorias[$i]['CAT_NOMBRE'] . ' </option>';
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOSelCategorias->errorInfo(), 'queryString' => $PDOSelCategorias->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      exit;
    }

    //Lista SubCategorias
    $PDOSelSubCategorias = MainModel::runSimpleQuery("SELECT PKSUB_ID, SUB_NOMBRE FROM indegwgj_db_daniapp.tbl_subcategoria ORDER BY SUB_NOMBRE");
    if ($PDOSelSubCategorias->rowCount() > 0) {
      $arrSubCategorias = $PDOSelSubCategorias->fetchAll();
      for ($i = 0; $i < count($arrSubCategorias); $i++) {
        $listaSubCategorias .= '<option value="' . $arrSubCategorias[$i]['PKSUB_ID'] . '"> ' . $arrSubCategorias[$i]['SUB_NOMBRE'] . ' </option>';
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOSelSubCategorias->errorInfo(), 'queryString' => $PDOSelSubCategorias->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      exit;
    }

    return json_encode(['res' => 'ok', 'listaCategorias' => $listaCategorias, 'listaSubCategorias' => $listaSubCategorias]);
    exit;
  }

  /* ---------- Controlador [return: json] ---------- */
  public function obtenerListaSubcategoriaFiltro()
  {
    $FKCAT_ID = $_POST['rListaIDCategoria'];
    $listaSubcategorias = '';

    //Lista SubCategorias
    $PDOSelSubCategorias = MainModel::runSimpleQuery("SELECT PKSUB_ID, SUB_NOMBRE FROM indegwgj_db_daniapp.tbl_subcategoria WHERE FKCAT_ID = '$FKCAT_ID' ORDER BY SUB_NOMBRE");
    if ($PDOSelSubCategorias == true) {
      $CantResultados = $PDOSelSubCategorias->rowCount();

      if ($CantResultados > 0) {
        $arrSubCategorias = $PDOSelSubCategorias->fetchAll();
        for ($i = 0; $i < count($arrSubCategorias); $i++) {
          $listaSubcategorias .= '<option value="' . $arrSubCategorias[$i]['PKSUB_ID'] . '"> ' . $arrSubCategorias[$i]['SUB_NOMBRE'] . ' </option>';
        }

        return json_encode(['res' => 'ok', 'listaSubcategorias' => $listaSubcategorias]);
        $PDOSelSubCategorias = null;
        exit;
      } else if ($CantResultados < 1) {
        return json_encode(['res' => 'nadaOk']);
        $PDOSelSubCategorias = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOSelSubCategorias->errorInfo(), 'queryString' => $PDOSelSubCategorias->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOSelSubCategorias = null;
      exit;
    }
  }

  /* ---------- Controlador obtener cantidad de tareas del dia/mes y año [return: json] ---------- */
  public function obtenerCantidadTareas()
  {
    session_start(['name' => 'daniapp']);

    $usu_id = $_SESSION['id_daniapp'];
    $hoy = date("Y-m-d");
    $mes = date('Y-m');
    $agno = date('Y');
    $cantTareasHoy = 0;
    $cantTareasMes = 0;
    $cantTareasAgno = 0;

    //Cantidad tareas de hoy
    $PDOTarea = MainModel::runSimpleQuery("SELECT COUNT(PKTAR_ID) AS CANT_HOY FROM indegwgj_db_daniapp.tbl_tarea WHERE FKUSU_ID = '$usu_id' AND TAR_FECHA BETWEEN '$hoy 00:00:00' AND '$hoy 23:59:59'");
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        $arrTarea = $PDOTarea->fetch();

        $cantTareasHoy = $arrTarea['CANT_HOY'];
        $PDOTarea = null; //Cierra la conexión

      } else if ($CantResultados < 1) {
        $cantTareasHoy = 0;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }

    //Cantidad tareas del mes
    $PDOTarea = MainModel::runSimpleQuery("SELECT COUNT(PKTAR_ID) AS CANT_MES FROM indegwgj_db_daniapp.tbl_tarea WHERE FKUSU_ID = '$usu_id' AND TAR_FECHA BETWEEN '$mes-1 00:00:00' AND '$mes-31 23:59:59'");
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        $arrMes = $PDOTarea->fetch();

        $cantTareasMes = $arrMes['CANT_MES'];
        $PDOTarea = null; //Cierra la conexión

      } else if ($CantResultados < 1) {
        $cantTareasMes = 0;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }

    //Cantidad tareas totales del año
    $PDOTarea = MainModel::runSimpleQuery("SELECT COUNT(PKTAR_ID) AS CANT_TOTALES FROM indegwgj_db_daniapp.tbl_tarea WHERE FKUSU_ID = '$usu_id' AND TAR_FECHA BETWEEN '$agno-1-1 00:00:00' AND '$agno-12-31 23:59:59'");
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        $arrAgno = $PDOTarea->fetch();

        $cantTareasAgno = $arrAgno['CANT_TOTALES'];
        $PDOTarea = null; //Cierra la conexión

      } else if ($CantResultados < 1) {
        $cantTareasAgno = 0;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }

    return json_encode(['res' => 'ok', 'cantTareasHoy' => $cantTareasHoy, 'cantTareasMes' => $cantTareasMes, 'cantTareasAgno' => $cantTareasAgno]);
    $PDOTarea = null;
    exit;
  }

  /* ---------- Controlador obtener tareas ¿caules? depende de lo que se le requiera [return: json] ---------- */
  public function obtenerTareasController()
  {
    session_start(['name' => 'daniapp']);
    $usu_id = $_SESSION['id_daniapp'];

    //Todas las tareas
    $sQuery = "SELECT tt.PKTAR_ID, tt.TAR_DESCRIPCION, tt.TAR_FECHA, tc.CAT_NOMBRE, ts.SUB_NOMBRE FROM indegwgj_db_daniapp.tbl_tarea AS tt
      JOIN indegwgj_db_daniapp.tbl_subcategoria AS ts ON tt.FKSUB_ID = ts.PKSUB_ID
      JOIN indegwgj_db_daniapp.tbl_categoria AS tc ON ts.FKCAT_ID = tc.PKCAT_ID
      WHERE tt.FKUSU_ID = '$usu_id'";

    //Consulta solo por categoría
    if (isset($_POST['rTareasCat'])) {
      $CAT_ID = MainModel::cleanString($_POST['rCateFiltro']);

      $sQuery .= " AND ts.FKCAT_ID ='$CAT_ID'";
    }

    //Consulta por categoría y subcategoría
    if (isset($_POST['rTareasCatSub'])) {
      $CAT_ID = MainModel::cleanString($_POST['rCateFiltro']);
      $SUB_ID = MainModel::cleanString($_POST['rSubCateFiltro']);

      $sQuery .= " AND ts.FKCAT_ID ='$CAT_ID' AND ts.PKSUB_ID = '$SUB_ID'";
    }

    //Consulta solo por rango de fecha
    if (isset($_POST['rTareasFecha'])) {
      $fechaInicio = $_POST['rFechaInicioFiltro'] . ' 00:00:00';
      $fechaFin = $_POST['rFechaFinFiltro'] . ' 23:59:59';

      $sQuery .= " AND tt.TAR_FECHA BETWEEN '$fechaInicio' AND '$fechaFin'";
    }

    //Consulta por categoria y rango de fecha
    if (isset($_POST['rTareasCat&Fecha'])) {
      $CAT_ID = $_POST['rCateFiltro'];
      $fechaInicio = $_POST['rFechaInicioFiltro'] . ' 00:00:00';
      $fechaFin = $_POST['rFechaFinFiltro'] . ' 23:59:59';

      $sQuery .= " AND ts.FKCAT_ID ='$CAT_ID' AND tt.TAR_FECHA BETWEEN '$fechaInicio' AND '$fechaFin'";
    }

    //Consulta por categoria, subcategoría y rango de fecha
    if (isset($_POST['rTareasCatSub&Fecha'])) {
      $CAT_ID = $_POST['rCateFiltro'];
      $SUB_ID = $_POST['rSubCateFiltro'];
      $fechaInicio = $_POST['rFechaInicioFiltro'] . ' 00:00:00';
      $fechaFin = $_POST['rFechaFinFiltro'] . ' 23:59:59';

      $sQuery .= " AND ts.FKCAT_ID ='$CAT_ID' AND ts.PKSUB_ID = '$SUB_ID' AND tt.TAR_FECHA BETWEEN '$fechaInicio' AND '$fechaFin'";
    }

    //Ordenar mostrando el mas reciente
    $sQuery .= " ORDER BY tt.TAR_FECHA DESC";

    $PDOTarea = MainModel::runSimpleQuery($sQuery);
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {

        return json_encode(['res' => 'ok', 'body' => self::constructorContenidoController($PDOTarea)]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      } else if ($CantResultados < 1) {
        return json_encode(['res' => 'nadaOk', 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }
  }

  /* ? ---------- Controlador obtener tareas (esto debía mejor retornar un Array o un JSON, pero es la misma que obtenerTareasAllController)
  la uso para el informe [return: json] ---------- */
  public function obtenerTareasAllController()
  {
    session_start(['name' => 'daniapp']);
    $usu_id = $_SESSION['id_daniapp'];

    //Todas las tareas
    $sQuery = "SELECT tt.PKTAR_ID, tt.TAR_DESCRIPCION, tt.TAR_FECHA, tc.CAT_NOMBRE, ts.SUB_NOMBRE FROM indegwgj_db_daniapp.tbl_tarea AS tt
      JOIN indegwgj_db_daniapp.tbl_subcategoria AS ts ON tt.FKSUB_ID = ts.PKSUB_ID
      JOIN indegwgj_db_daniapp.tbl_categoria AS tc ON ts.FKCAT_ID = tc.PKCAT_ID
      WHERE tt.FKUSU_ID = '$usu_id' ORDER BY tt.TAR_FECHA DESC";

    $PDOTarea = MainModel::runSimpleQuery($sQuery);
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {

        $arrDatos = $PDOTarea->fetchAll();
        $arrDatosTabla = [];

        for ($i = 0; $i < count($arrDatos); $i++) {
          $arrFechaHora = explode(' ', $arrDatos[$i]['TAR_FECHA']);
          $fecha = $arrFechaHora[0];
          $hora = $arrFechaHora[1];
          array_push($arrDatosTabla, ['descripcion' => $arrDatos[$i]['TAR_DESCRIPCION'], 'categoria' => $arrDatos[$i]['CAT_NOMBRE'], 'subcategoria' => $arrDatos[$i]['SUB_NOMBRE'], 'fecha' => $fecha]);
        }

        return json_encode(['res' => 'ok', 'body' => $arrDatosTabla]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      } else if ($CantResultados < 1) {
        return json_encode(['res' => 'nadaOk', 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }
  }

  /* ---------- Controlador que solo envia los datos de una tarea [return: json] ---------- */
  public function obtenerUnaTareaController()
  {
    $tareaId = MainModel::cleanString($_POST['rIdUnaTarea']);

    $PDOTarea = TareaModel::selectUnaTareaModel($tareaId);
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        $arrResultado = $PDOTarea->fetch();

        return json_encode([
          'res' => 'ok',
          'idTarea' => $arrResultado['PKTAR_ID'],
          'idCat' => $arrResultado['FKCAT_ID'],
          'idSubcat' => $arrResultado['FKSUB_ID'],
          'descripcion' => $arrResultado['TAR_DESCRIPCION'],
          'fecha' => explode(' ', $arrResultado['TAR_FECHA'])[0]
        ]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      } else if ($CantResultados < 1) {
        return json_encode(['res' => 'nadaOk', 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }
  }

  /* ---------- Controlador constructor de contenido de tareas [return: string] ---------- */
  public static function constructorContenidoController($objPDOStatement)
  {
    $arrDatos = $objPDOStatement->fetchAll();

    $contenido = '';

    for ($i = 0; $i < count($arrDatos); $i++) {

      $fechaHora = $arrDatos[$i]['TAR_FECHA'];
      $fecha = explode(' ', $fechaHora);

      $contenido .= '
          <div class="col-sm-12 col-lg-6" style="margin-bottom: 1rem">          
          <div class="card card-tarea">
              <div class="card-body">
                <p class="card-text card-descripcion">' . $arrDatos[$i]['TAR_DESCRIPCION'] . '</p>

                <div class="d-flex">
                  <div class="card-cat px-2 me-2">' . $arrDatos[$i]['CAT_NOMBRE'] . '</div>
                  <div class="card-subcat px-2">' . $arrDatos[$i]['SUB_NOMBRE'] . '</div>
                </div>
                  
                  <h6 class="mb-2 text-end">' . $fecha[0] . ' </h6>
                <a href="#" id="btnIdEliTarea' . $arrDatos[$i]['PKTAR_ID'] . '" class="btn btn-secondary btn-swal-dtarea"><i class="fas fa-trash-alt"></i></a>
                <a href="#" class="btn btn-secondary btn-utarea" data-id-utarea="' . $arrDatos[$i]['PKTAR_ID'] . '" data-bs-toggle="modal" data-bs-target="#modalUTarea"><i class="fas fa-edit"></i></a>
              </div>
            </div>
          </div>';
    }

    return $contenido;
  }

  /* ---------- Controlador para obtener la categoría en caso que sea "Nueva categoría" [return: string] ---------- */
  public static function filtrarCategoriaController($nuevaCategoria)
  {
    //Verificar si la categoría escrita en el input ya existe en la base
    $PDOTarea = MainModel::runSimpleQuery("SELECT PKCAT_ID FROM indegwgj_db_daniapp.tbl_categoria WHERE CAT_NOMBRE = '$nuevaCategoria'");
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        //La categoría ya existe, traer su pk
        $arrResultado = $PDOTarea->fetch();
        $categoria = $arrResultado['PKCAT_ID'];
        $PDOTarea = null; //Cierra la conexión
        $arrResultado = []; //Vaciarlo
      } else if ($CantResultados < 1) {
        //La categoría no existe, crearla
        $PDOTarea = MainModel::runSimpleQuery("INSERT INTO indegwgj_db_daniapp.tbl_categoria (CAT_NOMBRE) VALUES ('$nuevaCategoria')");
        if ($PDOTarea == true) {
          $CantResultados = $PDOTarea->rowCount();

          if ($CantResultados > 0) {
            $PDOTarea = null;

            //Bajar la PK de la nueva categoría
            $PDOTarea = MainModel::runSimpleQuery("SELECT PKCAT_ID FROM indegwgj_db_daniapp.tbl_categoria WHERE CAT_NOMBRE = '$nuevaCategoria'");
            if ($PDOTarea == true) {
              $CantResultados = $PDOTarea->rowCount();

              if ($CantResultados > 0) {
                $arrResultado = $PDOTarea->fetch();
                $categoria = $arrResultado['PKCAT_ID'];
                $PDOTarea = null; //Cierra la conexión
                $arrResultado = []; //Vaciarlo

                return $categoria;
              }
            }
          }
        } else {
          return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
          $PDOTarea = null; //Cierra la conexión
          exit;
        }
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }
  }

  /* ---------- Controlador para obtener la subcategoría en caso que sea "Nueva subcategoría" [return: string] ---------- */
  public static function filtrarSubcategoriaController($categoria, $nuevaSubcategoria)
  {
    //Verificar si la sub categoria escrita en el input ya existe en la base
    $PDOTarea = MainModel::runSimpleQuery("SELECT PKSUB_ID FROM indegwgj_db_daniapp.tbl_subcategoria WHERE SUB_NOMBRE = '$nuevaSubcategoria' AND FKCAT_ID = '$categoria'"); //Obj PDOStatement
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        //La subcategoría ya existe
        $arrResultado = $PDOTarea->fetch();
        $subcategoria = $arrResultado['PKSUB_ID'];
        $PDOTarea = null; //Cierra la conexión
        $arrResultado = []; //Vaciarlo
      } else if ($CantResultados < 1) {
        //La subcategoría no existe, crearla
        $PDOTarea = MainModel::runSimpleQuery("INSERT INTO indegwgj_db_daniapp.tbl_subcategoria (FKCAT_ID, SUB_NOMBRE) VALUES ('$categoria', '$nuevaSubcategoria')");
        if ($PDOTarea == true) {
          $CantResultados = $PDOTarea->rowCount();

          if ($CantResultados > 0) {
            $PDOTarea = null;

            //Bajar la PK de la nueva subcategoría
            $PDOTarea = MainModel::runSimpleQuery("SELECT PKSUB_ID FROM indegwgj_db_daniapp.tbl_subcategoria WHERE FKCAT_ID = '$categoria' AND SUB_NOMBRE = '$nuevaSubcategoria'");
            if ($PDOTarea == true) {
              $CantResultados = $PDOTarea->rowCount();

              if ($CantResultados > 0) {
                $arrResultado = $PDOTarea->fetch();
                $subcategoria = $arrResultado['PKSUB_ID'];
                $PDOTarea = null; //Cierra la conexión
                $arrResultado = []; //Vaciarlo

                return $subcategoria;
              }
            }
          }
        } else {
          return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
          $PDOTarea = null; //Cierra la conexión
          exit;
        }
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }
  }

  /* ---------- Controlador elimina una tarea [return: json] ---------- */
  public static function eliminarTareaController()
  {
    $tareaId = MainModel::cleanString($_POST['dTareaId']);

    $PDOTarea = TareaModel::deleteTareaModel($tareaId);
    if ($PDOTarea == true) {
      $CantResultados = $PDOTarea->rowCount();

      if ($CantResultados > 0) {
        return json_encode(['res' => 'ok']);
        $PDOTarea = null; //Cierra la conexión
        exit;
      } else if ($CantResultados < 1) {
        return json_encode(['res' => 'nadaOk', 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
        $PDOTarea = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOTarea->errorInfo(), 'queryString' => $PDOTarea->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOTarea = null; //Cierra la conexión
      exit;
    }
  }

  public function eliminarCategoriaController()
  {
    $tareaId = MainModel::cleanString($_POST['dCatId']);

    $PDOCategoria = TareaModel::deleteCategoriaModel($tareaId);
    if ($PDOCategoria == true) {
      $CantResultados = $PDOCategoria->rowCount();

      if ($CantResultados > 0) {
        return json_encode(['res' => 'ok']);
        $PDOCategoria = null; //Cierra la conexión
        exit;
      } else if ($CantResultados < 1) {
        return json_encode(['res' => 'nadaOk', 'queryString' => $PDOCategoria->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
        $PDOCategoria = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOCategoria->errorInfo(), 'queryString' => $PDOCategoria->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOCategoria = null; //Cierra la conexión
      exit;
    }
  }

  public function eliminarSubcategoriaController()
  {
    $subCatId = MainModel::cleanString($_POST['dSubcatId']);

    $PDOSubcategoria = TareaModel::deleteSubcategoriaModel($subCatId);
    if ($PDOSubcategoria == true) {
      $CantResultados = $PDOSubcategoria->rowCount();

      if ($CantResultados > 0) {
        return json_encode(['res' => 'ok']);
        $PDOSubcategoria = null; //Cierra la conexión
        exit;
      } else if ($CantResultados < 1) {
        return json_encode(['res' => 'nadaOk', 'queryString' => $PDOSubcategoria->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
        $PDOSubcategoria = null; //Cierra la conexión
        exit;
      }
    } else {
      return json_encode(['res' => 'fail', 'error' => $PDOSubcategoria->errorInfo(), 'queryString' => $PDOSubcategoria->queryString, 'lugar' => 'archivo ' .  __FILE__ . ' ~ linea ' . __LINE__]);
      $PDOSubcategoria = null; //Cierra la conexión
      exit;
    }
  }
}
