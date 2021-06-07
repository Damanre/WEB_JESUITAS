<?php
    session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Visitas</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION["ip"])) {
            require_once "Class_OperacionesBBDD.php";
            require_once "Class_OperacionesEXT.php";
            echo "<br><a href='cerrarSesion.php'>CERRAR SESION</a>";
            echo "<h1>Hola " . $_SESSION["nombre"] . "</h1><br>";
            $conexion = conectar();//Conexion BBDD
            if (comprobarConexion($conexion)) {//Comprobar conexion BBDD
                echo '<h1>Error de conexión: ' . comprobarConexion($conexion) . '</h1>';//Mostrar Error
            } else {
                if (!isset($_POST["Visitar"])) {//formulario visitar
                    $sql = "SELECT * FROM lugar;";
                    $resultado = ejecutarConsulta($conexion, $sql);
                    echo '
                    <center>
                        <h1>VISITAR</h1><br><br>';
                        if(isset($_COOKIE)){
                            echo'Ultimos lugares visitados:</br><br>';
                            for($c=0;$c<5;$c++){
                                if(isset($_COOKIE[$c])){
                                    echo $_COOKIE[$c].'<br>';
                                }
                            }
                        }
                        echo '
                        <form action="#" method="post">
                        <label for="lugar">DESTINO</label>
                        
                        <select name="lugar">
                            ';//desplegable lugares
                    while ($fila = extraerFila($resultado)) {
                        if ($fila["IdLugar"] != $_SESSION["lugar"]) {
                            echo '<option value="' . $fila['IdLugar'] . '">' . $fila['Nombre'] . '</option>';
                        }
                    }
                    echo '
                        </select></br></br>
                        <input type="submit" name="Visitar" value="VISITAR" />
                        <input type="reset" name="Cancelar" value="CANCELAR" />
                    </form>
                    </center>
                    ';
                    echo "<br><a href='indexUser.php'>VOLVER</a>";
                } else {
                    $sql = "SELECT * FROM maquina WHERE IdLugar='" . $_POST['lugar'] . "';";//consulta info maquina destino
                    $resultado = ejecutarConsulta($conexion, $sql);//ejecutar consulta
                    $ipl = extraerFila($resultado);//extraer filas
                    $sql = 'INSERT INTO visita (IpLugar, IpJesuita, FechaHora) VALUES ("' . $ipl['Ip'] . '","' . $_SESSION['ip'] . '",NOW());';//consulta agregar visita
                    ejecutarConsulta($conexion, $sql);//ejecutar consulta
                    if ($error = comprobarError($conexion)) {//comprobar error
                        echo $error;
                        echo "<br><br><a href='Visitas.php'>VOLVER</a>";
                    } else {
                        echo 'OK';
                        $sql ="SELECT l.Nombre FROM lugar l INNER JOIN maquina m ON l.IdLugar=m.IdLugar INNER JOIN visita v ON v.IpLugar=m.Ip ORDER BY v.IdVisita DESC LIMIT 5";
                        $resultado=ejecutarConsulta($conexion,$sql);
                        //Consulta al ultimo lugar visitado
                        if($error=comprobarError($conexion)){
                            echo $error;
                        }else{
                            $i=0;
                            while ($ulugar=extraerFila($resultado)) {
                                setcookie($i,$ulugar["Nombre"],time()+36000);
                                $i++;
                            }
                        }
                        echo "<br><a href='indexUser.php'>CONTINUAR</a>";
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
