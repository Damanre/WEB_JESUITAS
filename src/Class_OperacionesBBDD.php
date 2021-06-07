<?php
    require_once "configDB.php";

    function conectarInstalador(){//conaxion BBDD Para instalacion
        return $conexion=new mysqli(server,user,pass);
    }

    function conectar(){//conexion BBDD Para uso
        return $conexion=new mysqli(server,user,pass,database);
    }

    function ejecutarMultiConsulta($conexion,$sql){//ejecutar multiquery
        $resultado=$conexion->multi_query($sql);
        return $resultado;
    }

    function ejecutarConsulta($conexion,$sql){//ejecutar query
        $resultado=$conexion->query($sql);
        return $resultado;
    }

    function cerrarConexion($conexion){//cerrar Conexion
        $conexion->close();
    }

    function comprobarConexion($conexion){//Comprobar error de conexion
        return $conexion->connect_error;
    }

    function comprobarError($conexion){//comprobar error general
        return $error=$conexion->error;
    }

    function filasObtenidas($resultado){//comprobar filas devueltas
        return $resultado->num_rows;
    }

    function filasAfectadas($resultado){//comprobar filas cambiadas
        return $resultado->affected_rows;
    }

    function extraerFila($resultado){//extraer consulta en array
        return $resultado->fetch_array(MYSQLI_ASSOC);
    }

    function numeroError($conexion){
        return $conexion->errno;
    }
?>
