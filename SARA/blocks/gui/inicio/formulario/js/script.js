/* Author: 

*/
$( document ).ready(init);

function init(){
	cargarEventosPanel();
}

function cargarEventosPanel(){
	$(".lateral-icon").click(function (e){
		cerrarEventosPanel();
		var id = $(this).attr("data-open-id");
		abrirEventoPanelPorId(id);
		var handler = function() {
			cerrarEventosPanel();
			$("body").unbind( "click", this );
		};
		$("body").bind( "click", handler );
		return false;
	});
}

function cerrarEventosPanel(){
	$(".panel-lateral").css("display","none");
}

function abrirEventoPanelPorId(id){
	$("#"+id).css("display","block");
}
















