<?php
    session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADD Profesor</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION["usuario"])){
            if ($_SESSION["tipo"]==1){
                require_once "Class_OperacionesBBDD.php";
                require_once "Class_OperacionesEXT.php";
                echo "<br><a href='cerrarSesion.php'>CERRAR SESION</a>";
                echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
                $conexion = conectar();//Conexion BBDD
                if (comprobarConexion($conexion)) {//Comprobar conexion BBDD
                    echo '<h1>Error de conexión: ' . comprobarConexion($conexion) . '</h1>';//Mostrar Error
                } else {
                    if (!isset($_POST["Add"])) {//formulario agregar admin
                        echo '
                            <center>
                                <h1>Añadir Administrador</h1><br><br>
                                <form action="#" method="post">
                                    <label for="user">USUARIO PROFESOR</label>
                                    <input type="text" name="user" placeholder="Usuario" /></br></br>
                                    <label for="pass">CONTRASEÑA</label>
                                    <input type="password" name="pass" placeholder="Contraseña" /></br></br>
                                    <label for="pass2">REPETIR CONTRASEÑA</label>
                                    <input type="password" name="pass2" placeholder="Repetir Contraseña" /></br></br>
                                    <input type="submit" name="Add" value="AÑADIR" />
                                    <input type="reset" name="Cancelar" value="CANCELAR" />
                                </form>
                            </center>
                            ';
                            $sql = "select * from usuario where tipo=0";
                            $resultado=ejecutarConsulta($conexion,$sql);
                            echo '<div>';
                            echo '<h2>Profesores</h2>';
                            if (filasObtenidas($resultado) > 0) {
                                echo '<table>';
                                echo '<tr>';
                                echo '<th>Nombre</th>';
                                while ($fila = extraerFila($resultado)) {
                                    echo '<tr><td>' . $fila["Usuario"] . '</td><td>BORRAR</td></tr>';
                                }
                                echo '</tr>';
                                echo '</table>';
                            } else {
                                echo ' No hay Profesores';
                            }
                            echo "<br><a href='indexAdmin.php'>VOLVER</a>";
                    } else {
                        if ($_POST['pass'] != $_POST['pass2']) {//comprobar que coinciden las contraseñas
                            echo 'NO COINCIDEN LAS CONTRASEÑAS';
                            echo "<br><a href='addProfesor.php'>VOLVER</a>";
                        }else{
                           $sql = 'INSERT INTO usuario (Usuario,Pass) VALUES ("' . $_POST['user'] . '", "' . encriptar($_POST['pass']) . '");';//consulta añadir administrador
                            ejecutarConsulta($conexion, $sql);//ejecutar consulta
                            if ($error = comprobarError($conexion)) {//comprobar error
                                echo $error;
                                echo "<br><a href='addMaquina.php'>VOLVER</a>";
                            } else {
                                header("LOCATION:addProfesor.php");
                            }
                        }

                    }
                }
            }else{
                echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                    <br><a href="login.php">VOLVER</a>
                ';
            }
        }else{
            echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                <br><a href="login.php">VOLVER</a>
            ';
        }
        ?>
    </body>
</html>
