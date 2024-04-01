$(document).ready(function(){
	
	document.getElementById("pictureicon").addEventListener("click",selecciona,false);
	
	document.getElementById("imageselect").addEventListener("change",procesa,false);
	
	document.getElementById("pictureicons").addEventListener("click",seleccionados,false);
	
	document.getElementById("imageselects").addEventListener("change",procesados,false);
	
	document.getElementById("botonregistra").addEventListener("click",creacuenta,false);
	
	$("#usuario").focus(function(){
		
		$("#usericon").css("color","#DC143C");
		
		$("#usericon").css("transition","0.4s");
	});
	$("#usuario").focusout(function(){
		
		$("#usericon").css("color","#000000");
		
		$("#usericon").css("transition","0.4s");
	});
	$("#correo").focus(function(){

        $("#mailicon").css("color","#DC143C");

        $("#mailicon").css("transition","0.4s");
    });
    $("#correo").focusout(function(){

        $("#mailicon").css("color","#000000");

        $("#mailicon").css("transition","0.4s");
    });
    $("#contrasena").focus(function(){

        $("#passicon").css("color","#DC143C");

        $("#passicon").css("transition","0.4s");
    });
    $("#contrasena").focusout(function(){

        $("#passicon").css("color","#000000");

        $("#passicon").css("transition","0.4s");
    });
    $("#confirmar").focus(function(){

        $("#passicon2").css("color","#DC143C");

        $("#passicon2").css("transition","0.4s");
    });
    $("#confirmar").focusout(function(){

        $("#passicon2").css("color","#000000");

        $("#passicon2").css("transition","0.4s");
    });
    function selecciona(){
	
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
		
		document.getElementById("imagenperfiltres").innerHTML="<img id='perf' width='100%' height='100%' src='" + resultado + "'>";
	}
	function seleccionados(){
		
		$("#imageselects").click();
	}
	function procesados(e){
		
		var archivos=e.target.files;
		
		var mi_archivo=archivos[0];
		
		var lector=new FileReader();
		
		lector.readAsDataURL(mi_archivo);
		
		lector.addEventListener("load",mostrardos,false);
	}
	function mostrardos(e){
		
		var resultado=e.target.result;
		
		document.getElementById("contportadatres").innerHTML="<img id='port' width='100%' height='100%' src='" + resultado + "'>";
	}
	function creacuenta(){
		
		$("#botonregistrados").click();
	}
});