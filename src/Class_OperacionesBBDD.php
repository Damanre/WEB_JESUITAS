<?php
    require_once "configDB.php";
    class OperacionesBBDD{

        public $conexion;

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
            return $this->numeroError();
        }

        function comprobarError(){//comprobar error general
            $errno=$this->numeroError();
            if($errno==1062){
                $error="<span class='error'>ERROR: DATO REPETIDO</span><br>";
            }else{
                $error=$this->conexion->error;
            }
            return $error;
        }

        function filasObtenidas($resultado){//comprobar filas devueltas
            return $resultado->num_rows;
        }

        function extraerFila($resultado){//extraer consulta en array
            return $resultado->fetch_array(MYSQLI_ASSOC);
        }

        function numeroError(){
            return $this->conexion->errno;
        }
    }
?>
