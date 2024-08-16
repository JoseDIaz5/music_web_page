<!DOCTYPE html>
<html>

	<head>
	
		<?php 
        
            session_start();
        
        ?>
        
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        
        <title>MIXWORLD | Canción</title>
        
        <link rel="stylesheet" href="cancion.css?v=<?php echo time(); ?>">
        
        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-1.8.3.js"></script>
        
        <script src="cancion.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejareproduccionescancion.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <?php 
        
        function buscadatos($labusqueda){
            
            try{
                
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
                    
                    echo "<div class='likescontainer'>";
                    
                    echo "<span class='rep". $id ."'><i class='fa-solid fa-ear-listen'></i>". $fila["REPRODUCCIONES"] ."</span>";
                    
                    echo "<span><i class='fa-regular fa-face-smile-wink'></i>". $fila["LIKES"] ."</span>";
                    
                    echo "<span><i class='fa-regular fa-face-sad-tear'></i>". $fila["DISLIKES"] ."</span>";
                    
                    echo "</div>";
                    
                    echo "</div>";
                    
                    echo "</div>";
                }
                
                echo "</section>";
                
            }catch (Exception $e){
                
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
					
							<img src="/MIXWORLD/intranet/perfiles/<?php echo $_SESSION["picture"] ?>" class="imguser"></img>
					
						</span>
					
					</label>
					
					<input type="checkbox" id="check" class="checkb">
					
					<div class="profileoptions">
					
						<ul class="list-profile">
					
							<li><a href="cuenta.php"><i class="fas fa-user"></i><span>Mi cuenta</span></a></li>
        				
        					<li><a href="favoritos.php"><i class="fas fa-star"></i><span>Favoritos</span></a></li>
					
						</ul>
					
					</div>	
				
				</div>
				
			</nav>
		
		</header>
		
		<?php 
		
		@$busqueda=$_GET["buscador"];
		
		if($busqueda==NULL){
		
		?>
		
		<section>
		
			<?php
		
			try{
		    
		    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		    
		    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $conexion->exec("SET CHARACTER SET utf8");
		    
		    //$idcancion=1;
		    
		    $idcancion=$_GET["id"];
		    
		    $consulta="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,c.DESCRIPCION,c.REPRODUCCIONES,
            CASE
            WHEN c.REPRODUCCIONES < 1000 THEN c.REPRODUCCIONES
            WHEN c.REPRODUCCIONES > 999 AND c.REPRODUCCIONES < 10000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,1),'K')
            WHEN c.REPRODUCCIONES > 9999 AND c.REPRODUCCIONES < 100000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,2),'K')
            WHEN c.REPRODUCCIONES > 99999 AND c.REPRODUCCIONES < 1000000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,3),'K')
            WHEN c.REPRODUCCIONES > 999999 THEN CONCAT('+',SUBSTRING(c.REPRODUCCIONES,1,1),'M')
            END AS REPRODUCCIONES           
            ,c.LIKES,c.DISLIKES,p.ID AS iduser,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones AS c ON p.ID = c.ID_USUARIO WHERE c.ID=:idsong";
		    
		    $resultado=$conexion->prepare($consulta);
		    
		    $resultado->execute(array(':idsong'=>$idcancion));
		    
		    $consultalikescanciones="SELECT ID FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
		    
		    $result=$conexion->prepare($consultalikescanciones);
		    
		    $consultadislikescanciones="SELECT ID FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
		    
		    $resulttwo=$conexion->prepare($consultadislikescanciones);
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		        
		        $result->execute(array(":idsong"=>$fila["ID"],":iduser"=>$_SESSION["idusu"]));
		        
		        $resulttwo->execute(array(":idsong"=>$fila["ID"],":iduser"=>$_SESSION["idusu"]));
		        
		        $cantidadlikescancion=$result->rowCount();
		        
		        $cantidaddislikescancion=$resulttwo->rowCount();
		        
		        ?>
		        
		        <div class="songtwocontainer">
			
        			<div class="imagecontainer">
        			
        				<img src="/MIXWORLD/intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
        			
        			</div>
        			<div class="titleplayercontainer">
        			
        				<div class="titlecontainer">
        				
        					<span><?php echo $fila["TITULO"]; ?></span>	
        				
        				</div>
        				<div class="usercontainer">
			         		
		         			<img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
		         			
		         			<span><a href="cuenta.php?iduser=<?php echo $fila["iduser"]; ?>"><?php echo $fila["USUARIO"]; ?></a></span>
		         		
		         		</div>
		         		<div class="playercontainer">
			         		
		         			<div class="playicon">
		         			
		         				<i class="fa-solid fa-play play inicio<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
		         				
		         				<i class="fa-solid fa-pause pause detener<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
		         			
		         			</div>
		         			
		         			<div class="bar barra<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>">
		         			
		         				<div id="<?php echo $fila["ID"]; ?>" class="progress progreso<?php echo $fila["ID"]; ?>"></div>
		         			
		         			</div>
		         			
		         			<div class="downloadcontainer">
		         			
		         				<a href="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>" download><i class="fa-solid fa-download"></i></a>
		         			
		         			</div>
		         		
		         		</div>
		         		<div class="likescontainer">
			         		
			         			<span class="rep<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $fila["REPRODUCCIONES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 if ($cantidadlikescancion<1) {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }
			         			 if($cantidaddislikescancion<1){
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }
			         			
			         			?>
			         		
			         		</div>
        			</div>
    			
    			</div>
    			
    			<div class="descriptioncontainer">
    			
    				<h2>DESCRIPCIÓN</h2>
    				
    				<div class="description"><?php echo $fila["DESCRIPCION"]; ?></div>
    			
    			</div>
		        
		        <?php 
		    }
		    
		    $consultacomentarios="SELECT p.IMAGEN_PERFIL,p.USUARIO,co.FECHA_COMENTARIO,co.COMENTARIO FROM perfiles AS p INNER JOIN canciones AS c 
                                  ON p.ID=c.ID_USUARIO INNER JOIN comentarios AS co ON c.ID=co.ID_CANCION WHERE c.ID=:idsong";
		    
		    $resultado=$conexion->prepare($consultacomentarios);
		    
		    $resultado->execute(array(":idsong"=>$idcancion));
		    
		    echo "<div class='commentscontainer'>";
		    
		    echo "<h2>COMENTARIOS</h2>";
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		        
		        ?>
		        
		        <div class="comment">
		        
		        	<div class="profilecomment">
		        
		        		<div><img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>"></div>
		        	
		        		<div><?php echo $fila["USUARIO"]; ?></div>
		        
		        	</div>
		        	<div class="date">
		        
		        		<span><?php echo $fila["FECHA_COMENTARIO"]; ?></span>
		        
		        	</div>
		        	<div class="commentcontent">
		        	
		        		<span><?php echo $fila["COMENTARIO"]; ?></span>
		        	
		        	</div>
		        
		        </div>
		        
		        <?php
		    }
		    
		    echo "</div>";
		    
		}catch(Exception $e){
		    
		    die("Error: " . $e->getMessage());
		}
		
		?>
			
		
		</section>
		
		<?php 
		
		}else {
		    
		    buscadatos($busqueda);
		}
		
		?>
	
	</body>

</html>
