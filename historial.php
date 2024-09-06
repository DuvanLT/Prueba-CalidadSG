<?php
include("conectar.php");
session_start();

$conectar = conectar();

if (!isset($_SESSION['user_id'])) {
    echo "No estás autenticado.";
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
    SELECT w.ciudad, w.temperatura, w.descripcion, w.fecha
    FROM weather w
    INNER JOIN registro r ON w.registro_id = r.id
    WHERE r.id = ?
";

$stmt = $conectar->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$climas = [];
while ($row = $result->fetch_assoc()) {
    $climas[] = $row;
}

$stmt->close();
$conectar->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin.css">
    <title>Climas Guardados</title>
</head>
<body>
<header>
        <nav>
            <picture class="logo">
            <img src="Multimedia/clima.png" alt="logo" />
            </picture>
            <ul>
            <a href="index.php"> <li>INICIO</li></a>
            <a href="admin.php"> <li>REGISTRAR DATOS</li></a>
            <a href="historial.php"><li>HISTORIAL DE CLIMAS</li> </a>
            </ul>
        </nav>
    
    </header>  
    <main>
    <section class="clima-default">
        <?php if (!empty($climas)) : ?>
            <?php foreach ($climas as $clima) : ?>
         
                    <div class="card-container">
                        <div class="info_principal">
                            <h2 id="ciudad"><?php echo htmlspecialchars($clima['ciudad']); ?></h2>
                            <p id="temperatura"><?php echo htmlspecialchars($clima['temperatura']); ?>°C</p>
                        </div>
                        <p id="descripcion"><?php echo htmlspecialchars($clima['descripcion']); ?></p>
                        <p id="hora"><?php echo htmlspecialchars($clima['fecha']); ?></p>
                    </div>
             
            <?php endforeach; ?>
        <?php else : ?>
            <p>No hay datos de clima disponibles.</p>
        <?php endif; ?>
        </section>
    </main>
    <footer>
        <ul>
            <li  class="titulo">Ayuda</li>
            <li>olvide mi contraseña</li>
            <li>olvide mi usuario</li>
            <li>olvide algo</li>
        </ul>
        <ul>
            <li class="titulo">CalidadSG</li>
            <li>¿Quienes somos?</li>
            <li>¿Quienes somos?</li>
            <li>¿Quienes somos?</li>
        </ul>
        <ul>
            <li class="titulo">Trabaja con Nosotros</li>
            <li>Aplicar</li>
            <li>Aplicar</li>
            <li>Aplicar</li>
        </ul>
    </footer>   
</body>
</html>
