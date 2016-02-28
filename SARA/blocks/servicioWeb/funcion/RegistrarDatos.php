<?php

namespace servicioWeb\funcion;

if (!isset($GLOBALS["autorizado"])) {
	include ("../index.php");
	exit();
}
class RegistrarDatos {

	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;

	function __construct($lenguaje, $sql, $funcion) {

		$this -> miConfigurador = \Configurador::singleton();
		$this -> miConfigurador -> fabricaConexiones -> setRecursoDB('principal');
		$this -> lenguaje = $lenguaje;
		$this -> miSql = $sql;
		$this -> miFuncion = $funcion;
	}

	function procesarFormulario() {

		$conexion = "modelo_emplazamiento";
		$esteRecursoDB = $this -> miConfigurador -> fabricaConexiones -> getRecursoDB($conexion);

		// $esteBloque = $this -> miConfigurador -> getVariableConfiguracion("esteBloque");
		// $rutaBloque = $this -> miConfigurador -> getVariableConfiguracion("raizDocumento") . "/blocks/asignacionPuntajes/salariales/";
		// $rutaBloque .= $esteBloque['nombre'];

		//$host = $this -> miConfigurador -> getVariableConfiguracion("host") . $this -> miConfigurador -> getVariableConfiguracion("site") . "/blocks/asignacionPuntajes/salariales/" . $esteBloque['nombre'];
		// $_REQUEST['id'] = '1';
		// $_REQUEST['ts'] = '1';
		// $_REQUEST['ta'] = '1';
		// $_REQUEST['hs'] = '1';
		// $_REQUEST['hr'] = '1';
		// $_REQUEST['nuv'] = '1';
		// $_REQUEST['iuv'] = '1';
		// $_REQUEST['lat'] = '10';
		// $_REQUEST['lon'] = '10';
		$cadenaSql = $this -> miSql -> getCadenaSql('registrarDato', $_REQUEST);
		$resultado = $esteRecursoDB -> ejecutarAcceso($cadenaSql, "insertar");
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

$miRegistrador = new RegistrarDatos($this -> lenguaje, $this -> sql, $this -> funcion);

$resultado = $miRegistrador -> procesarFormulario();
?>
