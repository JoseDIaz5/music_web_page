$(document).ready(function(){
	
	var micancion, reproducir, barra, progreso, total, maximo, audio, currentFile;
	
	audio=null;
	
	currentFile=null;
	
	micancion=document.getElementById("micancion");
		
	reproducir=document.getElementById("play");
	
	barra=document.getElementById("bar");
	
	progreso=document.getElementById("progress");
	
	//document.getElementById("pause").addEventListener("click",pause,false);
	
	//reproducir.addEventListener("click",play,false);
	
	barra.addEventListener("click",adelantar,false);
	
	maximo=barra.clientWidth;
	
	$(".play").click(function(){
		
		var song=$(this);
		
		var ruta=song.attr("data-file");
		
		if(audio && currentFile==ruta){
			
			audio.currentTime=0;
			
			audio.play();
		}
		else{
			
			if(audio){
				
				audio.pause();
			}
			audio=new Audio(ruta);
			
			currentFile=ruta;
				
			audio.play();
			
			//$("#play").css("display","none");
		
			//$("#pause").css("display","block");
		}
			
		
		
		bucle=setInterval(estado,50);
		
	});
	/*$(".pause").click(function(){
		
		var song=$(this);
		
		var ruta=song.attr("data-file");
		
		audio=new Audio(ruta);
			
		currentFile=ruta;
			
		audio.pause();
		
		$("#play").css("display","block");
		
		$("#pause").css("display","none");
	});
	
	function pause(){
		
		if((micancion.paused==false) && (micancion.ended==false)){
			
			micancion.pause();
			
			$("#play").css("display","block");
			
			$("#pause").css("display","none");
		}
	}*/
	function estado(){
		
		if(micancion.ended==false){
			
			total=parseInt(micancion.currentTime*maximo/micancion.duration);
			
			progreso.style.width=total+"px";
		}
	}
	function adelantar(posicion){
		
		if((micancion.paused==false) && (micancion.ended==false)){
			
			var ratonx=posicion.pageX-barra.offsetLeft;
			
			var nuevotiempo=ratonx*micancion.duration/maximo;
			
			micancion.currentTime=nuevotiempo;
			
			progreso.style.width=ratonx+"px";
		}
	}
});
