<?php

    
    
    if(isset($_POST["subedatos"])){
        
        $contrasena=addslashes($_POST["contra"]);
        
        $contrasenados=addslashes($_POST["confirmar"]);
        
        if($contrasena==$contrasenados){
            
            try{
                
                $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
                
                $conexion->exec("SET CHARACTER SET utf8");
                
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $imgperfil=$_FILES["imagenperfil"]["name"];
                
                $imgportada=$_FILES["contportada"]["name"];
                
                $carpeta=$_SERVER["DOCUMENT_ROOT"] . "/MIXWORLD/intranet/perfiles/";
                
                $usuario=addslashes($_POST["usuario"]);
                
                $correo=addslashes($_POST["correo"]);
                
                $contra=addslashes($_POST["contra"]);
                
                move_uploaded_file($_FILES["imagenperfil"]["tmp_name"], $carpeta.$imgperfil);
                
                move_uploaded_file($_FILES["contportada"]["tmp_name"], $carpeta.$imgportada);
                
                $consulta="INSERT INTO perfiles(USUARIO,CORREO,CONTRASENA,IMAGEN_PERFIL,IMAGEN_PORTADA) VALUES(:usuario,:correo,:contra,:perfil,:portada)";
                
                $resultado=$conexion->prepare($consulta);
                
                $resultado->execute(array(":usuario"=>$usuario, ":correo"=>$correo, ":contra"=>$contra, ":perfil"=>$imgperfil, ":portada"=>$imgportada));
                
                $consultados="SELECT MAX(ID) AS ID FROM perfiles";
                
                $resultados=$conexion->prepare($consultados);
                
                $resultados->execute();
                
                $registro=$resultado->rowCount();
                
                if($registro!=0){
                    
                    session_start();
                    
                    $_SESSION["usuario"]=$_POST["usuario"];
                    
                    $_SESSION["picture"]=$_FILES["imagenperfil"]["name"];
                    
                    $_SESSION["portada"]=$_FILES["contportada"]["name"];
                    
                    header("location:indexcreada.php");
                }
                while($fila=$resultados->fetch(PDO::FETCH_ASSOC)){
                    
                    $_SESSION["idusu"]=$fila["ID"];
                }
                
            }catch(Exception $e){
                
                die("Error" . $e->getMessage());
            }
        }else {
            
            header("location:crearcuenta.php");
        }
    }

?>