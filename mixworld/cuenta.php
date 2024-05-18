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
	
		<?php 
						
		  try {
		      
		      $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		      
		      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		      
		      $conexion->exec("SET CHARACTER SET utf8");
		      
		      $validaid=false;
		      
		      if (isset($_GET["iduser"])) {
		          
		          $iduser=$_GET["iduser"];
		          
		          if($iduser==$_SESSION["idusu"]){
		              
		              $validaid=true;
		          }
		      }
		      
		      $consultaperfil="SELECT USUARIO,IMAGEN_PERFIL,IMAGEN_PORTADA FROM perfiles WHERE ID=:id";
		      
		      $resultado=$conexion->prepare($consultaperfil);
		      
		      if (isset($iduser)) {
		          
		          $resultado->execute(array(":id"=>$iduser));
		          
		          while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		              
		              $portada=$fila["IMAGEN_PORTADA"];
		              
		              $perfil=$fila["IMAGEN_PERFIL"];
		              
		              $usuario=$fila["USUARIO"];
		          }
		      }
		      
		  } catch (Exception $e) {
		  
		      die("Error: " . $e->getMessage());
		  }
		
		?>
	
		<div class="header_wrapper">
		
			<?php 
			
			 if (isset($iduser)) {
			
			?>
		
			<header style="background: url('/MIXWORLD/intranet/perfiles/<?php echo $portada; ?>'); background-size: 100% 100%"></header>
			
			<?php 
			
			 }else{
			
			?>
			
			<header style="background: url('/MIXWORLD/intranet/perfiles/<?php echo $_SESSION["portada"]; ?>'); background-size: 100% 100%"></header>
			
			<?php 
			
			 }
			
			?>
>>>>>>> 90964fe (Actualización de contador de reproducciones)
			
			<div class="cols_container">
			
				<div class="left_col">
				
					<div class="img_container">
					
						<?php 
						
						  if (isset($iduser)) {   
						
						?>
					
						<img src="/MIXWORLD/intranet/perfiles/<?php echo $perfil; ?>">
						
						<span></span>
						
						<?php 
						
						  }else{
						
						?>
						
						<img src="/MIXWORLD/intranet/perfiles/<?php echo $_SESSION["picture"]; ?>">
						
						<span></span>
						
						<?php 
						
						  }
						
						?>
					
					</div>
					
					<?php 
					
					if (isset($iduser)) {
					
					?>
					
					<h2><?php echo $usuario; ?></h2>
					
					<?php 
					
					}else {
					
					?>
					
					<h2><?php echo $_SESSION["usuario"]; ?></h2>
					
					<?php 
					
                    }
					
					?>
								
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
							
							<?php 
							
							 if (!isset($iduser) && !$validaid) {
							
							?>
						
							<li id="comp">Subir canciones</li>
							
							<li id="delete">Eliminar cuenta</li>
							
							<?php 
							
							 }elseif (isset($iduser) && $validaid){
							
							?>
							
							<li id="comp">Subir canciones</li>
							
							<li id="delete">Eliminar cuenta</li>
							
							<?php 
							
							 }
							
							?>
						
						</ul>
						
						<?php 
						
						if (isset($iduser) && !$validaid) {
						
						?>
						
						<a><div>Seguir</div></a>
						
						<?php 
						
						}else {
						
						?>
						
						<a href="cerrarsesion.php"><div>Cerrar sesión</div></a>
						
						<?php 
						
						}
						
						?>
				
					</nav>
				
					<div id="songs">
				
						<div class="song">SONG</div>
				
					</div>
					
					<div id="uploadsongs">
					
						<form action="subecancion.php" enctype="multipart/form-data" method="post">
						
							<div class="uploadsongstwo">
							
								<h2 id="tituloformsongs">Subir canción</h2>
								
								<div class="chosefile">
								
									<input type="file" id="songselect" hidden="hidden" name="song">
								
									<div id="uploadsongbutton">Seleccionar canción</div>
									
									<br>
								
									<span id="filenameone">Ningún archivo seleccionado</span>
								
								</div>
								
								<br>
								
								<div class="chosefiletwo">
								
									<input type="file" id="imageselect" hidden="hidden" name="imagesong">
								
									<div id="uploadimagesongbutton">Seleccionar imagen</div>
									
									<br>	
								
									<span id="filenametwo">Ningún archivo seleccionado</span>
								
								</div>
								
								<br>
								
								<br>
								
								<div class="inputWithIcon" id="divsongtitle">
								
									<i class="fa-solid fa-pen-to-square icono" id="titleicon"></i>
							
									<input type="text" name="titulo" id="campotitulo" class="datos" placeholder="Titulo" maxLength="90" required>
									
									<span class="focus-border"><i></i></span>
							
								</div>
								
								<br>
								
								<div class="contarea">
							
									<textarea name="area" id="desc" placeholder="Descripción de canción" maxlength="900" required></textarea>
							
									<span class="focus-border"><i></i></span>
							
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
