<!DOCTYPE html>
<html>

	<head>
	
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD</title>

        <link rel="stylesheet" href="principal.css?v=<?php echo time(); ?>">

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>

        <script src="jquery-1.8.3.js"></script>

        <script src="principal.js?v=<?php echo time(); ?>"></script>
	
	</head>
	
	<body>
	
		<header class="background">
		
			<nav class="secondnav">
			
				<div class="nav-left">
				
					<div class="logo">
					
						<div class="loader">
						
							<span class="stroke"></span>
							<span class="stroke"></span>
							<span class="stroke"></span>
							<span class="stroke"></span>
							<span class="stroke"></span>
						
						</div>
						
						<a href="index.php" id="logodos">MIXWORLD</a>
					
					</div>
				
				</div>
				
				<div class="nav-center">
				
					<form action="<?php $_SERVER["PHP_SELF"] ?>">
					
						<div class="search-box">
						
							<input type="search" placeholder="Buscar..." class="buscador" name="buscador">
        				
        					<span class="fas fa-search searchicon" id="searchicon"></span>
        					
        					<input type="submit" id="botonbusca" hidden="hidden">
        			
        				</div>
					
					</form>
				
				</div>
				
				<div class="nav-right">
				
					<label for="check">
				
						<span class="imagediv">
					
							<i class="fa-solid fa-user"></i>
					
						</span>
					
					</label>
					
					<input type="checkbox" id="check" class="checkb">
					
					<div class="profileoptions">
					
						<ul class="list-profile">
					
							<li><a href="crearcuenta.php"><i class="fas fa-user"></i><span>Crear cuenta</span></a></li>
        				
        					<li><a href="iniciosesion.php"><i class="fas fa-user"></i><span>Iniciar sesión</span></a></li>
					
						</ul>
					
					</div>	
				
				</div>
				
			</nav>
		
		</header>
		
		<section>
		
			
		
			<div class="songcontainer">
			
				<div class="imagecontainer">
				
					<img src="/MIXWORLD/intranet/songs/imagecañaveral1.jpg">
				
				</div>
				<div class="titleplayercontainer">
				
					<div class="titlecontainer">
					
						<span>TITULO CANCIÓN</span>
					
					</div>
					<div class="usercontainer">
					
						<img src="/MIXWORLD/intranet/perfiles/music.jpg">
					
						<span>USUARIO</span>
					
					</div>
					<div class="playercontainer">
					
						<div class="playicon">
						
							<i class="fa-solid fa-play play" id="play" data-file="/MIXWORLD/intranet/songs/Grupo Cañaveral - No te voy a perdonar - EXTENDED MIX.mp3"></i>
							
							<i class="fa-solid fa-pause pause" id="pause" data-file="/MIXWORLD/intranet/songs/Grupo Cañaveral - No te voy a perdonar - EXTENDED MIX.mp3"></i>
						
						</div>
						
						<div id="bar">
						
							<div id="progress"></div>
						
						</div>
					
					</div>
				
				</div>
			
			</div>
		
			
		
			<div class="songcontainer">
			
				<div class="imagecontainer">
				
					<img src="/MIXWORLD/intranet/songs/justthewayyouareimage.jpg">
				
				</div>
				<div class="titleplayercontainer">
				
					<div class="titlecontainer">
					
						<span>TITULO CANCIÓN</span>
					
					</div>
					<div class="usercontainer">
					
						<img src="/MIXWORLD/intranet/perfiles/music.jpg">
					
						<span>USUARIO</span>
					
					</div>
					<div class="playercontainer">
					
						<div class="playicon">
						
							<i class="fa-solid fa-play play" id="play" data-file="/MIXWORLD/intranet/songs/Bruno Mars - Just The Way You Are - EXTENDED MIX.mp3"></i>
							
							<i class="fa-solid fa-pause pause" id="pause" data-file="/MIXWORLD/intranet/songs/Bruno Mars - Just The Way You Are - EXTENDED MIX.mp3"></i>
						
						</div>
						
						<div id="bar">
						
							<div id="progress"></div>
						
						</div>
					
					</div>
				
				</div>
			
			</div>
		
		</section>
	
	</body>

</html>
