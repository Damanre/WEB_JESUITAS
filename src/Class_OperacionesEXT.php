<?php
    function getIp(){//obtener ip del cliente
        return getHostByName(getHostName());
        //return '1.1.1.1';
    }

    function encriptar($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    function comprobarHash($pass,$hash){
        return password_verify($pass, $hash);
    }
?>
