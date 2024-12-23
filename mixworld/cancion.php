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
        
        <script src="manejareproducciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <?php 
        
        if (isset($_SESSION["usuario"])){
            
            $buscador='';
        }
        else {
            
            header("location:index.php");
        }
        
        if (isset($_POST['busca'])) {
            
            $buscador=$_POST["buscador"];
            
            $_SESSION["buscador"]=$buscador;
            
        }else if(!isset($_SESSION["buscador"])){
            $buscador='';
        }
        else {
            
            $buscador=$_SESSION["buscador"];
            
            if (!isset($_POST["busca"]) && !isset($_GET["numeropagina"])) {
                unset($_SESSION["buscador"]);
                
                $buscador='';
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
				
					<form action="<?php $_SERVER["PHP_SELF"] ?>" method='POST'>
					
						<div class="search-box">
						
							<input type="search" placeholder="Buscar..." class="buscador" name="buscador">
        				
        					<span class="fas fa-search searchicon" id="searchicon"></span>
        					
        					<input type="submit" id="botonbusca" hidden="hidden" name='busca'>
        			
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
		
		
		
		if($buscador==''){
		
		?>
		
		<section class="sectionone">
		
			<?php
		
			try{
		    
		    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		    
		    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $conexion->exec("SET CHARACTER SET utf8");
		    
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
        			
        			<?php 
        			
        			if ($fila["IMAGEN_CANCION"]=='') {
        			
        			?>
        			
        				<img src="/MIXWORLD/intranet/songsimages/default.png">
        				
        				
        			<?php 
        			
        			}else {
        			
        			?>
        			
        				<img src="/MIXWORLD/intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
        			
        			<?php 
        			
        			}
        			
        			?>
        			
        			</div>
        			<div class="titleplayercontainer">
        			
        				<div class="titlecontainer">
        				
        					<span><?php echo $fila["TITULO"]; ?></span>	
        				
        				</div>
        				<div class="usercontainer">
        				
        				<?php 
        				
        				if ($fila["IMAGEN_PERFIL"]=='') {
        				
        				?>
			         		
		         			<img src="/MIXWORLD/intranet/songsimages/defaultuser.png">
		         			
		         		<?php 
		         		
        				}else {
		         		
		         		?>
		         		
		         			<img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
		         		
		         		<?php 
		         		
        				}
		         		
		         		?>
		         			
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
    			
    			<div class='commentscontainer'>
    			
    				<h2>COMENTARIOS</h2>
    				
    				<div class="formcomments">
    				
    					<form action="subecomentario.php" class="mainform" enctype="multipart/form-data" method="post" data-ajax="false">
    					
    						<div class="areacontainer" id="divarea">
    						
    							<textarea cols="66" rows="3" placeholder="Comenta aquí..." id="textarea" name="comenta" maxlength="900" minlength="1"></textarea>
    							
    							<span class="focus-border"><i></i></span>
    						
    						</div>
    						
    						<p><span class="size">0</span>/900</p>
        					
        					<input type="submit" id="botoncomentar" value="Comentar">
        					
        					<div id="botoncomenta">Comentar</div>
    				
    					</form>
    				
    				</div>
		        </div>
		        <?php 
		        
		        $_SESSION["idcancion"]=$fila["ID"];
		    }
		    
		    $consultacomentarios="SELECT p.IMAGEN_PERFIL,p.USUARIO,co.FECHA_COMENTARIO,co.COMENTARIO FROM perfiles AS p 
                                 INNER JOIN comentarios AS co ON p.ID=co.ID_USUARIO WHERE co.ID_CANCION=:idsong";
		    
		    $resultado=$conexion->prepare($consultacomentarios);
		    
		    $resultado->execute(array(":idsong"=>$idcancion));
		    ?>
                <div class='divcomment'>
            <?php
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
                
		        
		        ?>
		        
    		        <div class="comment">
    		        
    		        	<div class="profilecomment">
    		        	
    		        	<?php 
    		        	
    		        	if ($fila["IMAGEN_PERFIL"]=='') {
    		        	
    		        	?>
    		        
    		        		<div><img src="/MIXWORLD/intranet/songsimages/defaultuser.png"></div>
    		        		
    		        	<?php 
    		        	
    		        	}else {
    		        	
    		        	?>
    		        	
    		        		<div><img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>"></div>
    		        	
    		        	<?php 
    		        	
    		        	}
    		        	
    		        	?>
    		        	
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
		    
		  }catch(Exception $e){
		    
		    die("Error: " . $e->getMessage());
		  }
		
		?>
			</div>
		
		</section>
		
		<?php 
		
		}else {
		    
		    try {
		        
		        $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		        
		        $conexion->exec("SET CHARACTER SET utf8");
		        
		        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        
		        $registros_pagina=14;
		        
		        if (isset($_GET["numeropagina"])) {
		            
		            $inicio_registros=$_GET["numeropagina"];
		        }else {
		            
		            $inicio_registros=1;
		        }
		        
		        $inicio_paginacion=($inicio_registros-1)*$registros_pagina;
		        
		        $consulta_cantidad="SELECT ID FROM canciones WHERE TITULO LIKE '%$buscador%'";
		        
		        $resultado=$conexion->prepare($consulta_cantidad);
		        
		        $resultado->execute();
		        
		        $totalresultados=$resultado->rowCount();
		        
		        $limitepaginas=ceil($totalresultados/$registros_pagina);
		        
		        $limitapaginas=3;
		        
		        if ($inicio_registros>$limitapaginas) {
		            
		            $numero_inicio=$inicio_registros-$limitapaginas;
		            
		        }else {
		            
		            $numero_inicio=1;
		        }
		        
		        if ($inicio_registros<($limitepaginas-$limitapaginas)) {
		            
		            $numero_final=$inicio_registros+$limitapaginas;
		            
		        }else {
		            
		            $numero_final=$limitepaginas;
		        }
		        
		        $consultabusqueda="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,c.REPRODUCCIONES,
                CASE
                WHEN c.REPRODUCCIONES < 1000 THEN c.REPRODUCCIONES
                WHEN c.REPRODUCCIONES > 999 AND c.REPRODUCCIONES < 10000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,1),'K')
                WHEN c.REPRODUCCIONES > 9999 AND c.REPRODUCCIONES < 100000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,2),'K')
                WHEN c.REPRODUCCIONES > 99999 AND c.REPRODUCCIONES < 1000000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,3),'K')
                WHEN c.REPRODUCCIONES > 999999 THEN CONCAT('+',SUBSTRING(c.REPRODUCCIONES,1,1),'M')
                END AS REPRODUCCIONES
                ,c.LIKES,c.DISLIKES,p.ID AS iduser,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones AS c ON p.ID = c.ID_USUARIO
                WHERE c.TITULO LIKE CONCAT('%',:buscador,'%') LIMIT $inicio_paginacion,$registros_pagina";
		        
		        $resultado=$conexion->prepare($consultabusqueda);
		        
		        $resultado->execute(array(":buscador"=>$buscador));
		        
		        $searchsongslikes="SELECT ID FROM songs_likes WHERE ID_CANCION=:id_song AND ID_USUARIO=:id_user";
		        
		        $searchsongsdislikes="SELECT ID FROM songs_dislikes WHERE ID_CANCION=:id_song AND ID_USUARIO=:id_user";
		        
		        $resultl=$conexion->prepare($searchsongslikes);
		        
		        $resultd=$conexion->prepare($searchsongsdislikes);
		        
		        echo "<section class='sectionsongs'>";
		        
		        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		            
		            $id=$fila["ID"];
		            
		            $resultl->execute(array(":id_song"=>$id,":id_user"=>$_SESSION["idusu"]));
		            
		            $resultd->execute(array(":id_song"=>$id,":id_user"=>$_SESSION["idusu"]));
		            
		            $cantidadlikescancion=$resultl->rowCount();
		            
		            $cantidaddislikescancion=$resultd->rowCount();
		            
		            ?>
		            
		            <div class="songcontainer">
			         
			         	<div class="imagecontainer">
			         	
			         	<?php 
			         	
			         	if($fila["IMAGEN_CANCION"]==''){
			         	
			         	?>
			         	
			         		<img src="/MIXWORLD/intranet/songsimages/default.png">
			         	
			         	<?php 
			         	
			         	}else{
			         	
			         	?>
			         	
			         		<img src="/MIXWORLD/intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
			         		
			         	<?php 
			         	
			         	}
			         	
			         	?>
			         	
			         	</div>
			         	<div class="titleplayercontainer">
			         	
			         		<div class="titlecontainer">
			         		
			         			<a href='cancion.php?id=<?php echo $id;?>' class='link'><span><?php echo $fila["TITULO"]; ?></span></a>
			         		
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
		            
		            <?php
		        }
		        
		        echo "</section>";
		        
		        ?>
		        
		        <div class='contenedor_paginacion'>
		        
		        <?php 
		        
		        if ($inicio_registros>1) {
	            
		           echo "<a href='?numeropagina=" . ($inicio_registros-1) . "'>";
		            
	            ?>
	            
	            	&laquo;
	            
	            <?php
	            
	               echo "</a>";
		        }
		        
		        ?>
		        
		        <?php 
		        
		        for ($i = $numero_inicio; $i <= $numero_final; $i++) {
		            
		            echo "<a href='?numeropagina=" . $i . "'><i class='fa-solid fa-music'></i><br>" . $i . "</a>";
		        }
		        
		        ?>
		        
		        <?php 
		        
		        if ($inicio_registros<$limitepaginas) {
		            
		            echo "<a href='?numeropagina=" . ($inicio_registros+1) . "'>";
		            
	            ?>
	            
	            	&raquo;
	            
	            <?php
	            
	               echo "</a>";
		        }
		        
		        ?>
		        
		        </div>
		        
		        <?php
		        
		    } catch (Exception $e) {
		        
		        die("Error: " . $e->getMessage());
		    }
		    
		    ?> 
		     <div class="formcommentstwo">
    				
				<form action="subecomentario.php" class="mainform" enctype="multipart/form-data" method="post" data-ajax="false">
				
					<div class="areacontainer" id="divarea">
					
						<textarea cols="66" rows="3" placeholder="Comenta aquí..." id="textarea" name="comenta" maxlength="900" minlength="1"></textarea>
						
						<span class="focus-border"><i></i></span>
					
					</div>
					
					<p><span class="size">0</span>/900</p>
					
					<input type="submit" id="botoncomentar" value="Comentar">
					
					<div id="botoncomenta">Comentar</div>
			
				</form>
			
			</div>
		    <?php
		}
		
		?>
	
	</body>

</html>