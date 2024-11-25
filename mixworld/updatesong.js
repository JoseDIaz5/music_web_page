$(document).ready(function(){
	
	document.getElementById("songimage").addEventListener("click",seleccionaimagen,false);
	
	document.getElementById("imageselect").addEventListener("change",procesa,false);
	
	document.getElementById("botonactualiza").addEventListener("click",actualizacancion,false);
	
	$("#titulo").focus(function(){
		
		$("#titleicon").css("color","#DC143C");
		
		$("#titleicon").css("transition","0.4s");
	});
	$("#titulo").focusout(function(){
		
		$("#titleicon").css("color","#000000");
		
		$("#titleicon").css("transition","0.4s");
	});
	function seleccionaimagen(){
		
		$("#imageselect").click();
	}
	function procesa(e){
		
		var archivo=e.target.files;
		
		var mi_archivo=archivo[0];
		
		var lector=new FileReader();
		
		lector.readAsDataURL(mi_archivo);
		
		lector.addEventListener("load",mostrar,false);
	}
	function mostrar(e){
		
		var resultado=e.target.result;
		
		document.getElementById("imagencanciontres").innerHTML="<img width='100%' height='100%' src='" + resultado + "'>";
	}
	
	function actualizacancion(){
		
		$("#botonactualizados").click();
	}
});