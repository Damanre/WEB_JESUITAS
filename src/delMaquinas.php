<?php
    session_start();

    require_once "Class_OperacionesBBDD.php";
    if (isset($_SESSION["usuario"])) {
        $ObjBBDD=new OperacionesBBDD();
        $ObjBBDD->conectar();
        if(isset($_GET["ip"])){
            $ip=$_GET["ip"];
            $sql = 'DELETE FROM maquina WHERE Ip="'.$ip.'";';//consulta borrar lugar
            $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
            if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                echo $error;
                echo "<br><a href='addMaquina.php'>VOLVER</a>";
            } else {
                header("LOCATION:addMaquina.php");
            }
        }else{
            echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                    <br><a href="login.php">VOLVER</a>
                ';
        }

    }else{
        echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                    <br><a href="login.php">VOLVER</a>
                ';
    }
?>