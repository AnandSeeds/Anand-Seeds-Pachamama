<?php
namespace registros\registroEmplazamiento\funcion;

use registros\registroEmplazamiento\funcion\redireccionar;

include_once ('redireccionar.php');

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Registrar {
	
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	
	function __construct($lenguaje, $sql, $funcion) {
		
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function procesarFormulario() {
	foreach ( $_FILES as $key => $values ) { $archivo = $_FILES [$key]; }
	$imagedata = file_get_contents($archivo["tmp_name"]);
	$base64= base64_encode($imagedata);
	//reconstruir una imagen desde el codigo base 64
	//echo '<img  src="data:image/jpeg;base64,'.$base64.'" />';
	
	
		//var_dump($_REQUEST);   var_dump ($_FILES);  var_dump($archivo);die;
	

		$conexion = "modelo";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		$_REQUEST['id_usuario'] = '3';
		$_REQUEST['imagen'] = $base64;
		
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'registrarEmplazamiento', $_REQUEST );
		
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
		
		if ($resultado) {
			redireccion::redireccionar ( 'inserto',  $_REQUEST['docenteRegistrar']);
			exit ();
		} else {
			redireccion::redireccionar ( 'noInserto');
			exit ();
		}
	}
	
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miRegistrador = new Registrar ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
