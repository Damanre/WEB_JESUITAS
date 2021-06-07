<?php
    require_once "configDB.php";
    class OperacionesBBDD{
        function conectarInstalador(){//conaxion BBDD Para instalacion
            $this->conexion= new mysqli(server,user,pass);
        }

        function conectar(){//conexion BBDD Para uso
            $this->conexion= new mysqli(server,user,pass,database);
        }

        function ejecutarMultiConsulta($sql){//ejecutar multiquery
            return $this->conexion->multi_query($sql);
        }

        function ejecutarConsulta($sql){//ejecutar query
            return $this->conexion->query($sql);
        }

        function cerrarConexion(){//cerrar Conexion
            $this->conexion->close();
        }

        function comprobarConexion(){//Comprobar error de conexion
            return $this->conexion->connect_error;
        }

        function comprobarError(){//comprobar error general
            return $this->conexion->error;
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

        function numeroError(){
            return $this->conexion->errno;
        }
    }
?>
