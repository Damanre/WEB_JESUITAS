<?php
session_start();
require_once "Class_OperacionesBBDD.php";
$ObjBBDD=new OperacionesBBDD;
$ObjBBDD->conectar();
if ($ObjBBDD->comprobarConexion()) {
    echo '<h1>Error de conexión: ' . $ObjBBDD->comprobarConexion().'</h1>';//Mostrar Error
}else {
    if (isset($_SESSION["usuario"])) {
        if ($_SESSION["tipo"] == 0) {
            echo "<br><a href='cerrarSesion.php'>CERRAR SESION</a>";
            echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><!--mostrar nombre de profesor-->
                <br>
                <!--Enlaces-->
                <a href='addAlumno.php'>Añadir Alumno</a>
                <br>
                <a href='addMaquina.php'>Añadir Maquina</a>
                <br>
                <a href='addLugares.php'>Añadir Lugar</a>
                <br>
                ";
            $sql = "select l.Nombre, count(v.IpLugar) contador from visita v INNER JOIN maquina m ON m.Ip=v.IpLugar INNER JOIN lugar l ON m.IdLugar=l.IdLugar group by v.IpLugar desc LIMIT 5";
            $resultado=$ObjBBDD->ejecutarConsulta($sql);
            echo '<div>';
            echo '<h2>Ranking 5 Lugares Mas Visitados</h2>';
            if ($ObjBBDD->filasObtenidas($resultado) > 0) {
                echo '<table>';
                echo '<tr>';
                echo '<th>Ciudad</th><th>Numero de visitas</th>';
                while ($fila = $ObjBBDD->extraerFila($resultado)) {
                    echo '<tr><td>' . $fila["Nombre"] . '</td> <td class="centrarvisita">' . $fila["contador"] . '</td></tr>';
                }
                echo '</tr>';
                echo '</table>';
            } else {
                echo ' No hay visitas a ningun lugar';
            }
            echo '</div>';
            /*Consulta para mostrar los 5 jesuitas con mas visitas*/
            $sql = "SELECT v.IpJesuita,m.Jesuita, COUNT(*) AS visita FROM visita v INNER JOIN maquina m ON v.IpJesuita=m.ip GROUP BY IpJesuita ORDER BY COUNT(*) DESC LIMIT 5";
            $resultado=$ObjBBDD->ejecutarConsulta($sql);
            echo '<div>';
            echo '<h2>Ranking 5 Jesuitas Mas Viajeros</h2>';
            if ($ObjBBDD->filasObtenidas($resultado) > 0) {
                echo '<table>';
                echo '<tr>';
                echo '<th>Jesuita</th> <th>Numero de visitas</th>';
                while ($fila = $ObjBBDD->extraerFila($resultado)) {
                    echo '<tr><td>' . $fila["Jesuita"] . '</td> <td class="centrarvisita">' . $fila["visita"] . '</td></tr>';
                }
                echo '</tr>';
                echo '</table>';
            } else {
                echo ' No hay jesuitas viajando';
            }
            echo '</div>';
            /*Consulta para mostrar los 5 ultimas visitas*/
            $sql = "SELECT v.IpJesuita,l.Nombre AS Lugar,v.FechaHora FROM visita v INNER JOIN maquina m ON m.Ip=v.IpLugar INNER JOIN lugar l ON m.IdLugar=l.IdLugar;";
            //SELECT m.Jesuita,l.Nombre AS Lugar,v.FechaHora FROM visita v INNER JOIN maquina mj ON v.IpJesuita=mj.Ip INNER JOIN maquina m ON m.Ip=v.IpLugar INNER JOIN lugar l ON m.IdLugar=l.IdLugar
            $resultado=$ObjBBDD->ejecutarConsulta($sql);
            echo '<div>';
            echo '<h2>Ultimas 5 Visitas</h2>';
            if ($ObjBBDD->filasObtenidas($resultado) > 0) {
                echo '<div id="ultimasVisitas">';
                while ($fila = $ObjBBDD->extraerFila($resultado)) {
                    echo $fila["IpJesuita"] . ' ha visitado ' . $fila["Lugar"] . ' el dia '.$fila['FechaHora'].'<br>';
                }
                echo '</div>';
            } else {
                echo ' No hay ultimas visitas';
            }
            echo '</div>';
        } else {
            echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                    <br><a href="login.php">VOLVER</a>
                ';
        }
    } else {
        echo '<h1>NO PUEDES ACCEDER A ESTE SITIO</h1>
                <br><a href="login.php">VOLVER</a>
            ';
    }
}
?>
