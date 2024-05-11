<?php 

session_start();
   
try {
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idcancion=$_POST["id"];
    
    $idusuario=$_SESSION["idusu"];
    
    $consultadislikescanciones="SELECT ID FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
    
    $resultado=$conexion->prepare($consultadislikescanciones);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $row=$resultado->rowCount();
    
    if ($row>0) {
        
        $eliminadislikecancion="DELETE FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
        
        $resultado=$conexion->prepare($eliminadislikecancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacanciones="UPDATE canciones SET DISLIKES=DISLIKES-1 WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($actualizacanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $cantidaddislikes="SELECT DISLIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($cantidaddislikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $nomegustascanciones=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-regular fa-face-sad-tear'></i>" . $nomegustascanciones;
    }
    else {
        
        $cantidaddislikes="SELECT DISLIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($cantidaddislikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $nomegustascanciones=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-regular fa-face-sad-tear'></i>" . $nomegustascanciones;
    }
    
    //-----------------------------------------------------------------------------------------------------------------------
    
    $consultacantidadlikes="SELECT ID FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
    
    $resultado=$conexion->prepare($consultacantidadlikes);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $cantidad=$resultado->rowCount();
    
    if ($cantidad<1) {
        
        $insertalikescanciones="INSERT INTO songs_likes(ID_CANCION,ID_USUARIO) VALUES(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($insertalikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="UPDATE canciones SET LIKES=LIKES+1 WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $likescanciones="SELECT LIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($likescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $likes=$fila["LIKES"];
        }
        
        $like="<i class='fa-solid fa-face-smile-wink'></i>" . $likes;
    }else{
        
        $eliminalikescancion="DELETE FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
        
        $resultado=$conexion->prepare($eliminalikescancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="UPDATE canciones SET LIKES=LIKES-1 WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $likescanciones="SELECT LIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($likescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $likes=$fila["LIKES"];
        }
        
        $like="<i class='fa-regular fa-face-smile-wink'></i>" . $likes;
    }
    
    $datos=array('like'=>$like,'dlike'=>$dislike);
    
    echo json_encode($datos);
    
} catch (Exception $e) {
    
    die("Error: " . $e->getMessage());
}   

?>