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
                echo '<h1>Error de conexión: ' . $ObjBBDD->comprobarConexion() . '</h1>';//Mostrar Error
            } else {
                if (!isset($_POST["Visitar"])) {//formulario visitar
                    $sql = "SELECT * FROM lugar;";
                    $resultado = $ObjBBDD->ejecutarConsulta($sql);
                    echo '
                    <center>
                        <h1>VISITAR</h1><br>';

                        echo '
                        <form action="#" method="post">
                        <label for="lugar">DESTINO</label>
                        
                        <select name="lugar">
                            ';//desplegable lugares
                    while ($fila = $ObjBBDD->extraerFila($resultado)) {
                        if ($fila["IdLugar"] != $_SESSION["lugar"]) {
                            echo '<option value="' . $fila['IdLugar'] . '">' . $fila['Nombre'] . '</option>';
                        }
                    }
                    echo '
                        </select></br></br>
                        <input type="submit" class="opc" name="Visitar" value="VISITAR" />
                        <input type="reset" class="opc" name="Cancelar" value="CANCELAR" />
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
                        echo "<br><a href='Visitas.php'>CONTINUAR</a>";
                    }
                }
            }
        }else{
            echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                <br><a href="login.php"class="back">VOLVER</a>
            ';
        }
        ?>
</center>
    </body>
</html>
