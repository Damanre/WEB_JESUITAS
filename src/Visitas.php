<?php
session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>VISITAS</title>
        <link href="../style/estilo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center>
            <?php
                if (isset($_SESSION["ip"])) {
                    require_once "Class_OperacionesBBDD.php";
                    require_once "Class_OperacionesEXT.php";
                    echo "<br><a href='cerrarSesion.php'class='logout'>CERRAR SESION</a>";
                    echo "<h1>Hola " . $_SESSION["nombre"] . "</h1><br>";
                    $ObjBBDD=new OperacionesBBDD();
                    $ObjBBDD->conectar();//Conexion BBDD
                    if ($ObjBBDD->comprobarConexion()) {//Comprobar conexion BBDD
                        echo '<span class="error">Error de conexión: ' . $ObjBBDD->comprobarConexion() . '</span>';//Mostrar Error
                    } else {
                        if(!isset($_SESSION['jesuita'])){
                            if(!isset($_POST['Add'])){
                                $numero=0;
                                if(isset($_POST["numero"])){
                                    $numero=$_POST["numero"];
                                }
                                echo '
                                <h1>ASIGNAR JESUITA</h1><br>
                                <form action="Visitas.php?numero='.$numero.'" method="post">
                                    <label for="nombre">JESUITA</label>';
                                if(!isset($_POST["filas"])){
                                    echo '<input type="text" name="nombre" placeholder="Nombre Jesuita" disabled/></br></br>';

                                }else{
                                    echo '<input type="text" name="nombre" placeholder="Nombre Jesuita" /></br></br>';

                                }
                                    echo '<label for="firma">FIRMA</label>';
                                if(!isset($_POST["filas"])){
                                    echo ' <input type="text" name="firma" placeholder="Firma Jesuita" disabled/></br></br>';
                                }else{
                                    echo ' <input type="text" name="firma" placeholder="Firma Jesuita" /></br></br>';
                                }
                                    if(!isset($_POST["filas"])){
                                        echo '<form action="#" method="post">
                                        <label for="numero">FILAS INFORMACION</label>
                                        <input type="text" name="numero" placeholder="Numero de filas" />
                                        <input class="opc" type="submit" name="filas" value="AGREGAR INFO" />
                                        </form>';
                                    }else{
                                        echo '<h1>INFORMACION</h1><br>';
                                            for($i=0;$i<$_POST["numero"];$i++){
                                                echo '<input type="text" name="'.$i.'" placeholder="INFORMACION" /></br></br>';
                                        }
                                    }
                                    echo '<br><input class="opc" type="submit" name="Add" value="ASIGNAR" />
                                </form>
                            ';
                            }else{
                                if(empty($_POST["nombre"]) || empty($_POST["firma"])){
                                    echo '<span class="error">NO PUEDES DEJAR EN BLANCO NINGUN CAMPO</span><br>';//si no existe la maquina
                                    echo "<br><a href='Visitas.php'class='back'>VOLVER</a>";
                                }else{
                                    $sql = 'UPDATE maquina SET Jesuita="'.$_POST["nombre"].'",Firma="'.$_POST["firma"].'" WHERE Ip="'.$_SESSION["ip"].'";';//consulta agregar maquina
                                    for($i=0;$i<$_GET["numero"];$i++){
                                        $sql2 = 'INSERT INTO informacion_j (IpJesuita,Descripcion) VALUES ("' . $_SESSION['ip'] . '","'.$_POST[$i].'");';
                                        $ObjBBDD->ejecutarConsulta( $sql2);
                                    }
                                    $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
                                    if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                                        echo $error;
                                        echo "<br><a class='back' href='Visitas.php'>Salir</a>";
                                    } else {
                                        $sql = "SELECT * FROM maquina AS m INNER JOIN alumno AS a ON m.IdAlumno = a.IdAlumno  WHERE m.Ip='".$_SESSION['ip']."';";//consulta comprobar si existe maquina
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
                                        }
                                    }
                                }
                            }
                        }else{
                            if (!isset($_POST["Visitar"])) {//formulario visitar

                                echo '
                            <center>
                                <h1>VISITAR</h1><br>';

                                echo '
                                <form action="#" method="post">
                                <label for="lugar">DESTINO</label>
                                
                                <select name="lugar">
                                    ';//desplegable lugares
                                $sql = "SELECT * FROM lugar;";
                                $resultado = $ObjBBDD->ejecutarConsulta($sql);
                                while ($fila = $ObjBBDD->extraerFila($resultado)) {
                                    if ($fila["IdLugar"] != $_SESSION["lugar"]) {
                                        echo '<option value="' . $fila['IdLugar'] . '">' . $fila['Nombre'] . '</option>';
                                    }
                                }
                                echo '
                                </select></br></br>
                                <input type="submit" class="opc" name="Visitar" value="VISITAR" />
                            </form>
                            </center>
                            ';
                                if(isset($_COOKIE)){
                                    echo'Ultimos lugares visitados:</br><br>';
                                    for($c=0;$c<5;$c++){
                                        if(isset($_COOKIE[$c])){
                                            echo $_COOKIE[$c].'<br><br>';
                                        }
                                    }
                                    if(!isset($_COOKIE[0])){
                                        echo 'NO HAY VISITAS<br><br>';
                                    }
                                }
                            } else {
                                if(empty($_POST["lugar"])){
                                    echo '<span class="error">NO PUEDES DEJAR EN BLANCO ESTE CAMPO</span><br>';//si no existe la maquina
                                    echo "<br><a href='Visitas.php'class='back'>VOLVER</a>";
                                }else{
                                    $sql = "SELECT * FROM maquina WHERE IdLugar='" . $_POST['lugar'] . "';";//consulta info maquina destino
                                    $resultado = $ObjBBDD->ejecutarConsulta($sql);//ejecutar consulta
                                    $ipl = $ObjBBDD->extraerFila($resultado);//extraer filas
                                    $sql = 'INSERT INTO visita (IpLugar, IpJesuita, FechaHora) VALUES ("' . $ipl['Ip'] . '","' . $_SESSION['ip'] . '",NOW());';//consulta agregar visita
                                    $ObjBBDD->ejecutarConsulta($sql);//ejecutar consulta
                                    if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                                        echo $error;
                                        echo "<br><br><a href='Visitas.php'class='back'>VOLVER</a>";
                                    } else {
                                        echo 'OK';
                                        $sql ="SELECT l.Nombre FROM lugar l INNER JOIN maquina m ON l.IdLugar=m.IdLugar INNER JOIN visita v ON v.IpLugar=m.Ip ORDER BY v.IdVisita DESC LIMIT 5";
                                        $resultado=$ObjBBDD->ejecutarConsulta($sql);
                                        //Consulta al ultimo lugar visitado
                                        if($error=$ObjBBDD->comprobarError()){
                                            echo $error;
                                        }else{
                                            $i=0;
                                            while ($ulugar=$ObjBBDD->extraerFila($resultado)) {
                                                setcookie($i,$ulugar["Nombre"],time()+36000);
                                                $i++;
                                            }
                                        }
                                        echo "<br><a class='back' href='Visitas.php'>CONTINUAR</a>";
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
            ?>
        </center>
    </body>
</html>
