
<?php
$nombrePagina = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
$nombreBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' )['nombre'];

// $("#").submit(function() {
// 	$resultado=$("#novedadesBonificacion").validationEngine("validate");
// 	if ($resultado) {
// 		return true;
// 	}
// 	return false;
// });
?>

$("#<?php echo $nombreBloque.'Registrar';?>").validationEngine({
	promptPosition : "bottomRight:-150",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

// Asociar el widget de validación al formulario

/////////Se define el ancho de los campos de listas desplegables///////

$("#<?php echo $this->campoSeguro('id_tipo_emplazamiento');?>").width(575);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('id_tipo_emplazamiento');?>").select2();
