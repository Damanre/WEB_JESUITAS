<?php

    function encriptar($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    function comprobarHash($pass,$hash){
        return password_verify($pass, $hash);
    }
?>
