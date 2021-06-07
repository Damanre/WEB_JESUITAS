<?php
    session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADD LUGARES</title>
    </head>
    <body>
        <?php
            if (isset($_SESSION["usuario"])) {
                require_once "Class_OperacionesBBDD.php";
                echo "<br><a href='cerrarSesion.php'>CERRAR SESION</a>";
                echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
                $conexion = conectar();//Conexion BBDD
                if (comprobarConexion($conexion)) {//Comprobar conexion BBDD
                    echo '<h1>Error de conexión: ' . $conexion->connect_error . '</h1>';//Mostrar Error
                } else {
                    if (!isset($_POST["Add"])) {//formulario agregar lugar
                        echo '
                            <center>
                                <h1>AÑADIR LUGAR</h1><br><br>
                                <form action="#" method="post">
                                    <label for="nombre">LUGAR</label>
                                    <input type="text" name="nombre" placeholder="Nombre Lugar" /></br></br>
                                    <input type="submit" name="Add" value="AÑADIR" />
                                    <input type="reset" name="Cancelar" value="CANCELAR" />
                                </form>
                            </center>
                            ';
                        $sql = "select * from lugar";
                        $resultado=ejecutarConsulta($conexion,$sql);
                        echo '<div>';
                        echo '<h2>Lugares</h2>';
                        if (filasObtenidas($resultado) > 0) {
                            echo '<table>';
                            echo '<tr>';
                            echo '<th>Nombre</th>';
                            while ($fila = extraerFila($resultado)) {
                                echo '<tr><td>' . $fila["Nombre"] . '</td><td>BORRAR</td><td>EDITAR</td></tr>';
                            }
                            echo '</tr>';
                            echo '</table>';
                        } else {
                            echo ' No hay Lugares';
                        }
                        if ($_SESSION["tipo"]==1){
                            echo "<br><a href='indexAdmin.php'>VOLVER</a>";
                        }else{
                            echo "<br><a href='indexProfesor.php'>VOLVER</a>";
                        }
                    } else {
                        $sql = 'INSERT INTO lugar (Nombre) VALUES ("' . $_POST['nombre'] . '");';//consulta agregar lugar
                        ejecutarConsulta($conexion, $sql);//ejecutar consulta
                        if ($error = comprobarError($conexion)) {//comprobar error
                            echo $error;
                            echo "<br><a href='addLugares.php'>VOLVER</a>";
                        } else {
                            header("LOCATION:addLugares.php");
                        }
                    }
                }
            }else{
                echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                    <br><a href="login.php">VOLVER</a>
                ';
            }
        ?>
    </body>
</html>
