<?php

namespace gui\inicio\funcion;

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
}

class Redireccionador {

    public static function redireccionar($opcion, $valor = "") {
        $miConfigurador = \Configurador::singleton();

        $miPaginaActual = $miConfigurador->getVariableConfiguracion("pagina");

        switch ($opcion) {
            case "index" :
                //echo "Bienvenido, perfil Arka, todo poderoso.";
                $variable = 'pagina=indextike';
                $variable .= '&registro=' . $valor [0];
                break;

            case "claves" :
                // echo "Bienvenido, perfil Compras";
                $variable = 'pagina=cambiarClave';
                $variable .= '&usuario=' . $valor [0]['id_usuario'];
                break;

            case "indexContabilidad" :
                //echo "Bienvenido, perfil Contabilidad";
                $variable = 'pagina=indexContabilidad';
                $variable .= '&registro=' . $valor [0];
                break;

            case "indexAlmacen" :
                //echo "Bienvenido, perfil Asistente Almacén";
                $variable = 'pagina=indexAlmacen';
                $variable .= '&registro=' . $valor [0];
                break;


            /** Otros casos */
            case "paginaPrincipal" :
                $variable = "pagina=" . $miPaginaActual;
                if (isset($valor) && $valor != '') {
                    $variable .= "&error=" . $valor;
                }
                break;
				
			case "paginaUsuario" :
                $variable = "pagina=emplazamientosUsuario";
                break;

            default :
                $variable = 'pagina=' . $miPaginaActual;
                break;
        }
        foreach ($_REQUEST as $clave => $valor) {
            unset($_REQUEST [$clave]);
        }

        $url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
        $enlace = $miConfigurador->configuracion ['enlace'];
        $variable = $miConfigurador->fabricaConexiones->crypto->codificar($variable);
        $_REQUEST [$enlace] = $enlace . '=' . $variable;
        $redireccion = $url . $_REQUEST [$enlace];

        echo "<script>location.replace('" . $redireccion . "')</script>";
    }

}

?>