<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>LOGIN</title>
        <link href="../style/estilo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center>
            <?php
                include_once 'Class_OperacionesBBDD.php';
                include_once 'Class_OperacionesEXT.php';
                error_reporting(0);
                //Conexion BBDD
                $ObjBBDD=new OperacionesBBDD();
                $ObjBBDD->conectar();
                //Comprobar conexion BBDD
                if ($ObjBBDD->comprobarConexion()) {
                    echo '<h1><span class="error"">Error de conexión: ' . $ObjBBDD->comprobarConexion().'</span></h1>';//Mostrar Error
                    echo "<br><a href='login.php'class='back'>VOLVER</a>";
                }else {
                    echo '<h1>LOGIN</h1>';
                    if (!isset($_POST["ip"]) && !isset($_POST["manual"]) && !isset($_POST["acceder"]) && !isset($_POST['accederip'])) {//formulario tipo de acceso
                        echo '
                            <form action="#" method="post">
                                <input class="btlogin" type="submit" name="ip" value="Acceso Ip" />
                                <input class="btlogin" type="submit" name="manual" value="Acceso Manual" />
                            </form>
                        ';
                    }
                    if (isset($_POST["manual"])) {//formulario acceso manual
                        echo '
                            <form action="#" method="post">
                                <label for="user">Usuario</label>
                                <input type="text" name="user" placeholder="Escribe Usuario" /></br></br>
                                <label for="pass">Contraseña</label>                     
                                <input type="password" name="pass" placeholder="Escribe la Contraseña" /></br></br>
                                <input class="btlogin" type="submit" name="acceder" value="Acceder" />
                            </form>
                        ';
                        echo "<br><a href='login.php'class='back'>VOLVER</a>";
                    }
                    if (isset($_POST["ip"])) {//formulario acceso manual
                        echo '
                            <form action="#" method="post">
                                <label for="user">Direccion IP</label>
                                <input type="text" name="Ip" placeholder="Escribe tu direccion Ip" /></br></br>
                                <input class="btlogin" type="submit" name="accederip" value="Acceder" />
                            </form>
                        ';
                        echo "<br><a href='login.php'class='back'>VOLVER</a>";
                    }
                    if (isset($_POST["accederip"])) {//proceso acceso automatico
                        if(empty($_POST["Ip"])){
                            echo '<span class="error">NO PUEDES DEJAR EN BLANCO ESTE CAMPO</span><br>';//si no existe la maquina
                            echo "<br><a href='login.php'class='back'>VOLVER</a>";
                        }else{
                            $sql = "SELECT * FROM maquina AS m INNER JOIN alumno AS a ON m.IdAlumno = a.IdAlumno  WHERE m.Ip='".$_POST['Ip']."';";//consulta comprobar si existe maquina
                            $resultado=$ObjBBDD->ejecutarConsulta($sql);//ejecuta consulta
                            if($ObjBBDD->filasObtenidas($resultado) != 0) {//comprueba error
                                $fila = $ObjBBDD->extraerFila($resultado);//extrae filas consulta
                                session_start();//inicia sesion y assigna variables sesion
                                $_SESSION["ip"] = $fila["Ip"];
                                $_SESSION["id"] = $fila["IdAlumno"];
                                $_SESSION["jesuita"] = $fila["Jesuita"];
                                $_SESSION["nombre"] = $fila["Nombre"];
                                $_SESSION["lugar"] = $fila["IdLugar"];
                                header("Location:Visitas.php");//redireccion
                            }else {
                                echo '<span class="error">ACCESO INCORRECTO</span><br>';//si no existe la maquina
                                echo "<br><a href='login.php'class='back'>VOLVER</a>";
                            }
                        }
                    }
                    if (isset($_POST["acceder"])) {//proceso acceso manual
                        if(empty($_POST["user"]) || empty($_POST["pass"])){
                            echo '<span class="error">NO PUEDES DEJAR EN BLANCO NINGUN CAMPO</span><br>';//si no existe la maquina
                            echo "<br><a href='login.php'class='back'>VOLVER</a>";
                        }else{
                            $sql = "SELECT * FROM usuario WHERE Usuario = '" . $_POST["user"] . "' ;";//consulta comprobar si existe administrador
                            $resultado=$ObjBBDD->ejecutarConsulta($sql);//ejecuta consulta
                            if($ObjBBDD->filasObtenidas($resultado) != 0) {//comprueba error
                                $fila = $ObjBBDD->extraerFila($resultado);//extrae filas consulta
                                if(comprobarHash($_POST['pass'],$fila['Pass'])){
                                    session_start();//inicia sesion y assigna variables sesion
                                    $_SESSION["id"] = $fila["IdAdmin"];
                                    $_SESSION["usuario"] = $fila["Usuario"];
                                    $_SESSION["tipo"] = $fila["Tipo"];
                                    if ($_SESSION["tipo"]==1){
                                        header("Location:indexAdmin.php");//redirecion
                                    }else{
                                        header("Location:indexProfesor.php");//redirecion
                                    }
                                }
                            }
                            echo '<span class="error">USUARIO O CONTRASEÑA<br>INCORRECTOS</span><br>';//contraseña o usuario incorrecto
                            echo "<br><a href='login.php'class='back'>VOLVER</a>";
                        }
                    }
                }
            ?>
        </center>
    </body>
</html>
