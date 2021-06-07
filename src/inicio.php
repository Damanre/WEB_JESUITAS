<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Instalacion</title>
    </head>
    <body>
        <?php
            require_once "Class_OperacionesBBDD.php";
            require_once "Class_OperacionesEXT.php";
            error_reporting(0);
            $conexion=conectarInstalador();//Conexion BBDD
            if (comprobarConexion($conexion)) {//Comprobar conexion BBDD
                echo '<h1>Error de conexión: ' . $conexion->connect_error.'</h1>';//Mostrar Error
            }else {
                if (!isset($_POST["Instalar"])) {//formulario agregar super admin
                    echo '
                    <center>
                        <h1>INSTALADOR WEB JESUITAS</h1><br><br>
                        <form action="#" method="post">
                            <label for="user">USUARIO ADMINISTRADOR</label>
                            <input type="text" name="user" placeholder="Usuario" /></br></br>
                            <label for="pass">CONTRASEÑA</label>
                            <input type="password" name="pass" placeholder="Contraseña" /></br></br>
                            <label for="pass2">REPETIR CONTRASEÑA</label>
                            <input type="password" name="pass2" placeholder="Repetir Contraseña" /></br></br>
                            <input type="submit" name="Instalar" value="INSTALAR" />
                            <input type="reset" name="Cancelar" value="CANCELAR" />
                        </form>
                    </center>
                ';
                } else {
                    if($_POST['pass'] != $_POST['pass2']){//comprobar que coinciden las contraseñas
                        header('Location:inicio.php');//redireccion
                    }
                    $sql = file_get_contents("../sql/BBDD_Pruebas.sql");//consulta script bbdd
                    ejecutarMultiConsulta($conexion, $sql);//ejecutar consulta
                    if($error=comprobarError($conexion)){//comprobar error
                        echo $error;
                        echo "<br><a href='inicio.php'>VOLVER</a>";
                    }else{
                        echo 'OK';
                        echo "<br><a href='inicio.php'>VOLVER</a>";
                    }
                    cerrarConexion($conexion);//cierre conexion
                    sleep(1.5);//espera para que el servidor ejecute la consulta anterior a tiempo
                    $conexion = conectar();//conexion BBDD
                    $sql = 'INSERT INTO usuario (Usuario,Pass,Tipo) VALUES ("' . $_POST['user'] . '", "' . encriptar($_POST['pass']) . '", 1);';//consulta agregar admin
                    ejecutarConsulta($conexion, $sql);//ejecutar consulta
                    if($error=comprobarError($conexion)){//comprobar error
                        echo $error;
                        echo "<br><a href='inicio.php'>VOLVER</a>";
                    }else{
                        header("Location:login.php");//redireccion
                    }
                    cerrarConexion($conexion);//cerrar conexion
                }
            }
        ?>
    </body>
</html>
