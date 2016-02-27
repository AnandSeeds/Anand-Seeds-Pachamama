		<header>
			<div id="tabudistrital">
				<a href="#">Logo</a>
			</div>
		</header>
		<div style="opacity: 1;" class="fade-in-forward" id="stage">
			<div class="sign-in">
				<div id="main-content" class="card">
					
					<div style="opacity: 1;" class="fade-in-forward" id="udistrital-logo"></div>
					
					<header>
						<h1 id="fxa-signin-header">
							Sistema de gestión geográfica ambiental <span class="service">Ingrese sus datos</span></h1>
					</header>
					
					<section>

						<div class="error"></div>
						<div class="success"></div>

						<form novalidate="">
							<div class="input-row">
								<input class="email" placeholder="Código" spellcheck="false" autofocus="" type="email">
							</div>

							<div class="input-row password-row">
								<input class="password tooltip-below" id="password" placeholder="Contraseña" value="" pattern=".{8,}" required="" type="password">

								<input id="show-password" class="show-password" aria-controls="password" tabindex="-1" data-novalue="" type="checkbox">
							</div>

							<div class="button-row">
								<button id="submit-btn" type="submit">
									Ingresar
								</button>
							</div>
						</form>

						<div class="links">
							<a href="/reset_password" class="left reset-password">¿Olvidaste la contraseña?</a>

							<a href="/oauth/signup" class="right sign-up">Crear una cuenta</a>
						</div>

						<div class="privacy-links">
							Al continuar, estás de acuerdo con los <a id="fxa-tos" href="otro_pdf.pdf" target="_blank">Términos del servicio</a> del Sistema.
						</div>

					</section>
				</div>
			</div>
			<aside>
				<div>
					<div class="lateral-icon news" data-open-id="noticias"></div>
					<div class="lateral-icon help" data-open-id="ayuda"></div>
					<div class="lateral-icon others" data-open-id="otros"></div>
				</div>
			</aside>
			<section id="noticias" class="panel-lateral" style="display:none;">
				<div>
					lalala
				</div>
				<div>
					contenido
					contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>
					contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>
					contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>
					contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>contenido<br>
				</div>
			</section>
			<section id="ayuda" class="panel-lateral" style="display:none;">
				<div>
					Ayuda
				</div>
				<div>
					contenido
				</div>
			</section>
			<section id="otros" class="panel-lateral" style="display:none;">
				<div>
					Otros e información general
				</div>
				<div>
					contenido
				</div>
			</section>
		</div>
		<!--[if !(IE) | (gte IE 10)]><!-->
		<noscript>
			SGA necesita Javascript.
		</noscript>
