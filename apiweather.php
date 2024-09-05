<?php
$apiKey = '65f580c6cb4d19f5049453ecf374a233';

$ciudades = ['Bogota', 'Cali', 'Jamundi', 'Cartagena', 'Medellin'];

foreach ($ciudades as $ciudad) {
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$ciudad}&appid={$apiKey}&units=metric";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    // Cierra la sesión cURL
    curl_close($ch);

    // Decodifica el JSON
    $data = json_decode($response, true);

    // Verifica si la respuesta es válida
    if (isset($data['main'])) {
        echo "Ciudad: " . $data['name'] . "\n";
        echo "Temperatura: " . $data['main']['temp'] . "°C\n";
        echo "Descripción: " . $data['weather'][0]['description'] . "\n";
        echo "---------------------\n";
    } else {
        echo "Error al obtener datos para la ciudad: " . $ciudad . "\n";
    }
}
?>
