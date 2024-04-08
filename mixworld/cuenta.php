<!DOCTYPE html>
<html>

	<head>
	
		<?php 
        
            session_start();
        
        ?>
        <?php
    	
    	
    	   
    	   if (isset($_SESSION["nombre"])) {
    	       
    	       $j=false;
    	       
    	   }
    	   elseif (isset($_SESSION["usuario"])){
    	       
    	       $j=false;
    	   }
    	   else {
    	       
    	       header("location:index.php");
    	   }
    	
    	?>
	
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD | Cuenta</title>

        <link rel="stylesheet" href="cuenta.css?v=<?php echo time(); ?>">

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-1.8.3.js"></script>
        
        <script src="cuenta.js?v=<?php echo time(); ?>"></script>
	
	</head>
	<body>
	
		<div class="header_wrapper">
		
			<header style="background: url('/MIXWORLD/intranet/perfiles/<?php echo $_SESSION["portada"] ?>'); background-size: 100% 100%"></header>
			
			<div class="cols_container">
			
				<div class="left_col">
				
					<div class="img_container">
					
						<img src="/MIXWORLD/intranet/perfiles/<?php echo $_SESSION["picture"] ?>">
						
						<span></span>
					
					</div>
					
					<h2><?php echo $_SESSION["usuario"] ?></h2>
					
								
					<ul class="about">
					
						<li><span>100</span>Seguidores</li>
						
						<li><span>100</span>Siguiendo</li>
						
						<li><span>100</span>Canciones</li>
					
					</ul>
					
					<div class="content">
					
						<ul>
					
							<li><i class="fab fa-twitter"></i></li>
						
							<li><i class="fab fa-facebook"></i></li>
						
							<li><i class="fab fa-instagram"></i></li>
					
						</ul>
					
					</div>
					
				</div>
			
				<div class="right_col">
			
					<nav>
					
						<ul>
						
							<li id="contcanciones">Mis canciones</li>
						
							<li id="comp">Subir canciones</li>
							
							<li id="delete">Eliminar cuenta</li>
						
						</ul>
						
						<a href="cerrarsesion.php"><div>Cerrar sesión</div></a>
				
					</nav>
				
					<div id="songs">
				
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>

					</div>
					
					<div id="uploadsongs">
					
						<form action="subecancion.php" enctype="multipart/form-data" method="post">
						
							<div class="uploadsongstwo">
							
								<h2 id="tituloformsongs">Subir canción</h2>
								
								<div class="chosefile">
								
									<input type="file" id="songselect" hidden="hidden" name="song">
								
									<div class="uploadsongbutton">Seleccionar canción</div>
								
									<span class="filename">Ningún archivo seleccionado</span>
								
								</div>
								
								<br>
								
								<div class="chosefiletwo">
								
									<input type="file" id="imageselect" hidden="hidden" name="imagesong">
								
									<div class="uploadimagesongbutton"></div>
								
									<span class="filename">Ningún archivo seleccionado</span>
								
								</div>
								
								<br>
								
								<br>
								
								<div class="inputWithIcon">
							
									<input type="text" name="titulo" id="datos" class="campotitulo" placeholder="Titulo" required>
							
								</div>
								
								<br>
								
								<div class="contarea">
							
									<textarea rows="20" cols="55" name="area" id="desc" placeholder="Descripción de canción" maxlength="900" required></textarea>
							
								</div>
								
								<br>
								
								<br>
								
								<input type="submit" id="botonregistrados" value="Subir" name="subecancion" hidden="hidden">
								
								<div id="botonregistra">Subir</div>
							
							</div>
						
						</form>
					
					</div>
			
				</div>
			
			</div>
		
		</div>
	
	</body>

</html>
