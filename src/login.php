<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Iniciar Sesión</title>
    </head>
    <body>
        <?php
            include_once 'Class_OperacionesBBDD.php';
            include_once 'Class_OperacionesEXT.php';
            error_reporting(0);
            //Conexion BBDD
            $conexion = conectar();
            //Comprobar conexion BBDD
            if (comprobarConexion($conexion)) {
                echo '<h1>Error de conexión: ' . comprobarConexion($conexion).'</h1>';//Mostrar Error
                echo "<br><a href='login.php'>VOLVER</a>";
            }else {
                if (!isset($_POST["auto"]) && !isset($_POST["manual"]) && !isset($_POST["acceder"])) {//formulario tipo de acceso
                    echo '
                        <form action="#" method="post">
                            <input type="submit" name="auto" value="Acceso Automatico" />
                            <input type="submit" name="manual" value="Acceso Manual" />
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
                            <input type="submit" name="acceder" value="Acceder" />
                            <input type="reset" name="cancelar" value="Cancelar" />
                        </form>
                    ';
                    echo "<br><a href='login.php'>VOLVER</a>";
                }
                if (isset($_POST["auto"])) {//proceso acceso automatico
                    $sql = "SELECT * FROM maquina AS m INNER JOIN alumno AS a ON m.IdAlumno = a.IdAlumno  WHERE m.Ip='".getIp()."';";//consulta comprobar si existe maquina
                    $resultado=ejecutarConsulta($conexion, $sql);//ejecuta consulta
                    if(filasObtenidas($resultado) != 0) {//comprueba error
                        $fila = extraerFila($resultado);//extrae filas consulta
                        session_start();//inicia sesion y assigna variables sesion
                        $_SESSION["ip"] = $fila["Ip"];
                        $_SESSION["id"] = $fila["IdAlumno"];
                        $_SESSION["jesuita"] = $fila["Jesuita"];
                        $_SESSION["nombre"] = $fila["Nombre"];
                        $_SESSION["lugar"] = $fila["IdLugar"];
                        header("Location:indexUser.php");//redireccion
                    }else {
                        echo '<h1>NO PUEDES ACCEDER DESDE ESTE EQUIPO</h1>';//si no existe la maquina
                        echo "<br><a href='login.php'>VOLVER</a>";
                    }
                }
                if (isset($_POST["acceder"])) {//proceso acceso manual
                    $sql = "SELECT * FROM usuario WHERE Usuario = '" . $_POST["user"] . "' ;";//consulta comprobar si existe administrador
                    $resultado=ejecutarConsulta($conexion, $sql);//ejecuta consulta
                    if(filasObtenidas($resultado) != 0) {//comprueba error
                        $fila = extraerFila($resultado);//extrae filas consulta
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
                    printf('Usuario o contraseña incorrectos');//contraseña o usuario incorrecto
                    echo "<br><a href='login.php'>VOLVER</a>";
                }
            }
        ?>
    </body>
</html>
