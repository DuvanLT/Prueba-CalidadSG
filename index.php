<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS\style.css">
    <title>My Climax</title>
</head>
<body>
    <header>
        <nav>
            <picture class="logo">
            <img src="Multimedia/clima.png" alt="logo" />
            </picture>
            <ul>
            <a href="index.php"> <li>INICIO</li></a>
            <a href="iniciar.html" class="iniciarsesion"><li>INICIAR SESION</li> </a>
            </ul>
        </nav>
    
    </header>   
    <section class="hero">
        <div class="hero_text">
            <h1>REGISTRA LOS CAMBIOS CLIMATICOS EN TU AREA</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24"><path fill="#ffffff" d="m11.5 13.508l-1.766-1.766q-.14-.14-.334-.14t-.334.14t-.141.348t.14.34l2.389 2.39q.242.241.565.241t.565-.242l2.389-2.388q.14-.134.14-.341t-.14-.348t-.347-.14t-.341.14l-1.766 1.766V9.096q0-.212-.144-.356t-.357-.144t-.365.144t-.153.356zM12.003 21q-1.866 0-3.51-.708q-1.643-.709-2.859-1.924t-1.925-2.856T3 12.003t.709-3.51Q4.417 6.85 5.63 5.634t2.857-1.925T11.997 3t3.51.709q1.643.708 2.859 1.922t1.925 2.857t.709 3.509t-.708 3.51t-1.924 2.859t-2.856 1.925t-3.509.709"/></svg>
        </div>
        <picture class="hero_container">
            <img src="Multimedia\pexels-invisiblepower-303530.webp" alt="clima" />
            </picture>
    </section>
    <section class="clima-default">
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
                $icon = $data['weather'][0]['icon'];
                $imgUrl = "http://openweathermap.org/img/wn/{$icon}@2x.png";
                $description = isset($data['weather'][0]['description']) ? htmlspecialchars($data['weather'][0]['description']) : 'Descripción no disponible';

                echo '<div class="card-container">';
                echo '<picture class="icon">';
                echo "<img src=\"{$imgUrl}\" alt=\"Icono del clima\" />";
                echo '</picture>';
                echo '<div class="info_principal">';
                echo "<h2>" . htmlspecialchars($data['name']) . "</h2>";
                echo "<p>". htmlspecialchars($data['main']['temp']) . "°C</p>";
                echo "</div>";
                echo "<p>Descripción: " . $description . "</p>";
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
    </section>
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
