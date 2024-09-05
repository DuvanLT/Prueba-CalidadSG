<?php
include("conectar.php"); 

$conectar = conectar(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    $stmt = $conectar->prepare("INSERT INTO registro (nombre, contraseña) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $contraseña);

    if ($stmt->execute()) {
        echo "Registro exitoso!";
    } else {
        echo "Error al enviar los datos: " . $stmt->error;
    }
    $stmt->close();
}
?>