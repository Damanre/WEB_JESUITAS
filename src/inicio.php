<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <title>INSTALACION</title>
    <link href="../style/estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
<center>
        <?php
            require_once "Class_OperacionesBBDD.php";
            require_once "Class_OperacionesEXT.php";
            error_reporting(0);
            $ObjBBDD=new OperacionesBBDD();
            $ObjBBDD->conectarInstalador();//Conexion BBDD
            if ($ObjBBDD->comprobarConexion()) {//Comprobar conexion BBDD
                echo '<span class="error">Error de conexión: ' . $ObjBBDD->comprobarConexion().'</span>';//Mostrar Error
                echo "<br><a href='inicio.php'class='back'>VOLVER</a>";
            }else {
                if (!isset($_POST["Instalar"])) {//formulario agregar super admin
                    echo '
                    <center>
                        <h1>INSTALADOR WEB JESUITAS</h1><br><br>
                        <form action="#" method="post">
                            <label for="user">USUARIO ADMINISTRADOR</label>
                            <input type="text" name="user" placeholder="Usuario" /></br></br>
                            <label for="pass">CONTRASEÑA</label>
                            <input type="password" name="pass" placeholder="Contraseña" /></br></br>
                            <label for="pass2">REPETIR CONTRASEÑA</label>
                            <input type="password" name="pass2" placeholder="Repetir Contraseña" /></br></br>
                            <input type="submit" class="opc" name="Instalar" value="INSTALAR" />
                            <input type="reset" class="opc" name="Cancelar" value="CANCELAR" />
                        </form>
                    </center>
                ';
                } else {
                    if(empty($_POST["user"]) || empty($_POST["pass"]) || empty($_POST["pass2"])){
                        echo '<span class="error">NO PUEDES DEJAR EN BLANCO NINGUN CAMPO</span><br>';//si no existe la maquina
                        echo "<br><a href='inicio.php'class='back'>VOLVER</a>";
                    }else{
                        if($_POST['pass'] != $_POST['pass2']){//comprobar que coinciden las contraseñas
                            echo '<span class="error">NO COINCIDEN LAS CONTRASEÑAS</span><br>';//si no existe la maquina
                            echo "<br><a href='inicio.php'class='back'>VOLVER</a>";
                        }
                        $sql = file_get_contents("../sql/BBDD_Pruebas.sql");//consulta script bbdd
                        $ObjBBDD->ejecutarMultiConsulta($sql);//ejecutar consulta
                        if($ObjBBDD->comprobarError()) {//comprobar error
                            echo $ObjBBDD->comprobarError();
                            echo "<br><a href='inicio.php'class='back'>VOLVER</a>";
                        }else{
                            $ObjBBDD->cerrarConexion();//cierre conexion
                            sleep(2);//espera para que el servidor ejecute la consulta anterior a tiempo
                            $ObjBBDD->conectar();//conexion BBDD
                            $sql = 'INSERT INTO usuario (Usuario,Pass,Tipo) VALUES ("' . $_POST['user'] . '", "' . encriptar($_POST['pass']) . '", 1);';//consulta agregar admin
                            $ObjBBDD->ejecutarConsulta($sql);//ejecutar consulta
                            if($ObjBBDD->comprobarError()){//comprobar error
                                echo $ObjBBDD->comprobarError();
                                echo "<br><a href='inicio.php'class='back'>VOLVER</a>";
                            }else{
                                header("Location:login.php");//redireccion
                            }
                            $ObjBBDD->cerrarConexion();//cerrar conexion
                        }
                    }
                }
            }
        ?>
</center>
    </body>
</html>
