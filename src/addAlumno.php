<?php
session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADD ALUMNO</title>
        <link href="../style/estilo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center>
            <?php
                if (isset($_SESSION["usuario"])) {
                    require_once "Class_OperacionesBBDD.php";
                    echo "<br><a href='cerrarSesion.php'class='logout'>CERRAR SESION</a>";
                    echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
                    $ObjBBDD=new OperacionesBBDD();
                    $ObjBBDD->conectar();//Conexion BBDD
                    if ($ObjBBDD->comprobarConexion()) {//Comprobar conexion BBDD
                        echo '<span class="error">Error de conexión: ' . $ObjBBDD->comprobarConexion() . '</span>';//Mostrar Error
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
                                        <input type="submit" class="opc" name="Add" value="AÑADIR" />
                                    </form>
                                </center>
                            ';
                            $sql = "select * from alumno";
                            $resultado=$ObjBBDD->ejecutarConsulta($sql);
                            echo '<div>';
                            echo '<h2>Alumnos</h2>';
                            if ($ObjBBDD->filasObtenidas($resultado) > 0) {
                                echo '<table>';
                                echo '<tr>';
                                echo '<th>Nombre</th><th>Apellidos</th>';
                                while ($fila = $ObjBBDD->extraerFila($resultado)) {
                                    echo '<tr><td>' . $fila["Nombre"] . '</td><td>' . $fila["Apellidos"] . '</td><td><a href="delAlumno.php?id='.$fila["IdAlumno"].'"><img class="del" src="../style/imagenes/del.png"></a></td></tr>';
                                }
                                echo '</tr>';
                                echo '</table>';
                            } else {
                                echo ' No hay Alumnos';
                            }
                            if ($_SESSION["tipo"]==1){
                                echo "<br><a href='indexAdmin.php'class='back'>VOLVER</a>";
                            }else{
                                echo "<br><a href='indexProfesor.php'class='back'>VOLVER</a>";
                            }
                        } else {
                            if(empty($_POST["nombre"]) || empty($_POST["apellidos"])){
                                echo '<span class="error">NO PUEDES DEJAR EN BLANCO NINGUN CAMPO</span><br>';//si no existe la maquina
                                echo "<br><a href='addAlumno.php'class='back'>VOLVER</a>";
                            }else{
                                $sql = 'INSERT INTO alumno (Nombre, Apellidos) VALUES ("' . $_POST['nombre'] . '","' . $_POST['apellidos'] . '");';//consulta añadir alumno
                                $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
                                if ($error = $ObjBBDD->comprobarError()) {//Comprobar error
                                    echo $error;
                                    echo "<br><a href='addAlumno.php'class='back'>VOLVER</a>";
                                } else {
                                    header("LOCATION:addAlumno.php");
                                }
                            }
                        }
                    }
                }else{
                    echo '<span class="error">NO PUEDES ACCEDER A ESTE SITIO</span>
                        <br><a href="login.php"class="back">VOLVER</a>
                    ';
                }
            ?>
        </center>
    </body>
</html>
