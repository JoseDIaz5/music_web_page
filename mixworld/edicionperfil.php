<?php

    session_start();
    
    if (isset($_SESSION["idusu"])) {
        
        try {
            
            $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
            
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $conexion->exec("SET CHARACTER SET utf8");
            
            if ($_FILES["imagenperfil"]["name"]=='' && $_FILES["contportada"]["name"]=='') {
                
                $perfildefecto=$_POST["profileimg"];
                
                $portadadefecto=$_POST["portadaimg"];
            }
            elseif ($_FILES["imagenperfil"]["name"]!='' && $_FILES["contportada"]["name"]==''){
                
                $portadadefecto=$_POST["portadaimg"];
                
                $perfil=$_FILES["imagenperfil"]["name"];
                
                $perfiltipo=$_FILES["imagenperfil"]["type"];
            }
            elseif ($_FILES["imagenperfil"]["name"]=='' && $_FILES["contportada"]["name"]!=''){
                
                $perfildefecto=$_POST["profileimg"];
                
                $portada=$_FILES["contportada"]["name"];
                
                $portadatipo=$_FILES["contportada"]["type"];
            }else {
                
                $perfil=$_FILES["imagenperfil"]["name"];
                
                $perfiltipo=$_FILES["imagenperfil"]["type"];
                
                $portada=$_FILES["contportada"]["name"];
                
                $portadatipo=$_FILES["contportada"]["type"];
                
                $carpetaimg=$_SERVER["DOCUMENT_ROOT"] . "/MIXWORLD/intranet/perfiles/";
            }
            
            if ($_POST["facebook"]=='') {
                
                $facebook='';
            }else {
                
                $facebook=$_POST["facebook"];
            }
            if ($_POST["instagram"]=='') {
                
                $instagram='';
            }else {
                
                $instagram=$_POST["instagram"];
            }
            if ($_POST["twitter"]=='') {
                
                $x='';
            }else {
                
                $x=$_POST["twitter"];
            }
            
            $usuario=$_POST["usuario"];
            
            $id=$_POST["id"];
            
            if (isset($perfiltipo) && isset($portadatipo)) {
                
                if ($perfiltipo=="image/jpg" || $perfiltipo=="image/png" || $perfiltipo=="image/jpeg" || $perfiltipo=="image/gif") {
                    
                    if ($portadatipo=="image/jpg" || $portadatipo=="image/png" || $portadatipo=="image/jpeg" || $portadatipo=="image/gif") {
                        
                        move_uploaded_file($_FILES["imagenperfil"]["tmp_name"], $carpetaimg.$perfil);
                        
                        move_uploaded_file($_FILES["contportada"]["tmp_name"], $carpetaimg.$portada);
                        
                        $consulta="UPDATE perfiles SET USUARIO=:user,IMAGEN_PERFIL=:perfil,IMAGEN_PORTADA=:portada,USUARIO_FACEBOOK=:face,USUARIO_INSTAGRAM=:insta,USUARIO_X=:xuser WHERE ID=:id";
                        
                        $resultado=$conexion->prepare($consulta);
                        
                        $resultado->execute(array(":user"=>$usuario,":perfil"=>$perfil,":portada"=>$portada,":face"=>$facebook,":insta"=>$instagram,":xuser"=>$x,":id"=>$id));
                        
                        $cantidad=$resultado->rowCount();
                        
                        if ($cantidad!=0) {
                            
                            header("location:cuenta.php");
                        }else {
                            
                            echo "<body>";
                            
                            echo "<div class='diverror'>";
                            
                            echo "Error al actualizar la información, intentelo de nuevo";
                            
                            echo "<a href='editarperfil.php?id=$id'>Volver</a>";
                            
                            echo "</div>";
                            
                            echo "</body>";
                        }
                    }else {
                        
                        header("location:editarperfil.php?id=$id");
                    }
                }else {
                    
                    header("location:editarperfil.php?id=$id");
                }
            }
            elseif (!isset($perfiltipo) && isset($portadatipo)){
                
                if ($portadatipo=="image/jpg" || $portadatipo=="image/png" || $portadatipo=="image/jpeg" || $portadatipo=="image/gif") {
                    
                    move_uploaded_file($_FILES["contportada"]["tmp_name"], $carpetaimg.$portada);
                    
                    $consulta="UPDATE perfiles SET USUARIO=:user,IMAGEN_PERFIL=:perfil,IMAGEN_PORTADA=:portada,USUARIO_FACEBOOK=:face,USUARIO_INSTAGRAM=:insta,USUARIO_X=:xuser WHERE ID=:id";
                    
                    $resultado=$conexion->prepare($consulta);
                    
                    $resultado->execute(array(":user"=>$usuario,":perfil"=>$perfildefecto,":portada"=>$portada,":face"=>$facebook,":insta"=>$instagram,":xuser"=>$x,":id"=>$id));
                    
                    $cantidad=$resultado->rowCount();
                    
                    if ($cantidad!=0) {
                        
                        header("location:cuenta.php");
                    }else {
                        
                        echo "<body>";
                        
                        echo "<div class='diverror'>";
                        
                        echo "Error al actualizar la información, intentelo de nuevo";
                        
                        echo "<a href='editarperfil.php?id=$id'>Volver</a>";
                        
                        echo "</div>";
                        
                        echo "</body>";
                    }
                }else {
                    
                    header("location:editarperfil.php?id=$id");
                }
            }
            elseif (isset($perfiltipo) && !isset($portadatipo)){
                
                if ($perfiltipo=="image/jpg" || $perfiltipo=="image/png" || $perfiltipo=="image/jpeg" || $perfiltipo=="image/gif") {
                    
                    move_uploaded_file($_FILES["imagenperfil"]["tmp_name"], $carpetaimg.$perfil);
                    
                    $consulta="UPDATE perfiles SET USUARIO=:user,IMAGEN_PERFIL=:perfil,IMAGEN_PORTADA=:portada,USUARIO_FACEBOOK=:face,USUARIO_INSTAGRAM=:insta,USUARIO_X=:xuser WHERE ID=:id";
                    
                    $resultado=$conexion->prepare($consulta);
                    
                    $resultado->execute(array(":user"=>$usuario,":perfil"=>$perfil,":portada"=>$portadadefecto,":face"=>$facebook,":insta"=>$instagram,":xuser"=>$x,":id"=>$id));
                    
                    $cantidad=$resultado->rowCount();
                    
                    if ($cantidad!=0) {
                        
                        header("location:cuenta.php");
                    }else {
                        
                        echo "<body>";
                        
                        echo "<div class='diverror'>";
                        
                        echo "Error al actualizar la información, intentelo de nuevo";
                        
                        echo "<a href='editarperfil.php?id=$id'>Volver</a>";
                        
                        echo "</div>";
                        
                        echo "</body>";
                    }
                }
            }else {
                
                $consulta="UPDATE perfiles SET USUARIO=:user,IMAGEN_PERFIL=:perfil,IMAGEN_PORTADA=:portada,USUARIO_FACEBOOK=:face,USUARIO_INSTAGRAM=:insta,USUARIO_X=:xuser WHERE ID=:id";
                
                $resultado=$conexion->prepare($consulta);
                
                $resultado->execute(array(":user"=>$usuario,":perfil"=>$perfildefecto,":portada"=>$portadadefecto,":face"=>$facebook,":insta"=>$instagram,":xuser"=>$x,":id"=>$id));
                
                $cantidad=$resultado->rowCount();
                
                if ($cantidad!=0) {
                    
                    header("location:cuenta.php");
                }else {
                    
                    echo "<body>";
                    
                    echo "<div class='diverror'>";
                    
                    echo "Error al actualizar la información, intentelo de nuevo";
                    
                    echo "<a href='editarperfil.php?id=$id'>Volver</a>";
                    
                    echo "</div>";
                    
                    echo "</body>";
                }
            }
            
        } catch (Exception $e) {
            
            die("Error: " . $e->getMessage());
        }
        
    }else {
        
        header("location:index.php");
    }

?>