$(document).ready(function(){
	
	document.getElementById("comp").addEventListener("click",comparte,false);
	
	document.getElementById("contcanciones").addEventListener("click",contenido,false);
	
	document.getElementById("uploadsongbutton").addEventListener("click",sharesong,false);
	
	document.getElementById("uploadimagesongbutton").addEventListener("click",shareimagesong,false);
	
	document.getElementById("songselect").addEventListener("change",changesongname,false);
	
	document.getElementById("imageselect").addEventListener("change",changeimagesongname,false);
	
	document.getElementById("botonregistra").addEventListener("click",subecancion,false);
	
	function comparte(){
		
		$("#uploadsongs").slideToggle(500);
		
		$("#songs").css("display","none");
	}
	function contenido(){
		
		$("#songs").slideToggle(500);
		
		$("#uploadsongs").css("display","none");
	}
	function sharesong(){
		
		$("#songselect").click();
	}
	function shareimagesong(){
		
		$("#imageselect").click();
	}
	function changesongname(e){
		
		var archivos=e.target.files;
		
		var archivo=archivos[0];
		
		var extension=archivo.type;
		
		if(extension!='audio/mpeg' && extension!='audio/flac' && extension!='audio/wav' && extension!='audio/x-m4a'){
			
			document.getElementById("filenameone").innerHTML="Seleccione un archivo de audio (mp3, flac, wav, m4a)";
			
			$("#filenameone").css("color","black");
			
			$("#filenameone").css("font-weight","bolder");
		}else{
			
			document.getElementById("filenameone").innerHTML=archivo.name;
			
			$("#filenameone").css("color","#d40000");
		
			$("#filenameone").css("font-weight","bolder");
		}
	}
	function changeimagesongname(e){
		
		var archivos=e.target.files;
		
		var archivo=archivos[0];
		
		var extension=archivo.type;
		
		if(extension!="image/jpeg" && extension!="image/png" && extension!="image/jpg"){
			
			document.getElementById("filenametwo").innerHTML="Seleccione un archivo de tipo imagen (png, jpg)";
			
			$("#filenametwo").css("color","black");
			
			$("#filenametwo").css("font-weight","bolder");
		}else{
			
			document.getElementById("filenametwo").innerHTML=archivo.name;
			
			$("#filenametwo").css("color","#d40000");
		
			$("#filenametwo").css("font-weight","bolder");
		}
	}
	function subecancion(){
		
		$("#botonregistrados").click();
	}
	$("#campotitulo").focus(function(){
		
		$("#titleicon").css("color","#DC143C");
		
		$("#titleicon").css("transition","0.4s");
	});
	$("#campotitulo").focusout(function(){
		
		$("#titleicon").css("color","#000000");
		
		$("#titleicon").css("transition","0.4s");
	});
	$("#desc").focus(function(){
		
		$(this).animate({"height":"100px"},"slow");
	});
	$("#desc").blur(function(){
		
		$(this).animate({"height":"20px"},"slow");
	});

});
