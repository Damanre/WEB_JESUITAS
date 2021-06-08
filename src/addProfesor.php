<?php
session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADD PROFESOR</title>
        <link href="../style/estilo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center>
            <?php
                if (isset($_SESSION["usuario"])){
                    if ($_SESSION["tipo"]==1){
                        require_once "Class_OperacionesBBDD.php";
                        require_once "Class_OperacionesEXT.php";
                        echo "<br><a href='cerrarSesion.php'class='logout'>CERRAR SESION</a>";
                        echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
                        $ObjBBDD=new OperacionesBBDD();
                        $ObjBBDD->conectar();//Conexion BBDD
                        if ($ObjBBDD->comprobarConexion()) {//Comprobar conexion BBDD
                            echo '<h1>Error de conexión: ' . $ObjBBDD->comprobarConexion() . '</h1>';//Mostrar Error
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
                                            <input type="submit" class="opc" name="Add" value="AÑADIR" />
                                        </form>
                                    </center>
                                    ';
                                    $sql = "select * from usuario where tipo=0";
                                    $resultado=$ObjBBDD->ejecutarConsulta($sql);
                                    echo '<div>';
                                    echo '<h2>Profesores</h2>';
                                    if ($ObjBBDD->filasObtenidas($resultado) > 0) {
                                        echo '<table>';
                                        echo '<tr>';
                                        echo '<th>Nombre</th>';
                                        while ($fila = $ObjBBDD->extraerFila($resultado)) {
                                            echo '<tr><td>' . $fila["Usuario"] . '</td><td><a href="delProfesor.php?id='.$fila["IdUser"].'"><img class="del" src="../style/imagenes/del.png"></a></td></tr>';
                                        }
                                        echo '</tr>';
                                        echo '</table>';
                                    } else {
                                        echo ' No hay Profesores';
                                    }
                                    echo "<br><a href='indexAdmin.php'class='back'>VOLVER</a>";
                            } else {
                                if(empty($_POST["user"]) || empty($_POST["pass"]) || empty($_POST["pass2"])){
                                    echo '<span class="error">NO PUEDES DEJAR EN BLANCO NINGUN CAMPO</span><br>';//si no existe la maquina
                                    echo "<br><a href='addProfesor.php'class='back'>VOLVER</a>";
                                }else{
                                    if ($_POST['pass'] != $_POST['pass2']) {//comprobar que coinciden las contraseñas
                                        echo '<span class="error">NO COINCIDEN LAS CONTRASEÑAS</span><br>';//si no existe la maquina
                                        echo "<br><a href='addProfesor.php'class='back'>VOLVER</a>";
                                    }else{
                                        $sql = 'INSERT INTO usuario (Usuario,Pass) VALUES ("' . $_POST['user'] . '", "' . encriptar($_POST['pass']) . '");';//consulta añadir administrador
                                        $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
                                        if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                                            echo $error;
                                            echo "<br><a href='addProfesor.php'class='back'>VOLVER</a>";
                                        } else {
                                            header("LOCATION:addProfesor.php");
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        echo '<span class="error">NO PUEDES ACCEDER A ESTE SITIO</span>
                            <br><a href="login.php"class="back">VOLVER</a>
                        ';
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
