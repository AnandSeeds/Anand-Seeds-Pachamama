
<?php
$nombrePagina = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
$nombreBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' )['nombre'];
?>

$("#<?php echo $nombreBloque.'Registrar';?>").validationEngine({
	promptPosition : "bottomRight:-150",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

