<?php
    session_start();

    require_once "Class_OperacionesBBDD.php";
    if (isset($_SESSION["usuario"])) {
        echo "<br><a href='cerrarSesion.php'class='logout'>CERRAR SESION</a>";
        echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><br>";
        $ObjBBDD=new OperacionesBBDD();
        $ObjBBDD->conectar();
        if(isset($_GET["ip"])){
            $ip=$_GET["ip"];

            $sql = "SELECT * FROM lugar;";
            $resultado = $ObjBBDD->ejecutarConsulta($sql);
            $sql2 = "SELECT * FROM alumno;";
            $resultado2 = $ObjBBDD->ejecutarConsulta($sql2);
            $sql3 = "select m.Ip,l.Nombre as Lugar, a.Nombre as Alumno from maquina m INNER JOIN lugar l ON m.IdLugar=l.IdLugar INNER JOIN alumno a ON m.IdAlumno=a.IdAlumno WHERE m.Ip='".$ip."';";
            $resultado3=$ObjBBDD->ejecutarConsulta($sql3);
            $fila3=$ObjBBDD->extraerFila($resultado3);
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
