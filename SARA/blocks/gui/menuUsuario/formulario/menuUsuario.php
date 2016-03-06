<?php
//Se establece el espacio de nombre
namespace gui\menuUsuario\formulario;
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
		$this -> miConfigurador = \Configurador::singleton();

		$this -> miInspectorHTML = \InspectorHTML::singleton();

		$this -> miConfigurador -> fabricaConexiones -> setRecursoDB('principal');

		$this -> lenguaje = $lenguaje;

		$this -> miFormulario = $formulario;

		$this -> site = $this -> miConfigurador -> getVariableConfiguracion("rutaBloque");
	}

	function miForm() {
		// Rescatar los datos de este bloque
		$esteBloque = $this -> miConfigurador -> getVariableConfiguracion("esteBloque");
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales['campoSeguro'] = 'tiempo';
		$_REQUEST['tiempo'] = time();
		// Rescatar los datos de este bloque
		$directorio = $this -> miConfigurador -> getVariableConfiguracion("host");
		$directorio .= $this -> miConfigurador -> getVariableConfiguracion("site") . "/index.php?";
		$directorio .= $this -> miConfigurador -> getVariableConfiguracion("enlace");
		
		$enlace = 'pagina=emplazamientosUsuario';
		$enlace = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar_url($enlace, $directorio);		
		
		$enlace1 = 'pagina=monitoreo';
		$enlace1 = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar_url($enlace1, $directorio);
		
		$enlace2 = 'pagina=planDeSiembra';
		$enlace2 = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar_url($enlace2, $directorio);
		
		$enlace3 = 'pagina=registroEmplazamiento';
		$enlace3 = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar_url($enlace3, $directorio);
		
		
		$claseEnlaceInicio = '';
		$claseEnlaceEmplazamiento = '';
		$claseEnlaceMonitoreo = '';
		$claseEnlacePlanSiembra = '';
		$claseEnlaceAcercaDe = '';

		switch ($_REQUEST['pagina']) {
			case 'registroEmplazamiento' :
				$claseEnlaceInicio = 'class="active"';
				break;
			case 'emplazamientosUsuario' :
				$claseEnlaceEmplazamiento = 'class="active"';
				break;
			case 'monitoria' :
				$claseEnlaceMonitoreo = 'class="active"';
				break;
			case 'planSiembra' :
				$claseEnlacePlanSiembra = 'class="active"';
				break;
			case 'acercaDe' :
				$claseEnlaceAcercaDe = 'class="active last"';
				break;
			case 2 :
				echo "i equals 2";
				break;
		}

		echo '
		<div id="cssmenu">
			<ul>
			   <li ' . $claseEnlaceEmplazamiento . '><a href="' . $enlace . '"><span>Mis emplazamientos</span></a></li>
			   <li ' . $claseEnlaceMonitoreo . '><a href="' . $enlace1 . '"><span>Monitoreo</span></a></li>
			   <li ' . $claseEnlacePlanSiembra . '><a href="' . $enlace2 . '"><span>Plan de Siembra</span></a></li>
			   <li ' . $claseEnlaceInicio . '><a href="' . $enlace3 . '"><span>Registrar Emplazamiento</span></a></li>
			   <li ' . $claseEnlaceAcercaDe . '><a target="_blank" href="http://anandseeds.co/"><span>Acerca de</span></a></li>
			</ul>
		</div>';
	}

	function mensaje() {

		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this -> miConfigurador -> getVariableConfiguracion('mostrarMensaje');
		$this -> miConfigurador -> setVariableConfiguracion('mostrarMensaje', null);

		if ($mensaje) {
			$tipoMensaje = $this -> miConfigurador -> getVariableConfiguracion('tipoMensaje');
			if ($tipoMensaje == 'json') {

				$atributos['mensaje'] = $mensaje;
				$atributos['json'] = true;
			} else {
				$atributos['mensaje'] = $this -> lenguaje -> getCadena($mensaje);
			}
			// ------------------Division para los botones-------------------------
			$atributos['id'] = 'divMensaje';
			$atributos['estilo'] = 'marcoBotones';
			echo $this -> miFormulario -> division("inicio", $atributos);

			// -------------Control texto-----------------------
			$esteCampo = 'mostrarMensaje';
			$atributos["tamanno"] = '';
			$atributos["estilo"] = 'information';
			$atributos["etiqueta"] = '';
			$atributos["columnas"] = '';
			// El control ocupa 47% del tamaño del formulario
			echo $this -> miFormulario -> campoMensaje($atributos);
			unset($atributos);

			// ------------------Fin Division para los botones-------------------------
			echo $this -> miFormulario -> division("fin");
		}
	}

}

$miSeleccionador = new Form($this -> lenguaje, $this -> miFormulario);

$miSeleccionador -> mensaje();

$miSeleccionador -> miForm();
?>