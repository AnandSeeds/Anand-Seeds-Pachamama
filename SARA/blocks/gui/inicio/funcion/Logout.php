<?php

class Logout {
	
	var $sesionUsuario;
		
	function __construct() {
		$this->sesionUsuario = \Sesion::singleton ();
	}
	function procesarFormulario() {		
		$sesionUsuarioId = $this->sesionUsuario->numeroSesion();
    	$this->sesionUsuario->terminarSesion($sesionUsuarioId);
	}
}

$miProcesador = new Logout ();
$miProcesador->procesarFormulario();
?>