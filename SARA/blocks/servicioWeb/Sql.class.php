<?php

namespace servicioWeb;

if (!isset($GLOBALS["autorizado"])) {
	include ("../index.php");
	exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function __construct() {
		$this -> miConfigurador = \Configurador::singleton();
	}

	function getCadenaSql($tipo, $variable = "") {

		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this -> miConfigurador -> getVariableConfiguracion("prefijo");
		$idSesion = $this -> miConfigurador -> getVariableConfiguracion("id_sesion");

		switch ($tipo) {

			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			case "iniciarTransaccion" :
				$cadenaSql = "START TRANSACTION";
				break;

			case "finalizarTransaccion" :
				$cadenaSql = "COMMIT";
				break;

			case "cancelarTransaccion" :
				$cadenaSql = "ROLLBACK";
				break;

			case "eliminarTemp" :
				$cadenaSql = "DELETE ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion = '" . $variable . "' ";
				break;

			case "insertarTemp" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "( ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";

				foreach ($_REQUEST as $clave => $valor) {
					$cadenaSql .= "( ";
					$cadenaSql .= "'" . $idSesion . "', ";
					$cadenaSql .= "'" . $variable['formulario'] . "', ";
					$cadenaSql .= "'" . $clave . "', ";
					$cadenaSql .= "'" . $valor . "', ";
					$cadenaSql .= "'" . $variable['fecha'] . "' ";
					$cadenaSql .= "),";
				}

				$cadenaSql = substr($cadenaSql, 0, (strlen($cadenaSql) - 1));
				break;

			case "rescatarTemp" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion='" . $idSesion . "'";
				break;

			/* Consultas del desarrollo */
			case "facultad" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_facultad,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.facultad";
				break;

			case "registrarDato" :
				$cadenaSql = " INSERT";
				$cadenaSql .= " INTO";
				$cadenaSql .= " modelo_emplazamiento.dato";
				$cadenaSql .= " (";
				$cadenaSql .= " id_dispositivo,";
				$cadenaSql .= " temperatura_suelo,";
				$cadenaSql .= " temperatura_ambiente,";
				$cadenaSql .= " humedad_suelo,";
				$cadenaSql .= " humedad_relativa,";
				//$cadenaSql .= " radiacion_uv,";
				$cadenaSql .= " nivel_uv,";
				$cadenaSql .= " intensidad_uv,";
				//$cadenaSql .= " dioxido_carbono,";
				//$cadenaSql .= " calidad_aire,";
				//$cadenaSql .= " humedad_suelo,";
				$cadenaSql .= " geometria";
				$cadenaSql .= " )";
				$cadenaSql .= " VALUES";
				$cadenaSql .= " (";
				$cadenaSql .= " '" . $variable['id'] . "',";
				$cadenaSql .= " '" . $variable['ts'] . "',";
				$cadenaSql .= " '" . $variable['ta'] . "',";
				$cadenaSql .= " '" . $variable['hs'] . "',";
				$cadenaSql .= " '" . $variable['hr'] . "',";
				$cadenaSql .= " '" . $variable['nuv'] . "',";
				$cadenaSql .= " '" . $variable['iuv'] . "',";
				$cadenaSql .= " public.ST_GeomFromText('POINT(" . $variable['lon'] . ' ' . $variable['lat'] . ")', 4326)";
				$cadenaSql .= " );";
				break;

			case 'consultarDatos' :
				$cadenaSql = " SELECT";
				$cadenaSql .= " temperatura_suelo AS temperatura_suelo,";
				$cadenaSql .= " temperatura_ambiente AS temperatura_ambiente,";
				$cadenaSql .= " humedad_suelo AS humedad_suelo,";
				$cadenaSql .= " humedad_relativa AS humedad_relativa,";
				$cadenaSql .= " nivel_uv AS nivel_uv,";
				$cadenaSql .= " intensidad_uv AS intensidad_uv,";
				$cadenaSql .= " tiempo AS tiempo,";
				$cadenaSql .= " public.ST_X(geometria) AS longitud,";
				$cadenaSql .= " public.ST_Y(geometria) AS latitud";
				$cadenaSql .= " FROM";
				$cadenaSql .= " modelo_emplazamiento.dato";
				$cadenaSql .= " WHERE id_dispositivo='" . $variable['id'] . "'";
				$cadenaSql .= " ORDER BY tiempo";
				$cadenaSql .= " DESC LIMIT " . $variable['limit'] . ";";
				break;
			case 'consultarPosicion' :
				$cadenaSql = " SELECT";
				$cadenaSql .= " public.ST_X(geometria) AS longitud,";
				$cadenaSql .= " public.ST_Y(geometria) AS latitud";
				$cadenaSql .= " FROM";
				$cadenaSql .= " modelo_emplazamiento.dato";
				$cadenaSql .= " ORDER BY tiempo";
				$cadenaSql .= " ;";
				break;
		}

		return $cadenaSql;
	}

}
?>
