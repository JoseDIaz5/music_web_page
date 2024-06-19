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
        
        <script src="manejareproduccionescuenta.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
	
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
		      
		      $consultacantidades="SELECT CANCIONES,SEGUIDORES,SIGUIENDO FROM perfiles WHERE ID=:iduser";

		      $consultaperfil="SELECT USUARIO,IMAGEN_PERFIL,IMAGEN_PORTADA,USUARIO_FACEBOOK,USUARIO_INSTAGRAM,USUARIO_X FROM perfiles WHERE ID=:id";
		      
		      $resultado=$conexion->prepare($consultaperfil);
		      
		      $consultacantidades="SELECT CANCIONES,SEGUIDORES,SIGUIENDO,USUARIO_FACEBOOK,USUARIO_INSTAGRAM,USUARIO_X FROM perfiles WHERE ID=:iduser";
		      
		      $resultadoc=$conexion->prepare($consultacantidades);
		      
		      $consultaseguidores="SELECT ID_USUARIO_SEGUIDOR,ID_USUARIO_SEGUIDO FROM seguidores WHERE ID_USUARIO_SEGUIDOR=:iduserfollower AND ID_USUARIO_SEGUIDO=:iduserfollowed";
		      
		      $resultadof=$conexion->prepare($consultaseguidores);
		      
		      if (isset($iduser)) {
		          
		          $resultado->execute(array(":id"=>$iduser));
		          
		          $resultadoc->execute(array(":iduser"=>$iduser));
		          
		          $resultadof->execute(array(":iduserfollower"=>$_SESSION["idusu"],":iduserfollowed"=>$iduser));
		          
		          $row=$resultadof->rowCount();
		          
		          while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		              
		              $portada=$fila["IMAGEN_PORTADA"];
		              
		              $perfil=$fila["IMAGEN_PERFIL"];
		              
		              $usuario=$fila["USUARIO"];
		              
		              $facebookuser=$fila["USUARIO_FACEBOOK"];
		              
		              $instagramuser=$fila["USUARIO_INSTAGRAM"];
		              
		              $xuser=$fila["USUARIO_X"];
		          }
		          while ($filac=$resultadoc->fetch(PDO::FETCH_ASSOC)) {
		              
		              $cantidadcanciones=$filac["CANCIONES"];
		              
		              $seguidores=$filac["SEGUIDORES"];
		              
		              $siguiendo=$filac["SIGUIENDO"];
		          }
		          if ($row<1) {
		              $seguido=0;
		          }else{
		              $seguido=1;
		          }
		      }else {
		          
		          $resultadoc->execute(array(":iduser"=>$_SESSION["idusu"]));
		          
		          while ($filac=$resultadoc->fetch(PDO::FETCH_ASSOC)) {
		              
		              $cantidadcanciones=$filac["CANCIONES"];
		              
		              $seguidores=$filac["SEGUIDORES"];
		              
		              $siguiendo=$filac["SIGUIENDO"];
		              
		              $facebookuser=$filac["USUARIO_FACEBOOK"];
		              
		              $instagramuser=$filac["USUARIO_INSTAGRAM"];
		              
		              $xuser=$filac["USUARIO_X"];
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
					
						<li><span><?php echo $seguidores; ?></span>Seguidores</li>
						
						<li><span><?php echo $siguiendo; ?></span>Siguiendo</li>
						
						<li><span><?php echo $cantidadcanciones; ?></span>Canciones</li>
					
					</ul>
					
					<div class="content">
					
						<ul>
					
							<li><i class="fa-brands fa-x-twitter"></i></li>
						
							<li><a><i class="fab fa-facebook"></i></a></li>
						
							<li><i class="fab fa-instagram"></i></li>

							<?php 
							
							if ($xuser=='') {
							
							?>
							
							<li><i class="fa-brands fa-x-twitter"></i></li>
							
							<?php 
							
							}else {
							
							?>
							
							<li class="enlacered"><a href="https://www.x.com/<?php echo $xuser ?>/"><i class="fa-brands fa-x-twitter"></i></a></li>
							
							<?php 
							
							}
							
							?>
							
							<?php 
							
							if ($facebookuser=='') {
							    ?>
							    
							    <li><i class="fab fa-facebook"></i></li>
							    
							    <?php
							}else {
							    ?>
							    
							    <li class="enlacered"><a href="https://www.facebook.com/<?php echo $facebookuser ?>/"><i class="fab fa-facebook"></i></a></li>
							    
							    <?php
							}
							
							?>
						
							<?php 
							
							if ($instagramuser=='') {
							
							?>
						
							<li><i class="fab fa-instagram"></i></li>
							
							<?php 
							
							}else{
							
							?>
							
							<li class="enlacered"><a href="https://www.instagram.com/<?php echo $instagramuser ?>/"><i class="fab fa-instagram"></i></a></li>
							
							<?php 
							
							}
							?>
					
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
							<li id="comp" class="pestañasubir">Subir canciones</li>
							<li id="comp" class="pestañasubir">Subir canciones</li>
							<li id="delete" class="pestañasubir">Eliminar cuenta</li>
						
						</ul>
						
						<?php 
						
						if (isset($iduser) && !$validaid) {
						    
						    if ($seguido==0) {
						
						?>
						
						<div class="seguir divseguir<?php echo $iduser; ?>" id="<?php echo $iduser; ?>">Seguir</div>
						
						<?php 
						
						    }else {
						     
						        ?>
						        
						        <div class="seguir divseguir<?php echo $iduser; ?>" id="<?php echo $iduser; ?>">Siguiendo</div>
						        
						        <?php
						        
						    }
						
						}else {
						
						?>
						
						<a href="cerrarsesion.php"><div>Cerrar sesión</div></a>
						
						<?php 
						
						}
						
						?>
				
					</nav>
				
					<div id="songs">
					
					<?php 
					
					try {
					    
					    $consultasongs="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,c.REPRODUCCIONES,
                        CASE
                        WHEN c.REPRODUCCIONES < 1000 THEN c.REPRODUCCIONES
                        WHEN c.REPRODUCCIONES > 999 AND c.REPRODUCCIONES < 10000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,1),'K')
                        WHEN c.REPRODUCCIONES > 9999 AND c.REPRODUCCIONES < 100000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,2),'K')
                        WHEN c.REPRODUCCIONES > 99999 AND c.REPRODUCCIONES < 1000000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,3),'K')
                        WHEN c.REPRODUCCIONES > 999999 THEN CONCAT('+',SUBSTRING(c.REPRODUCCIONES,1,1),'M')
                        END AS REPRODUCCIONES
                        ,c.LIKES,c.DISLIKES,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones AS c ON p.ID = c.ID_USUARIO 
                        WHERE c.ID_USUARIO=:iduser";
					    
					    $resultado=$conexion->prepare($consultasongs);
					    
					    $consultalikescanciones="SELECT ID FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
					    
					    $result=$conexion->prepare($consultalikescanciones);
					    
					    $consultadislikescanciones="SELECT ID FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
					    
					    $resulttwo=$conexion->prepare($consultadislikescanciones);
					    
					    if (isset($iduser)) {
					        
					        $resultado->execute(array(":iduser"=>$iduser));
					    }
					    else {
					        
					        $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
					    }
					    
					    $rows=$resultado->rowCount();
					    
					    if ($rows==0) {
					        
					        ?>
					        
					        <span class="nosongsmessage">No hay canciones</span>
					        
					        <?php
					    }
					    
					    while ($filas=$resultado->fetch(PDO::FETCH_ASSOC)) {
					            
					        $result->execute(array(":idsong"=>$filas["ID"],":iduser"=>$_SESSION["idusu"]));
					            
				            $resulttwo->execute(array(":idsong"=>$filas["ID"],":iduser"=>$_SESSION["idusu"]));
					            
				            $cantidadlikescancion=$result->rowCount();
					            
				            $cantidaddislikescancion=$resulttwo->rowCount();
					        
					        
					        ?>
					        
					        <div class="songcontainer">
					        
					        	<div class="imagecontainer">
					        	
					        		<img src="/MIXWORLD/intranet/songs/<?php echo $filas["IMAGEN_CANCION"]; ?>">
					        	
					        	</div>
					        	<div class="titleplayercontainer">
					        	
					        		<div class="titlecontainer">
					        		
					        			<span><?php echo $filas["TITULO"]; ?></span>
					        		
					        		</div>
					        		<div class="usercontainer">
					        		
					        			<img src="/MIXWORLD/intranet/perfiles/<?php echo $filas["IMAGEN_PERFIL"]; ?>">
					        			
					        			<span><?php echo $filas["USUARIO"]; ?></span>
					        		
					        		</div>
					        		<div class="playercontainer">
					        		
					        			<div class="playicon">
					        			
					        				<i class="fa-solid fa-play play inicio<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $filas["CANCION"]; ?>"></i>
					        				
					        				<i class="fa-solid fa-pause pause detener<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $filas["CANCION"]; ?>"></i>
					        			
					        			</div>
					        			<div class="bar barra<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>">
					        			
					        				<div id="<?php echo $filas["ID"]; ?>" class="progress progreso<?php echo $filas["ID"]; ?>"></div>
					        			
					        			</div>
					        		
					        		</div>
					        		<div class="viewscontainer">
					        		
					        			<span class="rep<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $filas["REPRODUCCIONES"]; ?></span>
					        			
					        			<?php 
					        			
					        			if ($cantidadlikescancion<1) {
					        			
					        			?>
					        			
					        			<span class="likesong spanlike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-regular fa-face-smile-wink"></i><?php echo $filas["LIKES"]; ?></span>
					        			
					        			<?php 
					        			
					        			}else {
					        			
					        			?>
					        			
					        			<span class="likesong spanlike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-face-smile-wink"></i><?php echo $filas["LIKES"]; ?></span>
					        			
					        			<?php 
					        			
					        			}
					        			if ($cantidaddislikescancion<1) {
					        			    
					        			?>
					        			
					        			<span class="dislikesong spandislike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-regular fa-face-sad-tear"></i><?php echo $filas["DISLIKES"]; ?></span>
					        			
					        			<?php 
					        			
					        			}else {
					        			
					        			?>
					        			
					        			<span class="dislikesong spandislike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-face-sad-tear"></i><?php echo $filas["DISLIKES"]; ?></span>
					        			
					        			<?php 
					        			
					        			}
					        			
					        			?>
					        		
					        		</div>
					        	
					        	</div>
					        
					        </div>
					        
					        <?php 
					    }
					    
					} catch (Exception $e) {
					    
					    die("Error: " . $e->getMessage());
					}
					
					?>
				
							
					        		
		        		<div class="playercontainers">
		        		
		        			<div class="playicon">
		        			
		        				<i class="fa-solid fa-play play "></i>
		        				
		        				<i class="fa-solid fa-pause pause "></i>
		        			
		        			</div>
		        			<div class="bar">
		        			
		        				<div class="progress"></div>
		        			
		        			</div>
		        		
		        		</div>
					        
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
					
					<div class="deleteaccount">
					
						<form action="eliminarcuenta.php">
						
							<h3>¿De verdad desea eliminar la cuenta?</h3>
							
							<br>
							
							<div class="contelimina">
							
								<input type="submit" id="botonelimina" value="Eliminar" name="eliminacuenta" hidden="hidden">
							
								<div class="cierra" id="deleteaccountbutton">Eliminar</div>
							
							</div>
						
						</form>
					
					</div>
			
				</div>
			
			</div>
		
		</div>
	
	</body>


	

</html>
