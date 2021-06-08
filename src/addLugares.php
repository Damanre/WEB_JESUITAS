<?php
session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <title>ADD LUGAR</title>
    <link href="../style/estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
<center>
    <body>
        <?php
            if (isset($_SESSION["usuario"])) {
                require_once "Class_OperacionesBBDD.php";
                echo "<br><a class='logout' href='cerrarSesion.php'class='logout'>CERRAR SESION</a>";
                echo "<h1>Hola " . $_SESSION["usuario"] . "</h1>";
                $ObjBBDD=new OperacionesBBDD();
                $ObjBBDD->conectar();//Conexion BBDD
                if ($ObjBBDD->comprobarConexion()) {//Comprobar conexion BBDD
                    echo '<h1>Error de conexión: ' . $ObjBBDD->comprobarConexion() . '</h1>';//Mostrar Error
                } else {
                    if (!isset($_POST["Add"])) {//formulario agregar lugar
                        echo '
                            <center>
                                <h1>AÑADIR LUGAR</h1><br><br>
                                <form action="#" method="post">
                                    <label for="nombre">LUGAR</label>
                                    <input type="text" name="nombre" placeholder="Nombre Lugar" /></br></br>
                                    <input class="opc" type="submit" name="Add" value="AÑADIR" />
                                    <input class="opc" type="reset" name="Cancelar" value="CANCELAR" />
                                </form>
                            </center>
                            ';
                        $sql = "select * from lugar";
                        $resultado=$ObjBBDD->ejecutarConsulta($sql);
                        echo '<div>';
                        echo '<h2>Lugares</h2>';
                        if ($ObjBBDD->filasObtenidas($resultado) > 0) {
                            echo '<table>';
                            echo '<tr>';
                            echo '<th>Nombre</th>';
                            while ($fila = $ObjBBDD->extraerFila($resultado)) {
                                echo '<tr><td>' . $fila["Nombre"] . '</td><td><a href="delLugares.php?lugar='.$fila["Nombre"].'"><img class="del" src="../style/imagenes/del.png"></a></td></tr>';
                            }
                            echo '</tr>';
                            echo '</table>';
                        } else {
                            echo ' No hay Lugares';
                        }
                        if ($_SESSION["tipo"]==1){
                            echo "<br><a class='back' href='indexAdmin.php'>VOLVER</a>";
                        }else{
                            echo "<br><a class='back' href='indexProfesor.php'>VOLVER</a>";
                        }
                    } else {
                        if(empty($_POST["nombre"])){
                            echo '<span class="error">NO PUEDES DEJAR EN BLANCO ESTE CAMPO</span><br>';//si no existe la maquina
                            echo "<br><a href='addLugares.php'class='back'>VOLVER</a>";
                        }else{
                            $sql = 'INSERT INTO lugar (Nombre) VALUES ("' . $_POST['nombre'] . '");';//consulta agregar lugar
                            $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
                            if ($ObjBBDD->comprobarError()) {//comprobar error
                                echo $ObjBBDD->comprobarError();
                                echo "<br><a class='back' href='addLugares.php'>VOLVER</a>";
                            } else {
                                header("LOCATION:addLugares.php");
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
    </body>
</html>
