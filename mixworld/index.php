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

		<?php 
		
		try{
		    
		    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		    
		    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $conexion->exec("SET CHARACTER SET utf8");
		    
		    $consulta="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones AS c ON p.ID = c.ID_USUARIO";
		    
		    $resultado=$conexion->prepare($consulta);
		    
		    $resultado->execute();
		    
		    $identificador=0;
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		        
		        $identificador++;
		        ?>
		        
		        <div class="songcontainer">
			
    				<div class="imagecontainer">
    				
    					<img src="/MIXWORLD/intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
    				
    				</div>
    				<div class="titleplayercontainer">
    				
    					<div class="titlecontainer">
    					
    						<span><?php echo $fila["TITULO"]; ?></span>
    					
    					</div>
    					<div class="usercontainer">
    					
    						<img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
    					
    						<span><?php echo $fila["USUARIO"]; ?></span>
    					
    					</div>
    					<div class="playercontainer">
    					
    						<div class="playicon">
    						
    							<i class="fa-solid fa-play play inicio<?php echo $identificador; ?>" id="<?php echo $identificador; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
    							
    							<i class="fa-solid fa-pause pause detener<?php echo $identificador; ?>" id="<?php echo $identificador; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
    						
    						</div>
    						
    						<div id="bar">
    						
    							<div id="<?php echo $identificador; ?>" class="progress progreso<?php echo $identificador; ?>"></div>
    						
    						</div>
    					
    					</div>
    				
    				</div>
    			
    			</div>
		        
		        <?php 
		    }
		    
		    
		}catch(Exception $e){
		    
		    die("Error: " . $e->getMessage());
		}
		
		?>
		
		</section>
	
	</body>

</html>
