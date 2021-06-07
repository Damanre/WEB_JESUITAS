<?php
    session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADD ALUMNO</title>
    </head>
    <body>
        <?php
            if (isset($_SESSION["usuario"])) {
                require_once "Class_OperacionesBBDD.php";
                echo "<br><a href='cerrarSesion.php'>CERRAR SESION</a>";
                echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
                $conexion = conectar();//Conexion BBDD
                if (comprobarConexion($conexion)) {//Comprobar conexion BBDD
                    echo '<h1>Error de conexión: ' . comprobarConexion($conexion) . '</h1>';//Mostrar Error
                } else {
                    if (!isset($_POST["Add"])) {//formulario agregar alumno
                        echo '
                            <center>
                                <h1>AÑADIR ALUMNO</h1><br><br>
                                <form action="#" method="post">
                                    <label for="nombre">NOMBRE ALUMNO</label>
                                    <input type="text" name="nombre" placeholder="Nombre Alumno" /></br></br>
                                    <label for="apellidos">APELLIDOS</label>
                                    <input type="text" name="apellidos" placeholder="Apellidos Alumno" /></br></br>
                                    <input type="submit" name="Add" value="AÑADIR" />
                                    <input type="reset" name="Cancelar" value="CANCELAR" />
                                </form>
                            </center>
                        ';
                        $sql = "select * from alumno";
                        $resultado=ejecutarConsulta($conexion,$sql);
                        echo '<div>';
                        echo '<h2>Alumnos</h2>';
                        if (filasObtenidas($resultado) > 0) {
                            echo '<table>';
                            echo '<tr>';
                            echo '<th>Nombre</th><th>Apellidos</th>';
                            while ($fila = extraerFila($resultado)) {
                                echo '<tr><td>' . $fila["Nombre"] . '</td><td>' . $fila["Apellidos"] . '</td><td>BORRAR</td><td>EDITAR</td></tr>';
                            }
                            echo '</tr>';
                            echo '</table>';
                        } else {
                            echo ' No hay Alumnos';
                        }
                        if ($_SESSION["tipo"]==1){
                            echo "<br><a href='indexAdmin.php'>VOLVER</a>";
                        }else{
                            echo "<br><a href='indexProfesor.php'>VOLVER</a>";
                        }   
                    } else {
                        $sql = 'INSERT INTO alumno (Nombre, Apellidos) VALUES ("' . $_POST['nombre'] . '","' . $_POST['apellidos'] . '");';//consulta añadir alumno
                        ejecutarConsulta($conexion, $sql);//ejecutar consulta
                        if ($error = comprobarError($conexion)) {//Comprobar error
                            echo $error;
                            echo "<br><a href='addAlumno.php'>VOLVER</a>";
                        } else {
                            header("LOCATION:addAlumno.php");
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
