<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
	$(document).ready(init);

	function init() {
		window.setTimeout(cargarGrafica, 1000);
		window.setInterval(showData, 2000);
	}

	function showData() {
		$.ajax({
			type : "GET",
			url : "/index.php?data=0Ihzhj0geg_u16zk9AJNLlGl9F-9kE_bxeocU3n_RBOUFl-Ti5SyD_EjSpw1wd66mu_Wk7BHhYCRci6ci6FIKDC9TDkUZgGwDmjpNyZD8TEhe2kjK5lHTxLQiP6dk9Wy&id=1&limit=10"
		}).done(function(msg) {
			$("#demo2").html(msg);
			dato = JSON.parse(msg);
			var x = new Array();
			var humedad_relativa = new Array();
			var humedad_suelo = new Array();
			var intensidad_uv = new Array();
			var nivel_uv = new Array();
			var temperatura_ambiente = new Array();
			var temperatura_suelo = new Array();
			for(var i=0; i<dato.length; i++){
				x.push(i);
				humedad_relativa.push(dato[i].humedad_relativa);
				humedad_suelo.push(dato[i].humedad_suelo);
				intensidad_uv.push(dato[i].intensidad_uv);
				nivel_uv.push(dato[i].nivel_uv);
				temperatura_ambiente.push(dato[i].temperatura_ambiente);
				temperatura_suelo.push(dato[i].temperatura_suelo);
			}
			var trace1 = {
				x : x,
				y : humedad_relativa,
				type : 'scatter',
				name : 'Humedad Relativa'
			};

			var trace2 = {
				x : x,
				y : humedad_suelo,
				type : 'scatter',
				name : 'Humedad Suelo'
			};
			
			var trace3 = {
				x : x,
				y : intensidad_uv,
				type : 'scatter',
				name : 'Intensidad UV'
			};
			
			var trace4 = {
				x : x,
				y : nivel_uv,
				type : 'scatter',
				name : 'Nivel UV'
			};
			
			var trace5 = {
				x : x,
				y : temperatura_ambiente,
				type : 'scatter',
				name : 'Temperatura Ambiente'
			};
			
			var trace6 = {
				x : x,
				y : temperatura_suelo,
				type : 'scatter',
				name : 'Temperatura Suelo'
			};

			var data = [trace1, trace2];
			Plotly.newPlot('myDiv', data);
			
			var data = [trace3];
			Plotly.newPlot('myDiv2', data);
			
			var data = [trace4];
			Plotly.newPlot('myDiv3', data);
			
			var data = [trace5, trace6];
			Plotly.newPlot('myDiv4', data);
			
		});
	}

	function cargarGrafica() {
		$.ajax({
			type : "GET",
			url : "/index.php?data=0Ihzhj0geg_u16zk9AJNLlGl9F-9kE_bxeocU3n_RBOUFl-Ti5SyD_EjSpw1wd66mu_Wk7BHhYCRci6ci6FIKDC9TDkUZgGwDmjpNyZD8TEhe2kjK5lHTxLQiP6dk9Wy&id=1&limit=10"
		}).done(function(msg) {
			dato = JSON.parse(msg);
		});
	}

</script>

<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<h1>Humedad</h1>
<div id="myDiv" style="width: 480px; height: 400px;">
	<!-- Plotly chart will be drawn inside this DIV -->
</div>

<h1>Intensidad UV</h1>
<div id="myDiv2" style="width: 480px; height: 400px;">
	<!-- Plotly chart will be drawn inside this DIV -->
</div>

<h1>Nivel UV</h1>
<div id="myDiv3" style="width: 480px; height: 400px;">
	<!-- Plotly chart will be drawn inside this DIV -->
</div>

<h1>Temperatura</h1>
<div id="myDiv4" style="width: 480px; height: 400px;">
	<!-- Plotly chart will be drawn inside this DIV -->
</div>

<p id="demo2"></p>

<script>
	
</script>
