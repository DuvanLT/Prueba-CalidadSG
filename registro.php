<?php
include("conectar.php"); 

$conectar = conectar(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

    $stmt = $conectar->prepare("INSERT INTO registro (nombre, contraseña) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $hashed_password);

    if ($stmt->execute()) {
        echo "Registro exitoso!";
        header("Location: iniciar.html");
        exit();
    } else {
        echo "Error al enviar los datos: " . $stmt->error;
    }
    $stmt->close();
}
?>
