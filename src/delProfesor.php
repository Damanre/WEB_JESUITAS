<?php
session_start();

require_once "Class_OperacionesBBDD.php";
if (isset($_SESSION["usuario"])) {
    $ObjBBDD=new OperacionesBBDD();
    $ObjBBDD->conectar();
    if(isset($_GET["id"])){
        $id=$_GET["id"];
        $sql = 'DELETE FROM usuario WHERE IdUser="'.$id.'";';//consulta borrar lugar
        $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
        if ($error = $ObjBBDD->comprobarError()) {//comprobar error
            echo $error;
            echo "<br><a href='addProfesor.php'class='back'>VOLVER</a>";
        } else {
            header("LOCATION:addProfesor.php");
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