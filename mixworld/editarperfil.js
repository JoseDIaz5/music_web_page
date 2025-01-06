$(document).ready(function(){
	
	document.getElementById("pictureicon").addEventListener("click",seleccionaperfil,false);
	
	document.getElementById("imageselect").addEventListener("change",procesa,false);
	
	$("#usuario").focus(function(){
		
		$("#usericon").css("color","#DC143C");
		
		$("#usericon").css("transition","0.4s");
	});
	$("#usuario").focusout(function(){
		
		$("#usericon").css("color","#000000");
		
		$("#usericon").css("transition","0.4s");
	});
	$("#facebook").focus(function(){
		
		$("#facebookicon").css("color","#DC143C");
		
		$("#facebookicon").css("transition","0.4s");
	});
	$("#facebook").focusout(function(){
		
		$("#facebookicon").css("color","#000000");
		
		$("#facebookicon").css("transition","0.4s");
	});
	$("#instagram").focus(function(){
		
		$("#instagramicon").css("color","#DC143C");
		
		$("#instagramicon").css("transition","0.4s");
	});
	$("#instagram").focusout(function(){
		
		$("#instagramicon").css("color","#000000");
		
		$("#instagramicon").css("transition","0.4s");
	});
	$("#twitter").focus(function(){
		
		$("#xicon").css("color","#DC143C");
		
		$("#xicon").css("transition","0.4s");
	});
	$("#twitter").focusout(function(){
		
		$("#xicon").css("color","#000000");
		
		$("#xicon").css("transition","0.4s");
	});
	
	function seleccionaperfil(){
		
		$("#imageselect").click();
	}
	function procesa(e){
		
		var archivo=e.target.files;
		
		var mi_archivo=archivo[0];
		
		var lector=new FileReader();
		
		var extension=mi_archivo.type;
		
		if(extension!='image/jpeg' && extension!='image/jpg' && extension!='image/png' && extension!='image/gif'){
			
			document.getElementById("imageerror").innerHTML="Debe seleccionar una imagen (jpg, png, gif)";
		}else{
			
			lector.readAsDataURL(mi_archivo);
			
			lector.addEventListener("load",mostrar,false);
			
			document.getElementById("imageerror").innerHTML="";
		}
	}
	function mostrar(e){
		
		var resultado=e.target.result;
		
		document.getElementById("imagenperfiltres").innerHTML="<img width='100%' height='100%' src='" + resultado + "'>";
	}
});