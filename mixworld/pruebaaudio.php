<!DOCTYPE html>
<html>

	<head>
	
		<script src="jquery-1.8.3.js"></script>
	
		<script>
	
    		var audio=null;
    		
    		var currentFile=null;
    		
    		$(document).ready(function(){
    		
    			$(".play-media").click(function(){
    			
    				var el=$(this);
    				
    				var filename=el.attr('data-file');
    				
    				if(audio && currentFile==filename){
    				
    					audio.currentTime=0;
    					
    					audio.play();
    				}
    				else{
    				
    					if(audio){
    					
    						audio.pause();
    					}
    					
    					audio=new Audio(filename);
    					
    					currentFile=filename;
    					
    					audio.play();
    				}
    				
    				//sreturn false;
    			});
    		
    		});
	
		</script>
	
	</head>
	
	<body>
	
		<a class="play-media" href="javascript:void(0);" data-file="/MIXWORLD/intranet/songs/Grupo Cañaveral - No te voy a perdonar - EXTENDED MIX.mp3">
		
			song 1
		
		</a>
		
		<a class="play-media" href="javascript:void(0);" data-file="/MIXWORLD/intranet/songs/Bruno Mars - Just The Way You Are - EXTENDED MIX.mp3">
		
			song 2
		
		</a>
	
		
	
	</body>
	
	

</html>