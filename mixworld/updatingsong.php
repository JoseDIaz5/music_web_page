<head>

	<link rel="stylesheet" href="updatingsong.css?v=<?php echo time(); ?>">

</head>
<?php

    session_start();
    
    if (isset($_SESSION["idusu"])) {
        
        try {
            
            $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
            
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $conexion->exec("SET CHARACTER SET utf8");
            
            if (!isset($_FILES["imagencancion"]["name"])) {
                
                $imagen=$_POST["imagesong"];
            }else {
                
                $imagen=$_FILES["imagencancion"]["name"];
                
                $imagentipo=$_FILES["imagencancion"]["type"];
                
                $carpetaimg=$_SERVER["DOCUMENT_ROOT"] . "/MIXWORLD/intranet/songs/";
                
                move_uploaded_file($_FILES['imagencancion']['tmp_name'], $carpetaimg.$imagen);
            }
            
            $titulo=$_POST["titulo"];
            
            $descripcion=$_POST["comenta"];
            
            $id=$_POST["id"];
            
            if (isset($imagentipo)) {
                
                if ($imagentipo=="image/jpg" || $imagentipo=="image/jpeg" || $imagentipo=="image/png" || $imagentipo=="") {
                    
                    $consulta="UPDATE canciones SET IMAGEN_CANCION=:songimage,TITULO=:title,DESCRIPCION=:description WHERE ID=:idsong";
                    
                    $resultado=$conexion->prepare($consulta);
                    
                    $resultado->execute(array(":songimage"=>$imagen,":title"=>$titulo,":description"=>$descripcion,":idsong"=>$id));
                    
                    $cantidad=$resultado->rowCount();
                    
                    if ($cantidad!=0) {
                        
                        header("location:cuenta.php");
                    }else {
                        
                        echo "<section>";
                        
                        echo "<div class='diverror'>";
                        
                        echo "Error al actualizar la información, intentelo de nuevo";
                        
                        echo "<a href='updatesong.php?idsong=$id'>Volver</a>";
                        
                        echo "</div>";
                        
                        echo "</section>";
                    }
                }else {
                    
                    echo "<section>";
                    
                    echo "<div class='diverror'>";
                    
                    echo "Debe seleccionar una imagen, intentelo de nuevo";
                    
                    echo "<a href='updatesong.php?idsong=$id'>Volver</a>";
                    
                    echo "</div>";
                    
                    echo "</section>";
                }
            }
            
        } catch (Exception $e) {
            
            die("Error: " . $e->getMessage());
        }
    }else {
        
        header("location:index.php");
    }

?>
