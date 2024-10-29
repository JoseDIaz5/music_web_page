<!DOCTYPE html>
<html>

	<head>
		<?php 
        
            session_start();
        
        ?>
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD</title>

        <link rel="stylesheet" href="principal.css?v=<?php echo time(); ?>">
        
        <script src="https://kit.fontawesome.com/f221aee085.js"></script>

        <script src="jquery-1.8.3.js"></script>
        
        <script src="principal.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejareproducciones.js?v=<?php echo time(); ?>"></script>
        
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

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>

        <script src="jquery-1.8.3.js"></script>

        <script src="principal.js"></script>
        
        <?php 
        
        
        
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
					
						<a href="cuenta.php">
				
							<span class="imagediv">
					
								<img src="/MIXWORLD/intranet/perfiles/<?php echo $_SESSION["picture"] ?>" class="imguser"></img>
					
							</span>
						
						</a>
					
					</label>
					
					<input type="checkbox" id="check" class="checkb">
				
				</div>
				
			</nav>
		
		</header>
		
		<section>
		
			<?php 
			
			 try {
			     
			     $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
			     
			     $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,true);
			     
			     $conexion->exec("SET CHARACTER SET utf8");
			     
			     $registros_pagina=14;
			     
			     if(isset($_GET["numeropagina"])){
			      
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
			     
			     $consulta="SELECT c.ID,c.IMAGEN_CANCION,c.TITULO,c.CANCION,
                CASE
                WHEN c.REPRODUCCIONES < 1000 THEN c.REPRODUCCIONES
                WHEN c.REPRODUCCIONES > 999 AND c.REPRODUCCIONES < 10000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,1),'K')
                WHEN c.REPRODUCCIONES > 9999 AND c.REPRODUCCIONES < 100000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,2),'K')
                WHEN c.REPRODUCCIONES > 99999 AND c.REPRODUCCIONES < 1000000 THEN CONCAT(SUBSTRING(c.REPRODUCCIONES,1,3),'K')
                WHEN c.REPRODUCCIONES > 999999 THEN CONCAT('+',SUBSTRING(c.REPRODUCCIONES,1,1),'M')
                END AS REPRODUCCIONES           
                ,c.LIKES,c.DISLIKES
                ,p.ID as iduser,p.IMAGEN_PERFIL,p.USUARIO FROM perfiles AS p INNER JOIN canciones as c ON p.ID = c.ID_USUARIO
                WHERE c.TITULO LIKE CONCAT('%',:buscador,'%') LIMIT $inicio_paginacion,$registros_pagina";
			     
			     $resultado=$conexion->prepare($consulta);
			     
			     $resultado->execute(array(":buscador"=>strval($buscador)));
			     
			     $consultalikescanciones="SELECT ID FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
			     
			     $result=$conexion->prepare($consultalikescanciones);
			     
			     $consultadislikescanciones="SELECT ID FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
			     
			     $resulttwo=$conexion->prepare($consultadislikescanciones);
			     
			     while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
			         
			         $id=$fila["ID"];
			         
			         $result->execute(array(":idsong"=>$fila["ID"],":iduser"=>$_SESSION["idusu"]));
			         
			         $resulttwo->execute(array(":idsong"=>$fila["ID"],":iduser"=>$_SESSION["idusu"]));
			         
			         
			         
			         $cantidadlikescancion=$result->rowCount();
			         
			         $cantidaddislikescancion=$resulttwo->rowCount();
			         
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
			     
			 } catch (Exception $e) {
			     
			     die("Error: " . $e->getMessage());
			 }
			
			?>
		
		</section>
		
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
		      
		      echo "<a href='?numeropagina=". $i ."'><i class='fa-solid fa-music'></i><br>". $i ."</a>";
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
	
	</body>

</html>
