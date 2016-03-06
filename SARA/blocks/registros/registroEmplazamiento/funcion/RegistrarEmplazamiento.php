<?php
namespace registros\registroEmplazamiento\funcion;

use registros\registroEmplazamiento\funcion\redireccionar;

include_once ('redireccionar.php');

if (!isset($GLOBALS["autorizado"])) {
	include ("../index.php");
	exit();
}
class Registrar {

	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	var $miSesion;

	function __construct($lenguaje, $sql, $funcion) {

		$this -> miConfigurador = \Configurador::singleton();
		$this -> miConfigurador -> fabricaConexiones -> setRecursoDB('principal');
		$this -> lenguaje = $lenguaje;
		$this -> miSql = $sql;
		$this -> miFuncion = $funcion;
		$this -> miSesion = \Sesion::singleton();
	}

	function procesarFormulario() {
		foreach ($_FILES as $key => $values) { $archivo = $_FILES[$key];
		}
		$imagedata = file_get_contents($archivo["tmp_name"]);
		$base64 = base64_encode($imagedata);
		//reconstruir una imagen desde el codigo base 64
		//echo '<img  src="data:image/jpeg;base64,'.$base64.'" />';

		//var_dump($_REQUEST);   var_dump ($_FILES);  var_dump($archivo);die;
		//Por ahora está deshabilitado debido a que no he ha hecho el registro de:
		if (false && $_REQUEST['id_tipo_emplazamiento'] == '1') {//Es huerta
			$conexion = "modelo_huerta";
			$esteRecursoDB = $this -> miConfigurador -> fabricaConexiones -> getRecursoDB($conexion);

			$cadenaSql = $this -> miSql -> getCadenaSql('registrarHuerta', $_REQUEST);
			$resultado = $esteRecursoDB -> ejecutarAcceso($cadenaSql, "insertar");
		}

		$conexion = "modelo_emplazamiento";
		$esteRecursoDB = $this -> miConfigurador -> fabricaConexiones -> getRecursoDB($conexion);
		
		$_REQUEST['id_usuario'] = $this -> miSesion -> getValorSesion('idUsuario');
		$_REQUEST['id_usuario'] = 3;
		$_REQUEST['imagen'] = $base64;

		/**
		 * Código para obtener ubicación IP mientras
		 */
		$location = file_get_contents('http://ip-api.com/json/'.$_SERVER['REMOTE_ADDR']);
 		$location = json_decode($location);
		// es posible que la API de Google necesite una key. Solicitar en
		// http://code.google.com/intl/ca/apis/maps/signup.html
		// y ubicar la clave tras "&key=CLAVE"
		//echo '<img style="border:1px solid black;" src="http://maps.google.com/staticmap?center=' . $rec[latitude] . ',' . $rec[longitude] . '&markers=' . $rec[latitude] . ',' . $rec[longitude] . ',tinyblue&zoom=11&size=200x200&key=" />', $rec['city'], ',', $rec['country_code'];
		$_REQUEST['latitud'] = $location->{'lat'};
		$_REQUEST['longitud'] = $location->{'lon'};
		/**
		 * Fin código
		 */
		$cadenaSql = $this -> miSql -> getCadenaSql('registrarEmplazamiento', $_REQUEST);	
		$resultado = $esteRecursoDB -> ejecutarAcceso($cadenaSql, 'busqueda');
		
		if ($resultado) {
			
		} else {
			
		}
		$_REQUEST['id_emplazamiento'] = $resultado[0]['id_emplazamiento'];
		
		$cadenaSql = $this -> miSql -> getCadenaSql('registrarDispositivo', $_REQUEST);		
		$resultado = $esteRecursoDB -> ejecutarAcceso($cadenaSql, 'busqueda');
		
		$_REQUEST['id_dispositivo'] = $resultado[0]['id_dispositivo'];
		redireccion::redireccionar('noInserto');
		exit();
		if ($resultado) {
			redireccion::redireccionar('inserto', $_REQUEST['docenteRegistrar']);
			exit();
		} else {
			redireccion::redireccionar('noInserto');
			exit();
		}
		
	}

	function resetForm() {
		foreach ($_REQUEST as $clave => $valor) {

			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset($_REQUEST[$clave]);
			}
		}
	}

}

$miRegistrador = new Registrar($this -> lenguaje, $this -> sql, $this -> funcion);

$resultado = $miRegistrador -> procesarFormulario();
?>
