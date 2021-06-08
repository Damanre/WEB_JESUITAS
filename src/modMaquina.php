<?php
    session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <title>Iniciar Sesión</title>
    <link href="../style/estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
<center>
    <?php
    require_once "Class_OperacionesBBDD.php";
    if (isset($_SESSION["usuario"])) {
        echo "<br><a href='cerrarSesion.php'class='logout'>CERRAR SESION</a>";
        echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
        $ObjBBDD=new OperacionesBBDD();
        $ObjBBDD->conectar();
        $ip=$_GET["ip"];

        $sql = "SELECT * FROM lugar;";
        $resultado = $ObjBBDD->ejecutarConsulta($sql);
        $sql2 = "SELECT * FROM alumno;";
        $resultado2 = $ObjBBDD->ejecutarConsulta($sql2);
        $sql3 = "select m.Jesuita,m.Firma,m.Ip,l.Nombre as Lugar, a.Nombre as Alumno from maquina m INNER JOIN lugar l ON m.IdLugar=l.IdLugar INNER JOIN alumno a ON m.IdAlumno=a.IdAlumno WHERE m.Ip='".$ip."';";
        $resultado3=$ObjBBDD->ejecutarConsulta($sql3);
        $fila3=$ObjBBDD->extraerFila($resultado3);
        if(isset($_GET["ip"])){
            if(!isset($_POST['Add'])){

                echo '
                <center>
                    <h1>MODIFICAR MAQUINA</h1><br><br>
                    <form action="#" method="post">
                        <label for="ip">IP</label>
                        <input type="text" name="ip" placeholder="Direccion IP" value="'.$fila3["Ip"].'"/></br></br>
                        <label for="lugar">LUGAR</label>
                        <select name="lugar">
                            ';//desplegable lugares
                while ($fila = $ObjBBDD->extraerFila($resultado)) {
                    if($fila['Nombre']==$fila3['Lugar']){
                        echo '  <option value="' . $fila['IdLugar'] . '" selected>' . $fila['Nombre'] . '</option>';

                    }else{
                        echo '  <option value="' . $fila['IdLugar'] . '">' . $fila['Nombre'] . '</option>';

                    }
                }
                echo '
                        </select></br></br>
                        <label for="jesuita">Jesuita</label>
                        <input type="text" name="jesuita" placeholder="Nombre Jesuita" value="'.$fila3["Jesuita"].'"/></br></br>
                        <label for="firma">Firma</label>
                        <input type="text" name="firma" placeholder="Firma Jesuita" value="'.$fila3["Firma"].'"/></br></br>
                        <label for="alumno">ALUMNO</label>
                        <select name="alumno">
                    ';//desplegable alumnos
                while ($fila2 = $ObjBBDD->extraerFila($resultado2)) {
                    if($fila2['Nombre']==$fila3['Alumno']){
                        echo '  <option value="' . $fila2['IdAlumno'] . '" selected>' . $fila2['Nombre'] . ' ' . $fila2['Apellidos'] . '</option>';

                    }else{
                        echo '  <option value="' . $fila2['IdAlumno'] . '">' . $fila2['Nombre'] . ' ' . $fila2['Apellidos'] . '</option>';

                    }
                }
                echo '
                        </select></br></br>
                        <input type="submit" class="opc" name="Add" value="GUARDAR" />
                    </form>
                </center>
                ';
                    echo "<br><a href='addMaquina.php'class='back'>VOLVER</a>";
            }else{
                if(empty($_POST["ip"]) || empty($_POST["jesuita"]) || empty($_POST["firma"]) || empty($_POST["alumno"])){
                    echo '<span class="error">NO PUEDES DEJAR EN BLANCO NINGUN CAMPO</span><br>';//si no existe la maquina
                    echo "<br><a href='modMaquina.php'class='back'>VOLVER</a>";
                }else{
                    $sql = 'UPDATE maquina SET Ip="'.$_POST["ip"].'",Jesuita="'.$_POST["jesuita"].'",Firma="'.$_POST["firma"].'",IdAlumno="'.$_POST["alumno"].'" WHERE Ip="'.$fila3['Ip'].'";';//consulta agregar maquina
                    $ObjBBDD->ejecutarConsulta( $sql);//ejecutar consulta
                    if ($error = $ObjBBDD->comprobarError()) {//comprobar error
                        echo $error;
                        echo "<br><a class='back' href='modMaquina.php'>Volver</a>";
                    } else {
                        header('Location:addMaquina.php');
                    }
                }
            }
        }else{
            echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                        <br><a href="login.php"class="back">VOLVER</a>';
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
