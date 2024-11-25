<?php

    session_start();

    try {
        
        $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
        
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $conexion->exec("SET CHARACTER SET utf8");
        
        if (!isset($_FILES["imagencancion"]["name"])) {
            
            $imagen=$_POST["imagesong"];
        }else {
            
            $imagen=$_FILES["imagencancion"]["name"];
            
            $carpetaimg=$_SERVER["DOCUMENT_ROOT"] . "/MIXWORLD/intranet/songs/";
            
            move_uploaded_file($_FILES['imagencancion']['tmp_name'], $carpetaimg.$imagen);
        }
        
        $titulo=$_POST["titulo"];
        
        $descripcion=$_POST["comenta"];
        
        $id=$_POST["id"];
        
        $consulta="UPDATE canciones SET IMAGEN_CANCION=:songimage,TITULO=:title,DESCRIPCION=:description WHERE ID=:idsong";
        
        $resultado=$conexion->prepare($consulta);
        
        $resultado->execute(array(":songimage"=>$imagen,":title"=>$titulo,":description"=>$descripcion,":idsong"=>$id));
        
        $cantidad=$resultado->rowCount();
        
        if ($cantidad!=0) {
            
            header("location:cuenta.php");
        }else {
            
            echo "Error al actualizar la información, intentelo de nuevo";
            
            echo "<a href='updatesong.php?idsong=$id'>Volver</a>";
        }
        
    } catch (Exception $e) {
    }

?>