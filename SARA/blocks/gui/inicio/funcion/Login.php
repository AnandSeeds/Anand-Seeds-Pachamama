<?php
namespace gui\inicio;

use gui\inicio\funcion\Redireccionador;
// Se incluye la clase para log de usuarios
//include_once ("core/log/logger.class.php");

// var_dump($_REQUEST);exit;
class FormProcessor {

	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	var $miSesion;
	var $miLogger;

	function __construct($lenguaje, $sql) {
		$this -> miConfigurador = \Configurador::singleton();
		$this -> miConfigurador -> fabricaConexiones -> setRecursoDB('principal');
		$this -> lenguaje = $lenguaje;
		$this -> miSql = $sql;
		$this -> miSesion = \Sesion::singleton();
		//Objeto de la clase Loger
		//$this->miLogger = \logger::singleton();
	}

	function procesarFormulario() {

		/**
		 *
		 * @todo lógica de procesamiento
		 */
		$conexion = "estructura";
		$esteRecursoDB = $this -> miConfigurador -> fabricaConexiones -> getRecursoDB($conexion);
		$arregloLogin = array();

		if (!$esteRecursoDB) {
			// Este se considera un error fatal
			exit();
		}

		/**
		 *
		 * @todo En entornos de producción la clave debe codificarse utilizando un objeto de la clase Codificador
		 */		 
		$_REQUEST['tiempo'] = time();
		$variable['usuario'] = $_REQUEST["usuario"];
		$variable['clave'] = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificarClave($_REQUEST["clave"]);
		// Verificar que el tiempo registrado en los controles no sea superior al tiempo actual + el tiempo de expiración
		if ($_REQUEST['tiempo'] <= time() + $this -> miConfigurador -> getVariableConfiguracion('expiracion')) {
			// Verificar que el usuario esté registrado en el sistema
			$cadena_sql = $this -> miSql -> getCadenaSql("buscarUsuario", $variable);
			$registro = $esteRecursoDB -> ejecutarAcceso($cadena_sql, "busqueda");

			if ($registro) {
				if ($registro[0]['clave'] == $variable['clave']) {
					// 1. Crear una sesión de trabajo
					
					$estaSesion = $this -> miSesion -> crearSesion($registro[0]["id_usuario"]);

					if ($estaSesion) {
						//var_dump($log);
						//$_COOKIE['aplicativo'] = $estaSesion;
						//$this->miLogger->log_usuario($log);
						//Si estado dif Activo redirecciona a pagina decambio contraseña
						// if ($registro[0]['estado'] == 2) {
							// var_dump($registro);die;					
						// } else {
			            $directorio = $this->miConfigurador->getVariableConfiguracion("host");
			            $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
			            $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
			            $valorCodificado = "pagina=emplazamientosUsuario";
			            //$valorCodificado .= "&autenticado=true";
			            $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);
			            $enlace          = $directorio . '=' . $valorCodificado;
			            header('Location: ' . $enlace);
						//}
					}
					// Redirigir a la página principal del usuario, en el arreglo $registro se encuentran los datos de la sesion:
					// $this->funcion->redireccionar("indexUsuario", $registro[0]);
					return true;
				} else {
					$variable = 'error=claveIncorrecta';
					$this->redireccion_urano($variable);
					//                    echo "no valido";
					//                    exit;
					// Registrar el error por clave no válida
				}
			} else {
				// Registrar el error por usuario no valido
				$variable = 'error=usuarioNoExiste';
				$this->redireccion_urano($variable);
			}
		} else {
			// Registrar evento por tiempo de expiración en controles
		}

	}

	function redireccion_urano($variable){
		$urlUrano = $this->miConfigurador->getVariableConfiguracion ( 'host' );
		$urlUrano .= $this->miConfigurador->getVariableConfiguracion ( 'site' ) . '/index.php?';
		$urlUrano .= $this->miConfigurador->getVariableConfiguracion ( 'enlace' );
		
		$enlace = 'pagina=index&';
		$enlace .= $variable;
		$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $urlUrano );
		echo "<script type='text/javascript'> window.location='$enlace';</script>";
        exit();
	}

}

$miProcesador = new FormProcessor($this -> lenguaje, $this -> sql);

$resultado = $miProcesador -> procesarFormulario();
