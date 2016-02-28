<?php

namespace gui\emplazamientosUsuario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	function getCadenaSql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
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
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadenaSql .= "( ";
					$cadenaSql .= "'" . $idSesion . "', ";
					$cadenaSql .= "'" . $variable ['formulario'] . "', ";
					$cadenaSql .= "'" . $clave . "', ";
					$cadenaSql .= "'" . $valor . "', ";
					$cadenaSql .= "'" . $variable ['fecha'] . "' ";
					$cadenaSql .= "),";
				}
				
				$cadenaSql = substr ( $cadenaSql, 0, (strlen ( $cadenaSql ) - 1) );
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
				$cadenaSql=" INSERT";
				$cadenaSql.=" INTO";
				$cadenaSql.=" modelo.dato";
				$cadenaSql.=" (";
				$cadenaSql.=" id_dispositivo,";
				$cadenaSql.=" temperatura,";
				$cadenaSql.=" humedad_relativa,";
				$cadenaSql.=" nivel_ozono,";
				$cadenaSql.=" radiacion_uv,";
				$cadenaSql.=" dioxido_carbono,";
				$cadenaSql.=" calidad_aire,";
				$cadenaSql.=" humedad_suelo,";
				$cadenaSql.=" coordenada_geografica";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable ['id_dispositivo'] . "',";
				$cadenaSql.=" '" . $variable ['temp'] . "',";
				$cadenaSql.=" '" . $variable ['hum'] . "',";
				$cadenaSql.=" '" . $variable ['ozon'] . "',";
				$cadenaSql.=" '" . $variable ['uv'] . "',";
				$cadenaSql.=" '" . $variable ['co'] . "',";
				$cadenaSql.=" '" . $variable ['cov'] . "',";
				$cadenaSql.=" '" . $variable ['hs'] . "',";
				$cadenaSql.=" '" . $variable ['cg'] . "'";
				$cadenaSql.=" );";
				break;
				
			case "actualizarEvaluador" :
				$cadenaSql=" UPDATE";
				$cadenaSql.=" docencia.evaluador_produccion_tecnicaysoftware";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_evaluador = '" . $variable ['documento_evaluador'] . "',";
				$cadenaSql.=" nombre = '" . $variable ['nombre'] . "',";
				$cadenaSql.=" numero_certificado = '" . $variable ['numero_certificado'] . "',";
				$cadenaSql.=" documento_docente = '" . $variable ['documento_docente'] . "',";
				$cadenaSql.=" id_universidad = '" . $variable ['id_universidad'] . "',";
				$cadenaSql.=" puntaje = '" . $variable ['puntaje'] . "',";
				$cadenaSql.=" normatividad = '" . $variable ['normatividad'] . "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" documento_evaluador = '" . $variable ['old_documento_evaluador'] . "'";
				$cadenaSql.=" AND numero_certificado = '" . $variable ['old_numero_certificado'] . "'";
				$cadenaSql.=" AND documento_docente = '" . $variable ['old_documento_docente'] . "'";
				$cadenaSql.=" ;";
				break;
			
			case "consultarEmplazamientosUsuario" :
				$cadenaSql=" SELECT ubicacion[0],ubicacion[1]";
				$cadenaSql=" FROM";
				$cadenaSql=" modelo.emplazamiento";
				$cadenaSql.=" ;";
				break;	
				
		}
		
		return $cadenaSql;
	}
}

?>
