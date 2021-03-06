<?php
//Se establece el espacio de nombre
namespace gui\accesoIncorrecto\formulario;
// Se verifica si el usuario está autorizado
if (!isset($GLOBALS['autorizado'])) {
	include ('../index.php');
	exit();
}

class Form {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $site;

	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton();

		$this->miInspectorHTML = \InspectorHTML::singleton();

		$this->miConfigurador -> fabricaConexiones -> setRecursoDB('principal');

		$this->lenguaje = $lenguaje;

		$this->miFormulario = $formulario;

		$this->site = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
	}

	function miForm() {
		// Rescatar los datos de este bloque
		include $this->site.'formulario/paginaInicio.html.php';
	}

	function mensaje() {

		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador -> getVariableConfiguracion('mostrarMensaje');
		$this->miConfigurador -> setVariableConfiguracion('mostrarMensaje', null);

		if ($mensaje) {
			$tipoMensaje = $this->miConfigurador -> getVariableConfiguracion('tipoMensaje');
			if ($tipoMensaje == 'json') {

				$atributos['mensaje'] = $mensaje;
				$atributos['json'] = true;
			} else {
				$atributos['mensaje'] = $this->lenguaje -> getCadena($mensaje);
			}
			// ------------------Division para los botones-------------------------
			$atributos['id'] = 'divMensaje';
			$atributos['estilo'] = 'marcoBotones';
			echo $this->miFormulario -> division("inicio", $atributos);

			// -------------Control texto-----------------------
			$esteCampo = 'mostrarMensaje';
			$atributos["tamanno"] = '';
			$atributos["estilo"] = 'information';
			$atributos["etiqueta"] = '';
			$atributos["columnas"] = '';
			// El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario -> campoMensaje($atributos);
			unset($atributos);

			// ------------------Fin Division para los botones-------------------------
			echo $this->miFormulario -> division("fin");
		}
	}

}

$miSeleccionador = new Form($this->lenguaje, $this->miFormulario);

$miSeleccionador -> mensaje();

$miSeleccionador -> miForm();
?>
