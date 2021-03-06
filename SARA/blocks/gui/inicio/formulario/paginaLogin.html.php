<?php
$atributosGlobales ['campoSeguro'] = 'tiempo';
$_REQUEST['tiempo']=time();

$rutaUrlBloque = $this -> miConfigurador -> getVariableConfiguracion("rutaUrlBloque");
//var_dump($_REQUEST);
?>

<div id="sliderFrame">
	<div style="opacity: 1;" class="fade-in-forward" id="stage">
		<div class="sign-in">
			<div id="main-content" class="card">

				<div style="opacity: 1;" class="fade-in-forward" id="udistrital-logo"></div>

				<header>
					<h1 id="fxa-signin-header"> Sistema de Monitoreo, Control y Comercialización de Bienes Agrícolas. <span class="service">Ingrese sus datos</span></h1>
				</header>

				<section>
					<?php if(isset($_REQUEST['error'])):?>
					<div class="error">
						Usuario o contraseña erronea.
					</div>
					<?php endif; ?>
					<?php if(isset($_REQUEST['mostrarMensaje']) && $_REQUEST['mostrarMensaje'] == 'sesionExpirada'):?>
					<div class="error">
						¡¡¡Sesión Expirada!!!
					</div>
					<?php endif; ?>
					<?php if(isset($_REQUEST['mensaje'])):?>
					<div class="success">
						<?php echo $_REQUEST['mensaje']; ?>
					</div>
					<?php endif; ?>
					
					<?php
					// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
					// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
					$esteCampo = $esteBloque['nombre'];
					$atributos['id'] = $esteCampo;
					$atributos['nombre'] = $esteCampo;
					// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
					$atributos['tipoFormulario'] = '';
					// Si no se coloca, entonces toma el valor predeterminado 'POST'
					$atributos['metodo'] = 'POST';
					// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
					$atributos['action'] = 'index.php';
					$atributos['titulo'] = $this -> lenguaje -> getCadena($esteCampo);
					// Si no se coloca, entonces toma el valor predeterminado.
					$atributos['estilo'] = '';
					$atributos['marco'] = true;
					$tab = 1;
					// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
					// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
					$atributos['tipoEtiqueta'] = 'inicio';
					echo $this -> miFormulario -> formulario($atributos);
					?>

					<div class="input-row">
						<?php
						$esteCampo = 'usuario';
						$atributos['id'] = $esteCampo;
						$atributos['nombre'] = $esteCampo;
						$atributos['tipo'] = 'text';
						$atributos['estilo'] = 'login jqueryui';
						$atributos['marco'] = false;
						$atributos['columnas'] = 1;
						$atributos['dobleLinea'] = false;
						$atributos['tabIndex'] = $tab;
						$atributos['textoFondo'] = $this -> lenguaje -> getCadena($esteCampo);
						$atributos['validar'] = 'required';
						if (isset($_REQUEST[$esteCampo])) {
							$atributos['valor'] = $_REQUEST[$esteCampo];
						} else {
							$atributos['valor'] = '';
						}
						$atributos['titulo'] = $this -> lenguaje -> getCadena($esteCampo . 'Titulo');
						$atributos['deshabilitado'] = false;
						$atributos['tamanno'] = 20;
						$atributos['maximoTamanno'] = '50';
						$tab++;
						// Aplica atributos globales al control
						$atributos = array_merge($atributos, $atributosGlobales);
						echo $this -> miFormulario -> campoCuadroTexto($atributos);
						unset($atributos);
						?>
					</div>

					<div class="input-row password-row">
						<?php
						$esteCampo = 'clave';
						$atributos['id'] = $esteCampo;
						$atributos['nombre'] = $esteCampo;
						$atributos['tipo'] = 'password';
						$atributos['estilo'] = 'login jqueryui';
						$atributos['marco'] = false;
						$atributos['columnas'] = 1;
						$atributos['dobleLinea'] = false;
						$atributos['tabIndex'] = $tab;
						$atributos['textoFondo'] = $this -> lenguaje -> getCadena($esteCampo);
						$atributos['validar'] = 'required';
						if (isset($_REQUEST[$esteCampo])) {
							$atributos['valor'] = $_REQUEST[$esteCampo];
						} else {
							$atributos['valor'] = '';
						}
						$atributos['titulo'] = $this -> lenguaje -> getCadena($esteCampo . 'Titulo');
						$atributos['deshabilitado'] = false;
						$atributos['tamanno'] = 20;
						$atributos['maximoTamanno'] = '50';
						$tab++;
						// Aplica atributos globales al control
						$atributos = array_merge($atributos, $atributosGlobales);
						echo $this -> miFormulario -> campoCuadroTexto($atributos);
						unset($atributos);
						?>
					</div>

					<div class="button-row">
						<button id="submit-btn" type="submit">
							Ingresar
						</button>
					</div>
					<?php
					// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
					// Paso 1: crear el listado de variables
					$valorCodificado = "action=" . $esteBloque["nombre"];
					$valorCodificado .= "&pagina=" . $this -> miConfigurador -> getVariableConfiguracion('pagina');
					$valorCodificado .= "&bloque=" . $esteBloque['nombre'];
					$valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
					$valorCodificado .= "&opcion=login";
					/**
					 * SARA permite que los nombres de los campos sean dinámicos.
					 * Para ello utiliza la hora en que es creado el formulario para
					 * codificar el nombre de cada campo.
					 */
					$valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
					// Paso 2: codificar la cadena resultante
					$valorCodificado = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar($valorCodificado);
					$atributos["id"] = "formSaraData";
					// No cambiar este nombre
					$atributos["tipo"] = "hidden";
					$atributos['estilo'] = '';
					$atributos["obligatorio"] = false;
					$atributos['marco'] = true;
					$atributos["etiqueta"] = "";
					$atributos["valor"] = $valorCodificado;
					echo $this -> miFormulario -> campoCuadroTexto($atributos);
					unset($atributos);
					// ----------------FIN SECCION: Paso de variables -------------------------------------------------
					// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
					// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
					// Se debe declarar el mismo atributo de marco con que se inició el formulario.
					$atributos['marco'] = true;
					$atributos['tipoEtiqueta'] = 'fin';
					echo $this -> miFormulario -> formulario($atributos);

					$directorio = $this -> miConfigurador -> getVariableConfiguracion("host");
					$directorio .= $this -> miConfigurador -> getVariableConfiguracion("site") . "/index.php?";
					$directorio .= $this -> miConfigurador -> getVariableConfiguracion("enlace");

					$enlace = 'pagina=registroUsuario';
					$enlace = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar_url($enlace, $directorio);
					?>

					<div class="links">
						<a href="/reset_password" class="left reset-password">¿Olvidaste la contraseña?</a>

						<a href="<?php echo $enlace; ?>" class="right sign-up">Crear una cuenta</a>
					</div>

					<div class="privacy-links">
						Al continuar, estás de acuerdo con los <a id="fxa-tos" href="otro_pdf.pdf" target="_blank">Términos del servicio</a> del Sistema.
					</div>
				</section>
			</div>
		</div>
	</div>

	<!-- <div style="width: 100%;">
		<ul class="social-icons">
			<li class="icon icon--facebook">
				<a href="http://facebook.com/anandseeds"> <span class="icon__name">Facebook</span> </a>
			</li>
			<li class="icon icon--twitter">
				<a href="https://twitter.com/AnandSeeds"> <span class="icon__name">Twitter</span> </a>
			</li>
			<li>
				<a href="https://www.youtube.com/channel/UC961fU1OYyv4lASjLpixzfA" target="_blank"> <i class="fa fa-youtube"></i> </a>
			</li>
		</ul>
	</div> -->
	<!--[if !(IE) | (gte IE 10)]><!-->
	<noscript>
		SGA necesita Javascript.
	</noscript>
	<!-- <div class="responsive-slider">
	<ul class="bxslider">
	<li><img src="<?php echo $rutaUrlBloque.'css/img/slid1.png'?>" alt="" />
	</li>
	<li><img src="<?php echo $rutaUrlBloque.'css/img/slid2.jpg'?>" alt="Pure Javascript. No jQuery. No flash." />
	</li>
	<li><img src="<?php echo $rutaUrlBloque.'css/img/slid3.jpg'?>" alt="#htmlcaption" />
	</li>
	<li><img src="<?php echo $rutaUrlBloque.'css/img/slid4.jpg'?>" alt="" />
	</li>
	</ul>
	</div> -->
