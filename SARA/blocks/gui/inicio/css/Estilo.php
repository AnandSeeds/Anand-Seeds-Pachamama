<?php

echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width">';
$indice = 0;
//$estilo = array();
$estilo [$indice++] = "jquery.bxslider.css";
$estilo [$indice++] = "default.css";
$estilo [$indice++] = "style.css";
//$estilo = array();

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );

if ($unBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $unBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $unBloque ["grupo"] . "/" . $unBloque ["nombre"];
}

foreach ( $estilo as $nombre ) {
	echo "<link rel='stylesheet' type='text/css' href='" . $rutaBloque . "/css/" . $nombre . "'>\n";
}

?>
