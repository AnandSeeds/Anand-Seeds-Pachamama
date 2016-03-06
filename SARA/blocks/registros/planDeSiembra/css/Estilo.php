<?php
$indice = 0;

echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';


//$estilo = array();
$estilo [$indice++] = "styler.css";
$estilo[$indice++]="timepicker.css";
$estilo[$indice++]="validationEngine.jquery.css";
$estilo[$indice++]="jquery.auto-complete.css";
$estilo[$indice++]="select2.css";
$estilo[$indice++]="miestilo.css";

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
