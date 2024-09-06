<?php
include("conectar.php"); 
session_start(); 

$conectar = conectar(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    if (empty($nombre) || empty($contrasena)) {
        echo 'No se ha iniciado sesión.';
        exit();
    }

    $stmt = $conectar->prepare("SELECT id, contrasena FROM registro WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        
        if (password_verify($contrasena, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['nombre'] = $nombre;
            echo 'success'; 
        } else {
            echo 'Contraseña incorrecta.';
        }
    } else {
        echo 'Usuario no encontrado.';
    }
    $stmt->close();
}
?>
