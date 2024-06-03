<?php

session_start();

try {
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idusuarioseguido=$_POST["id"];
    
    $idusuarioseguidor=$_SESSION["idusu"];
    
    $consultaseguidores="SELECT ID FROM seguidores WHERE ID_USUARIO_SEGUIDOR=:follower AND ID_USUARIO_SEGUIDO=:followed";
    
    $resultado=$conexion->prepare($consultaseguidores);
    
    $resultado->execute(array(":follower"=>$idusuarioseguidor,":followed"=>$idusuarioseguido));
    
    $row=$resultado->rowCount();
    
    if ($row>0) {
        
        $eliminaseguidor="DELETE FROM seguidores WHERE ID_USUARIO_SEGUIDOR=:follower AND ID_USUARIO_SEGUIDO=:followed";
        
        $resultado=$conexion->prepare($eliminaseguidor);
        
        $resultado->execute(array(":follower"=>$idusuarioseguidor,":followed"=>$idusuarioseguido));
        
        $actualizaseguidores="UPDATE perfiles SET SEGUIDORES=SEGUIDORES-1 WHERE ID=:idfollowed";
        
        $resultado=$conexion->prepare($actualizaseguidores);
        
        $resultado->execute(array(":idfollowed"=>$idusuarioseguido));
        
        $actualizaseguidor="UPDATE perfiles SET SIGUIENDO=SIGUIENDO-1 WHERE ID=:idfollower";
        
        $resultado=$conexion->prepare($actualizaseguidor);
        
        $resultado->execute(array(":idfollower"=>$idusuarioseguidor));
        
        $valorseguir="Seguir";
    }else {
        
        $insertaseguidor="INSERT INTO seguidores(ID_USUARIO_SEGUIDOR,ID_USUARIO_SEGUIDO) VALUES(:idfollower,:idfollowed)";
        
        $resultado=$conexion->prepare($insertaseguidor);
        
        $resultado->execute(array(":idfollower"=>$idusuarioseguidor,":idfollowed"=>$idusuarioseguido));
        
        $actualizaseguidores="UPDATE perfiles SET SEGUIDORES=SEGUIDORES+1 WHERE ID=:idfollowed";
        
        $resultado=$conexion->prepare($actualizaseguidores);
        
        $resultado->execute(array(":idfollowed"=>$idusuarioseguido));
        
        $actualizaseguidor="UPDATE perfiles SET SIGUIENDO=SIGUIENDO+1 WHERE ID=:idfollower";
        
        $resultado=$conexion->prepare($actualizaseguidor);
        
        $resultado->execute(array(":idfollower"=>$idusuarioseguidor));
        
        $valorseguir="Siguiendo";
    }
    
    $datos=array("siguiendo"=>$valorseguir);
    
    echo json_encode($datos);
    
} catch (Exception $e) {
    
    die("Error: " . $e->getMessage());
}

?>