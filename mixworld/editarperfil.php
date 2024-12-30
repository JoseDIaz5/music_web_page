<!DOCTYPE html>
<html>

	<?php 
	
	session_start();
	
	if(!isset($_SESSION["idusu"])){
	    
	    header("location:index.php");
	}
	
	?>

	<head>
	
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        
        <title>MIXWORLD | Editar Perfil</title>
        
        <link rel="stylesheet" href="editarperfil.css?v=<?php echo time(); ?>">
        
        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-1.8.3.js"></script>
        
        <script src="editarperfil.js?v=<?php echo time(); ?>"></script>
	
	</head>
	<body>
	
		<section>
		
			<form action="edicionperfil.php" enctype="multipart/form-data" method='post'>
			
				<div id="formulariodos">
				
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
					
					<h2 id="tituloform">Edición de cuenta</h2>
					
					<input type="file" id="imageselect" hidden="hidden" name="imagenperfil">
					
					<input type="file" id="imageselects" hidden="hidden" name="contportada">
					
					<div id="imagenperfil">
					
						<div id="imagenperfildos">
						
							<label id="imagenperfiltres"></label>
							
							<label id="pictureicon"><i class="fas fa-camera"></i></label>
						
						</div>
						
						<span></span>
					
					</div>
					
					<div class="divimageerror">
					
						<span class="imageerror"></span>
					
					</div>
					
					<br>
					
					<div id="contportada">
					
						<div id="contportadados">
						
							<label id="contportadatres"></label>
							
							<label id="pictureicons"><i class="fas fa-camera"></i></label>
						
						</div>
						
						<span></span>
					
					</div>
					
					<div class="divimageerror">
					
						<span id="imageerrortwo"></span>
					
					</div>
					
					<br>
					
					<div class="wrapper">
					
						<div class="inputWithIcon" id="divusuario">
						
							<i class="fas fa-user icono" id="usericon"></i>
               			
               				<input type="text" name="usuario" id="usuario" class="datos" placeholder="Usuario" maxlength="50" required>
               				
               				<span class="focus-border"><i></i></span>
						
						</div>
						
						<br>
						
						<div class="inputWithIcon" id="divcorreo">
               			
               				<i class="fas fa-envelope icono" id="mailicon"></i>
               				
               				<input type="email" name="correo" id="correo" class="datos" placeholder="Correo" maxLength="50" required>
               				
               				<span class="focus-border"><i></i></span>
               			
               			</div>
               			
               			<br>
               			
               			<div class="inputWithIcon" id="divfacebook">
               			
               				<i class="fab fa-facebook icono" id="facebookicon"></i>
               				
               				<input type="text" name="facebook" id="facebook" class="datos" placeholder="Usuario Facebook (opcional)" maxlength="60">
               				
               				<span class="focus-border"><i></i></span>
               			
               			</div>
               			
               			<br>
               			
               			<div class="inputWithIcon" id="divinstagram">
               			
               				<i class="fab fa-instagram icono" id="instagramicon"></i>
               				
               				<input type="text" name="instagram" id="instagram" class="datos" placeholder="Usuario Instagram (opcional)" maxlength="60">
               				
               				<span class="focus-border"><i></i></span>
               			
               			</div>
               			
               			<br>
               			
               			<div class="inputWithIcon" id="divx">
               			
               				<i class="fa-brands fa-x-twitter icono" id="xicon"></i>
               			
               				<input type="text" name="twitter" id="twitter" class="datos" placeholder="Usuario X (opcional)" maxlength="60">
               				
               				<span class="focus-border"><i></i></span>
               			
               			</div>
               			
               			<br>
               			
               			<br>
               			
               			<input type="submit" id="botonregistrados" value="Crear" name="subedatos" hidden="hidden">
               			
               			<div id="botonregistra">Editar</div>
					
					</div>
				
				</div>
			
			</form>
		
		</section>
	
	</body>

</html>