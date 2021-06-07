<?php
    session_start();

    if (isset($_SESSION["usuario"])) {
        if ($_SESSION["tipo"] == 1) {
            echo "<br><a href='cerrarSesion.php'>CERRAR SESION</a>";
            echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><!--mostrar nombre de admin-->
            <br>
            <!--Enlaces-->
            <a href='addAlumno.php'>Añadir Alumno</a>
            <br>
            <a href='addMaquina.php'>Añadir Maquina</a>
            <br>
            <a href='addLugares.php'>Añadir Lugar</a>
            <br>
            <a href='addProfesor.php'>Añadir Profesor</a>
            ";
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

?>
