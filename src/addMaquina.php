<?php
    session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADD MAQUINA</title>
    </head>
    <body>
        <?php
            if (isset($_SESSION["usuario"])) {
                require_once "Class_OperacionesBBDD.php";
                require_once 'Class_OperacionesEXT.php';
                echo "<br><a href='cerrarSesion.php'>CERRAR SESION</a>";
                echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
                $ObjBBDD=new OperacionesBBDD();
                $ObjBBDD->conectar();//Conexion BBDD
                if ($ObjBBDD->comprobarConexion()) {//Comprobar conexion BBDD
                    echo '<h1>Error de conexión: ' . $ObjBBDD->comprobarConexion() . '</h1>';//Mostrar Error
                } else {
                    if (!isset($_POST["Add"])) {//formulario agregar maquina
                        $sql = "SELECT * FROM lugar;";
                        $resultado = $ObjBBDD->ejecutarConsulta($sql);
                        $sql2 = "SELECT * FROM alumno;";
                        $resultado2 = $ObjBBDD->ejecutarConsulta($sql2);
                        echo getIp();
                        echo '
                            <center>
                                <h1>AÑADIR MAQUINA</h1><br><br>
                                <form action="#" method="post">
                                    <label for="ip">IP</label>
                                    <input type="text" name="ip" placeholder="Direccion IP" /></br></br>
                                    <label for="lugar">LUGAR</label>
                                    <select name="lugar">
                                        ';//desplegable lugares
                        while ($fila = $ObjBBDD->extraerFila($resultado)) {
                            echo '<option value="' . $fila['IdLugar'] . '">' . $fila['Nombre'] . '</option>';
                        }
                        echo '
                                    </select></br></br>
                                    <label for="alumno">ALUMNO</label>
                                    <select name="alumno">
                                        ';//desplegable alumnos
                        while ($fila = $ObjBBDD->extraerFila($resultado2)) {
                            echo '<option value="' . $fila['IdAlumno'] . '">' . $fila['Nombre'] . ' ' . $fila['Apellidos'] . '</option>';
                        }
                        echo '
                                    </select></br></br>
                                    <input type="submit" name="Add" value="AÑADIR" />
                                    <input type="reset" name="Cancelar" value="CANCELAR" />
                                </form>
                            </center>
                            ';
                        $sql = "select m.Ip,l.Nombre as Lugar, a.Nombre as Alumno from maquina m INNER JOIN lugar l ON m.IdLugar=l.IdLugar INNER JOIN alumno a ON m.IdAlumno=a.IdAlumno";
                        $resultado=$ObjBBDD->ejecutarConsulta($sql);
                        echo '<div>';
                        echo '<h2>Maquinas</h2>';
                        if ($ObjBBDD->filasObtenidas($resultado) > 0) {
                            echo '<table>';
                            echo '<tr>';
                            echo '<th>IP</th><th>Lugar</th><th>Alumno</th>';
                            while ($fila = $ObjBBDD->extraerFila($resultado)) {
                                echo '<tr><td>' . $fila["Ip"] . '</td><td>' . $fila["Lugar"] . '</td><td>' . $fila["Alumno"] . '</td><td><a href="delMaquinas.php?ip='.$fila["Ip"].'">BORRAR</a></td><td>EDITAR</td></tr>';
                            }
                            echo '</tr>';
                            echo '</table>';
                        } else {
                            echo ' No hay Maquinas';
                        }
                        echo '</div>';
                        if ($_SESSION["tipo"]==1){
                            echo "<br><a href='indexAdmin.php'>VOLVER</a>";
                        }else{
                            echo "<br><a href='indexProfesor.php'>VOLVER</a>";
                        }
                    } else {
                        $sql = 'INSERT INTO maquina (Ip, IdLugar, IdAlumno) VALUES ("' . $_POST['ip'] . '","' . $_POST['lugar'] . '","' . $_POST['alumno'] . '");';//consulta agregar maquina
                        $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
                        if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                            echo $error;
                            echo "<br><a href='addMaquina.php'>VOLVER</a>";
                        } else {
                            header("LOCATION:addMaquina.php");
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

