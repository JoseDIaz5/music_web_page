<?php 

session_start();

try {
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idcancion=$_POST["id"];
    
    $insertareproducciones="UPDATE canciones SET REPRODUCCIONES=REPRODUCCIONES+1 WHERE ID=:idsong";
    
    $resultado=$conexion->prepare($insertareproducciones);
    
    $resultado->execute(array(":idsong"=>$idcancion));
    
    $consultareproducciones="SELECT REPRODUCCIONES,
    CASE
    WHEN REPRODUCCIONES < 1000 THEN REPRODUCCIONES
    WHEN REPRODUCCIONES > 999 AND REPRODUCCIONES < 10000 THEN CONCAT(SUBSTRING(REPRODUCCIONES,1,1),'K')
    WHEN REPRODUCCIONES > 9999 AND REPRODUCCIONES < 100000 THEN CONCAT(SUBSTRING(REPRODUCCIONES,1,2),'K')
    WHEN REPRODUCCIONES > 99999 AND REPRODUCCIONES < 1000000 THEN CONCAT(SUBSTRING(REPRODUCCIONES,1,3),'K')
    WHEN REPRODUCCIONES > 999999 THEN CONCAT('+',SUBSTRING(REPRODUCCIONES,1,1),'M')
    END AS REPRODUCCIONES
     FROM canciones WHERE ID=:idsong";
    
    $resultado=$conexion->prepare($consultareproducciones);
    
    $resultado->execute(array(":idsong"=>$idcancion));
    
    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
        
        $reproducciones=$fila["REPRODUCCIONES"];
    }
    
    $cantidad="<i class='fa-solid fa-ear-listen'></i>" . $reproducciones;
    
    $datos=array("cantidad"=>$cantidad);
    
    echo json_encode($datos);
    
} catch (Exception $e) {
    
    die("Error: " . $e->getMessage());
}

if (!isset($_SESSION["idusu"])) {
    
    session_destroy();
}

?>