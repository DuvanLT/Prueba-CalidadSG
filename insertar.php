<?php
include("conectar.php");
session_start();

$conectar = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ciudad = $_POST['ciudad'];
    $temperatura = $_POST['temperatura'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $user_id = $_POST['user_id']; // Recibe el ID de usuario

    $stmt = $conectar->prepare("INSERT INTO weather (registro_id, ciudad, temperatura, descripcion, fecha) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $ciudad, $temperatura, $descripcion, $fecha);

    if ($stmt->execute()) {
        echo 'Datos insertados correctamente';
    } else {
        echo 'Error al insertar datos: ' . $stmt->error;
    }

    $stmt->close();
}
?>
