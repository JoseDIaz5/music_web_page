<?php 

session_start();

try {
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idcancion=$_POST["id"];
    
    $idusuario=$_SESSION["idusu"];
    
    $consultalikescanciones="SELECT ID FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
    
    $resultado=$conexion->prepare($consultalikescanciones);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $row=$resultado->rowCount();
    
    if($row>0){
        
        $eliminalikecancion="DELETE FROM songs_likes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
        
        $resultado=$conexion->prepare($eliminalikecancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacanciones="UPDATE canciones SET LIKES=LIKES-1 WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($actualizacanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $cantidadlikes="SELECT LIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($cantidadlikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $megustacanciones=$fila["LIKES"];
        }
        
        $like="<i class='fa-regular fa-face-smile-wink'></i>" . $megustacanciones;
    }
    else {
        
        $cantidadlikes="SELECT LIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($cantidadlikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $megustacanciones=$fila["LIKES"];
        }
        
        $like="<i class='fa-regular fa-face-smile-wink'></i>" . $megustacanciones;
    }
    
    //-----------------------------------------------------------------------------------------------------------------------------
    
    $consultacantidaddislikes="SELECT ID FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
    
    $resultado=$conexion->prepare($consultacantidaddislikes);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $cantidad=$resultado->rowCount();
    
    if ($cantidad<1) {
        
        $insertadislikescanciones="INSERT INTO songs_dislikes(ID_CANCION,ID_USUARIO) VALUES(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($insertadislikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="UPDATE canciones SET DISLIKES=DISLIKES+1 WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $dislikescanciones="SELECT DISLIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($dislikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $dislikes=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-solid fa-face-sad-tear'></i>" . $dislikes;
    }else {
        
        $eliminadislikescancion="DELETE FROM songs_dislikes WHERE ID_CANCION=:idsong AND ID_USUARIO=:iduser";
        
        $resultado=$conexion->prepare($eliminadislikescancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="UPDATE canciones SET DISLIKES=DISLIKES-1 WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $dislikescanciones="SELECT DISLIKES FROM canciones WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($dislikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $dislikes=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-regular fa-face-sad-tear'></i>" . $dislikes;
    }
    
    $datos=array('like'=>$like,'dlike'=>$dislike);
    
    echo json_encode($datos);
    
} catch (Exception $e) {

    die("Error: " . $e->getMessage());
}

?>