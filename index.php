<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>My Climax</title>
</head>
<body>
    <header>
        <nav>
            <img src="" alt="logo" />

            <ul>
                <li>INICIO</li>
                <li>INICIAR SECCION</li>
            </ul>
        </nav>
    
    </header>   
        <?php
        $apiKey = '65f580c6cb4d19f5049453ecf374a233';
        $ciudades = ['Bogota', 'Cali', 'Jamundi', 'Cartagena', 'Medellin'];

        foreach ($ciudades as $ciudad) {
            $url = "http://api.openweathermap.org/data/2.5/weather?q={$ciudad}&appid={$apiKey}&units=metric";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);

            if (isset($data['main'])) {
                // Obtiene la URL del icono del clima
                $icon = $data['weather'][0]['icon'];
                $imgUrl = "http://openweathermap.org/img/wn/{$icon}@2x.png";

                echo '<div class="card-container">';
                echo '<picture>';
                echo "<img src=\"{$imgUrl}\" alt=\"Icono del clima\" />";
                echo '</picture>';
                echo '<div class="info_principal">';
                echo "<h2>" . htmlspecialchars($data['name']) . "</h2>";
                echo "<p>Temperatura: " . htmlspecialchars($data['main']['temp']) . "°C</p>";
                echo "</div>";
                echo '</div>';
            } else {
                echo '<div class="card-container">';
                echo '<picture>';
                echo "<img src=\"http://openweathermap.org/img/wn/01d@2x.png\" alt=\"Icono de error\" />";
                echo '</picture>';
                echo '<div class="info_principal">';
                echo "<h2>Error al obtener datos para la ciudad: " . htmlspecialchars($ciudad) . "</h2>";
                echo "</div>";
                echo '</div>';
            }
        }
        ?> 
</body>
</html>
