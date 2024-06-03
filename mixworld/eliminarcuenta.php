<?php

try {
    
    session_start();
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conexion->exec("SET CHARACTER SET utf8");
    
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