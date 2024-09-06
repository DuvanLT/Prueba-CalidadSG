    <?php
    include("conectar.php"); 

    $conectar = conectar(); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $conectar->prepare("INSERT INTO registro (nombre, contrasena) VALUES (?, ?)");
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
