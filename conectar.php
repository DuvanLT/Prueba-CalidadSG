    <?php


    //creamos una funcion la cual por medio de cuatro variables donde normalmente la cambiante es el nombre de
    //la base de datos nos conectaremos a nuestro servidor mysql usando mysqli
    function conectar(){
        $server = "sql210.infinityfree.com";
        $user = "if0_37255555";
        $password = "Z6htikYbSK";
        $database = "if0_37255555_clima";

        $conexion = mysqli_connect($server,$user,$password,$database); //pasamos las varaibles para  realizar 
        //la conexion


        //entedemos que si la conexion falla, hay errores de datos
        if(!$conexion){
            die("Error en la base de datos:" . mysqli_connect_error());
        }

            return $conexion;
    }


    ?>