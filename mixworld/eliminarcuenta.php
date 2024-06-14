<?php

try {
    
    session_start();
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $consultaseguidores="SELECT ID_USUARIO_SEGUIDOR,ID_USUARIO_SEGUIDO FROM seguidores WHERE ID_USUARIO_SEGUIDOR=:idfollower";
    
    $resultado=$conexion->prepare($consultaseguidores);
    
    $resultado->execute(array(":idfollower"=>$_SESSION["idusu"]));
    
    $rows=$resultado->rowCount();
    
    if ($rows>0) {
        
        $actualizaseguidores="UPDATE perfiles SET SEGUIDORES=SEGUIDORES-1 WHERE ID=:idfollowed";
        
        $resultados=$conexion->prepare($actualizaseguidores);
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $usuarioseguido=$fila["ID_USUARIO_SEGUIDO"];
            
            $resultados->execute(array(":idfollowed"=>$usuarioseguido));
        }
    }
    
    $consultaseguidor="SELECT ID_USUARIO_SEGUIDOR,ID_USUARIO_SEGUIDO FROM seguidores WHERE ID_USUARIO_SEGUIDO=:idfollowed";
    
    $resultado=$conexion->prepare($consultaseguidor);
    
    $resultado->execute(array(":idfollowed"=>$_SESSION["idusu"]));
    
    $rowst=$resultado->rowCount(); 
    
    if ($rowst>0) {
        
        $actualizasiguiendo="UPDATE perfiles SET SIGUIENDO=SIGUIENDO-1 WHERE ID=:idfollowing";
        
        $resultados=$conexion->prepare($actualizasiguiendo);
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $usuarioseguidor=$fila["ID_USUARIO_SEGUIDOR"];
            
            $resultados->execute(array(":idfollowing"=>$usuarioseguidor));
        }
    }
    
    $consultalikes="SELECT ID_USUARIO,ID_CANCION FROM songs_likes WHERE ID_USUARIO=:iduser";
    
    $resultado=$conexion->prepare($consultalikes);
    
    $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
    
    $rowsl=$resultados->rowCount();
    
    if ($rowsl>0) {
        
        $actualizalikes="UPDATE canciones SET LIKES=LIKES-1 WHERE ID=:idsong";
        
        $resultados=$conexion->prepare($actualizalikes);
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $cancionid=$fila["ID_CANCION"];
            
            $resultados->execute(array(":idsong"=>$cancionid));
        }
    }
    
    $consultadislikes="SELECT ID_USUARIO,ID_CANCION FROM songs_dislikes WHERE ID_USUARIO=:iduser";
    
    $resultado=$conexion->prepare($consultadislikes);
    
    $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
    
    $rowsd=$resultado->rowCount();
    
    if ($rowsd>0) {
        
        $actualizadislikes="UPDATE canciones SET DISLIKES=DISLIKES-1 WHERE ID=:idsong";
        
        $resultados=$conexion->prepare($actualizadislikes);
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $cancionid=$fila["ID_CANCION"];
            
            $resultados->execute(array(":idsong"=>$cancionid));
        }
    }
    
    $eliminaperfiles="DELETE FROM perfiles WHERE ID=:iduser";
    
    $resultado=$conexion->prepare($eliminaperfiles);
    
    if (isset($_SESSION["usuario"])) {
        
        $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
        
        if ($resultado->rowCount()!=0) {
            
            session_destroy();
            
            header("location:index.php");
        }
    }else {
        
        header("location:index.php");
    }
    
} catch (Exception $e) {
    
    die("ERROR: " . $e->getMessage());
}

?>
