<?php

function conectar(){
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "clima";

    $conexion = mysqli_connect($server,$user,$password,$database);

    if(!$conexion){
        die("Error en la base de datos:" . mysqli_connect_error());
    }else{
        echo "<p>conexion exitosa en la base datos</p>";
        }

        return $conexion;
}


?>