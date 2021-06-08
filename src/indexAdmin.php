<?php
    session_start();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>ADMINISTRADOR</title>
        <link href="../style/estilo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center>
            <body>
                <?php
                    if (isset($_SESSION["usuario"])) {
                        if ($_SESSION["tipo"] == 1) {
                            echo "<a class='logout' href='cerrarSesion.php'class='logout'>CERRAR SESION</a><br><br>";
                            echo "<h1>Hola " . $_SESSION["usuario"] . "</h1><!--mostrar nombre de admin-->
                            <br>
                            <!--Enlaces-->
                            <a class='opc' href='addAlumno.php'>Añadir Alumno</a>
                            <br>
                            <br>
                            <a class='opc' href='addMaquina.php'>Añadir Maquina</a>
                            <br>
                            <br>
                            <a class='opc' href='addLugares.php'>Añadir Lugar</a>
                            <br>
                            <br>
                            <a class='opc' href='addProfesor.php'>Añadir Profesor</a>
                            ";
                        } else {
                            echo '<span class="error">NO PUEDES ACCEDER A ESTE SITIO</span>
                                <br><a class="back" href="login.php">VOLVER</a>
                            ';
                        }
                    } else {
                        echo '<span class="error">NO PUEDES ACCEDER A ESTE SITIO</span>
                            <br><a class="back" href="login.php">VOLVER</a>
                        ';
                    }
                ?>
            </body>
        </center>
    </body>
</html>