<?php 

    if(isset($_POST["envia"])){
    
        try {
            
            $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
            
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $conexion->exec("SET CHARACTER SET utf8");
            
            $correo=addslashes($_POST["correo"]);
            
            $contra=addslashes($_POST["contra"]);
            
            $consulta="SELECT * FROM perfiles WHERE CORREO=:correo AND CONTRASENA=:contra";
            
            $resultado=$conexion->prepare($consulta);
            
            $resultado->execute(array(":correo"=>$correo, ":contra"=>$contra));
            
            $registro=$resultado->rowCount();
            
            if($registro!=0){
                
                session_start();
                
                while($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                    
                    $_SESSION["idusu"]=$fila["ID"];
                    
                    $_SESSION["usuario"]=$fila["USUARIO"];
                    
                    $_SESSION["picture"]=$fila["IMAGEN_PERFIL"];
                    
                    $_SESSION["portada"]=$fila["IMAGEN_PORTADA"];
                    
                    $_SESSION["buscador"]='';
                }
                
                $_SESSION["correo"]=$_POST["correo"];
                
                header("location:indexcreada.php");
            }else{
                
                header("location:iniciosesion.php");
            }
            
        } catch (Exception $e) {
            
            die("Error: " . $e->getMessage());
        }
    }

<<<<<<< HEAD
?>
=======
?>
>>>>>>> e1563e0 (Validación de caracteres en búsqueda y validación de imagenes en crear cuenta)
