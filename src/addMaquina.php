<?php
session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADD MAQUINA</title>
        <link href="../style/estilo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center>
            <?php
                if (isset($_SESSION["usuario"])) {
                    require_once "Class_OperacionesBBDD.php";
                    require_once 'Class_OperacionesEXT.php';
                    echo "<br><a class='logout' href='cerrarSesion.php'class='logout'>CERRAR SESION</a>";
                    echo "<h1>Hola " . $_SESSION["usuario"] . "</h1>";
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
                            echo '
                                <center>
                                    <h1>AÑADIR MAQUINA</h1><br>
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
                                        <input class="opc" type="submit" name="Add" value="AÑADIR" />
                                        <input class="opc" type="reset" name="Cancelar" value="CANCELAR" />
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
                                    echo '<tr><td>' . $fila["Ip"] . '</td><td>' . $fila["Lugar"] . '</td><td>' . $fila["Alumno"] . '</td><td><a href="delMaquinas.php?ip='.$fila["Ip"].'"><img class="del" src="../style/imagenes/del.png"></a></td><td><a href="modMaquina.php?ip='.$fila["Ip"].'"><img class="del" src="../style/imagenes/mod.png"></a></td></tr>';
                                }
                                echo '</tr>';
                                echo '</table>';
                            } else {
                                echo 'No hay Maquinas';
                            }
                            echo '</div>';
                            if ($_SESSION["tipo"]==1){
                                echo "<br><a class='back' href='indexAdmin.php'>VOLVER</a>";
                            }else{
                                echo "<br><a class='back' href='indexProfesor.php'>VOLVER</a>";
                            }
                        } else {
                            if(empty($_POST["ip"]) || empty($_POST["lugar"]) || empty($_POST["alumno"])){
                                echo '<span class="error">NO PUEDES DEJAR EN BLANCO NINGUN CAMPO</span><br>';//si no existe la maquina
                                echo "<br><a href='addMaquina.php'class='back'>VOLVER</a>";
                            }else{
                                $sql = 'INSERT INTO maquina (Ip, IdLugar, IdAlumno) VALUES ("' . $_POST['ip'] . '","' . $_POST['lugar'] . '","' . $_POST['alumno'] . '");';//consulta agregar maquina
                                $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
                                if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                                    echo $error;
                                    echo "<br><a class='back' href='addMaquina.php'>VOLVER</a>";
                                } else {
                                    header("LOCATION:addMaquina.php");
                                }
                            }
                        }
                    }
                }else{
                    echo '<span class="error">NO PUEDES ACCEDER A ESTE SITIO</span>
                    <br><a class="back" href="login.php">VOLVER</a>
                    ';
                }
            ?>
        </center>
    </body>
</html>

