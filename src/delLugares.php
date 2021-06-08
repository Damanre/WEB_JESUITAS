<?php
    session_start();

    require_once "Class_OperacionesBBDD.php";
    if (isset($_SESSION["usuario"])) {
        $ObjBBDD=new OperacionesBBDD();
        $ObjBBDD->conectar();
        if(isset($_GET["lugar"])){
            $lugar=$_GET["lugar"];
            $sql = 'DELETE FROM lugar WHERE Nombre="'.$lugar.'";';//consulta borrar lugar
            $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
            if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                echo $error;
                echo "<br><a href='addLugares.php'class='back'>VOLVER</a>";
            } else {
                header("LOCATION:addLugares.php");
            }
        }else{
            echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                <br><a href="login.php"class="back">VOLVER</a>
            ';
        }

    }else{
        echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                <br><a href="login.php"class="back">VOLVER</a>
            ';
    }
?>
