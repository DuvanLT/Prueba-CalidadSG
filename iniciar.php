<?php
include("conectar.php"); 

$conectar = conectar(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];
    $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);
    $stmt = $conectar->prepare("INSERT INTO registro (nombre, contraseña) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $hashed_password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($contraseña, $hashed_password)) {
            echo "Inicio de sesión exitoso!";
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
}
?>
