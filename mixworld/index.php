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
        
        <script src="reproducciones.js?v=<?php echo time(); ?>"></script>
        
        <?php 
        
        function buscadatos($labusqueda){
            
            try {
                
                $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
                
                $conexion->exec("SET CHARACTER SET utf8");
                
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $consultabusqueda="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,c.REPRODUCCIONES,
                CASE
                WHEN c.REPRODUCCIONES < 1000 THEN c.REPRODUCCIONES
                WHEN c.REPRODUCCIONES > 999 AND c.REPRODUCCIONES < 10000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,1),'K')
                WHEN c.REPRODUCCIONES > 9999 AND c.REPRODUCCIONES < 100000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,2),'K')
                WHEN c.REPRODUCCIONES > 99999 AND c.REPRODUCCIONES < 1000000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,3),'K')
                WHEN c.REPRODUCCIONES > 999999 THEN CONCAT('+',SUBSTRING(c.REPRODUCCIONES,1,1),'M')
                END AS REPRODUCCIONES           
                ,c.LIKES,c.DISLIKES,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones AS c ON p.ID = c.ID_USUARIO 
                WHERE c.TITULO LIKE '%$labusqueda%'";
                
                $resultado=$conexion->prepare($consultabusqueda);
                
                $resultado->execute();
                
                echo "<section>";
                
                while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
                    
                    $id=$fila["ID"];
                    
                    echo "<div class='songcontainer'>";
                    
                    echo "<div class='imagecontainer'>";
                    
                    echo "<img src='/MIXWORLD/intranet/songs/". $fila["IMAGEN_CANCION"] ."'>";
                    
                    echo "</div>";
                    
                    echo "<div class='titleplayercontainer'>";
                    
                    echo "<div class='titlecontainer'>";
                    
                    echo "<span>" . $fila["TITULO"] . "</span>";
                    
                    echo "</div>";
                    
                    echo "<div class='usercontainer'>";
                    
                    echo "<img src='/MIXWORLD/intranet/perfiles/". $fila["IMAGEN_PERFIL"] ."'>";
                    
                    echo "<span>" . $fila["USUARIO"] . "</span>";
                    
                    echo "</div>";
                    
                    echo "<div class='playercontainer'>";
                    
                    echo "<div class='playicon'>";
                    
                    echo "<i class='fa-solid fa-play play inicio". $id ."' id='". $id ."' data-file='/MIXWORLD/intranet/songs/". $fila["CANCION"] ."'></i>";
                    
                    echo "<i class='fa-solid fa-pause pause detener". $id ."' id='". $id ."' data-file='/MIXWORLD/intranet/songs/". $fila["CANCION"] ."'></i>";
                    
                    echo "</div>";
                    
                    echo "<div class='bar barra". $id ."' id='". $id ."'>";
                    
                    echo "<div id='". $id ."' class='progress progreso". $id ."'></div>";
                    
                    echo "</div>";
                    
                    echo "</div>";
                    
                    echo "<div class='viewscontainer'>";
                    
                    echo "<span class='rep". $id ."'><i class='fa-solid fa-ear-listen'></i>". $fila["REPRODUCCIONES"] ."</span>";
                    
                    echo "<span><i class='fa-regular fa-face-smile-wink'></i>". $fila["LIKES"] ."</span>";
                    
                    echo "<span><i class='fa-regular fa-face-sad-tear'></i>". $fila["DISLIKES"] ."</span>";
                    
                    echo "</div>";
                    
                    echo "</div>";
                    
                    echo "</div>";
                }
                
                echo "</section>";
                
            } catch (Exception $e) {
                
                die("Error: " . $e->getMessage());
            }
        }
        
        ?>
	
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
		
		<?php 
		
		@$busqueda=$_GET["buscador"];
		
		if ($busqueda==NULL) {
		
		?>
		
		<section>
		
		<?php 
		
		try{
		    
		    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		    
		    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $conexion->exec("SET CHARACTER SET utf8");
		    
		    $registros_pagina=15;
		    
		    if(isset($_GET["numeropagina"])){
		        
		        $inicio_registros=$_GET["numeropagina"];
		    }else {
		     
		        $inicio_registros=1;
		    }
		    
		    $inicio_paginacion=($inicio_registros-1)*$registros_pagina;
		    
		    $consulta_cantidad="SELECT ID FROM canciones";
		    
		    $resultado=$conexion->prepare($consulta_cantidad);
		    
		    $resultado->execute();
		    
		    $totalresultados=$resultado->rowCount();
		    
		    $limitepaginas=ceil($totalresultados/$registros_pagina);
		    
		    $consulta="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,c.REPRODUCCIONES,
            CASE
            WHEN c.REPRODUCCIONES < 1000 THEN c.REPRODUCCIONES
            WHEN c.REPRODUCCIONES > 999 AND c.REPRODUCCIONES < 10000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,1),'K')
            WHEN c.REPRODUCCIONES > 9999 AND c.REPRODUCCIONES < 100000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,2),'K')
            WHEN c.REPRODUCCIONES > 99999 AND c.REPRODUCCIONES < 1000000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,3),'K')
            WHEN c.REPRODUCCIONES > 999999 THEN CONCAT('+',SUBSTRING(c.REPRODUCCIONES,1,1),'M')
            END AS REPRODUCCIONES           
            ,c.LIKES,c.DISLIKES,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones AS c ON p.ID = c.ID_USUARIO 
            LIMIT $inicio_paginacion,$registros_pagina";
		    
		    $resultado=$conexion->prepare($consulta);
		    
		    $resultado->execute();
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		        
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
    					
    						<span class="user"><?php echo $fila["USUARIO"]; ?></span>
    					
    					</div>
    					<div class="playercontainer">
    					
    						<div class="playicon">
    						
    							<i class="fa-solid fa-play play inicio<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
    							
    							<i class="fa-solid fa-pause pause detener<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
    						
    						</div>
    						
    						<div class="bar barra<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>">
    						
    							<div id="<?php echo $fila["ID"]; ?>" class="progress progreso<?php echo $fila["ID"]; ?>"></div>
    						
    						</div>
    					
    					</div>
    					<div class="viewscontainer">
    						
    						<span class="rep<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $fila["REPRODUCCIONES"]; ?></span>
    						
    						<span><i class="fa-regular fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
    						
    						<span><i class="fa-regular fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
    					
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
		
		<div class='contenedor_paginacion'>
		
		<?php 
		
		  for ($i = 1; $i <= $limitepaginas; $i++) {
		      
		      echo "<a href='?numeropagina=". $i ."'><i class='fa-solid fa-music'></i><br>". $i ."</a>";
		  }
		
		?>
		
		</div>
		
		<?php 
		
		}else {
		    
		    buscadatos($busqueda);
		}
		
		?>
	
	</body>

</html>
