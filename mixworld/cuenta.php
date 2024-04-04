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
						
						<a href="cerrarsesion.php"><div>Cerrar sesión</div></a>
				
					</nav>
				
					<div class="songs">
				
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">SONG</div>
					
						<div class="song">S</div>
				
					</div>
			
				</div>
			
			</div>
		
		</div>
	
	</body>


	

</html>