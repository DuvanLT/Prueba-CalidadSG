<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: iniciar.html"); // Redirige a la página de inicio de sesión si no está autenticado
    exit();
}

// Aquí puedes acceder al ID del usuario y cualquier otra información de la sesión
$user_id = $_SESSION['user_id'];
$nombre = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin.css">
    <title>Geolocalización</title>
</head>
<body>
    <div class="geolocalizacion">
        <h4>Geolocalización automática</h4>
        <p>Guardaremos el clima de la zona en la que te encuentres en cada momento</p>
        <div class="opciones">
            <button onclick="aceptarGeolocalizacion()">Aceptar</button>
            <button onclick="rechazarGeolocalizacion()">Rechazar</button>
        </div>  
    </div>
    <section class="clima-default">
        <div class="card-container">
            <picture>
                <img id="clima-icono" src="" alt="Icono del clima" />
            </picture>
            <div class="info_principal">
                <h2 id="ciudad"></h2>
                <p id="temperatura"></p>
            </div>
            <p id="descripcion"></p>
            <p id="hora"></p>
        </div>
    </section>
    <section class="Ingresar">
        <form id="formCiudad">
            <label for="ciudadInput">Ingresa tu Ciudad</label>
            <input type="text" name="ciudad" id="ciudadInput" />
            <button type="submit">Ingresar</button>
        </form>
    </section>
    <script>
        const apiKey = '65f580c6cb4d19f5049453ecf374a233';

        document.getElementById('formCiudad').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario
            const ciudad = document.getElementById('ciudadInput').value;
            obtenerClimaPorCiudad(ciudad);
        });

        function aceptarGeolocalizacion() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            }

            const HoraAceptada = new Date();
            document.getElementById("hora").innerText = HoraAceptada;

            localStorage.setItem("horaAceptada", HoraAceptada);
        }

        function successCallback(position) {
            const latitud = position.coords.latitude;
            const longitud = position.coords.longitude;

            const url = `https://api.openweathermap.org/data/2.5/weather?lat=${latitud}&lon=${longitud}&appid=${apiKey}&units=metric`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const ciudad = data.name;
                    const temperatura = data.main.temp;
                    const descripcion = data.weather[0].description;
                    const icon = data.weather[0].icon;
                    const imgUrl = `http://openweathermap.org/img/wn/${icon}@2x.png`;

                    document.getElementById("ciudad").innerText = ciudad;
                    document.getElementById("temperatura").innerText = `${temperatura}°C`;
                    document.getElementById("descripcion").innerText = descripcion;
                    document.getElementById("clima-icono").src = imgUrl;
                    document.getElementById("hora").innerText = new Date();

                    // Enviar los datos automáticamente al servidor
                    enviarDatosAlServidor(ciudad, temperatura, descripcion, new Date().toISOString());
                })
                .catch(error => {
                    console.error("Error al obtener los datos del clima:", error);
                });
        }

        function obtenerClimaPorCiudad(ciudad) {
            const url = `https://api.openweathermap.org/data/2.5/weather?q=${ciudad}&appid=${apiKey}&units=metric`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const ciudadNombre = data.name;
                    const temperatura = data.main.temp;
                    const descripcion = data.weather[0].description;
                    const icon = data.weather[0].icon;
                    const imgUrl = `http://openweathermap.org/img/wn/${icon}@2x.png`;

                    document.getElementById("ciudad").innerText = ciudadNombre;
                    document.getElementById("temperatura").innerText = `${temperatura}°C`;
                    document.getElementById("descripcion").innerText = descripcion;
                    document.getElementById("clima-icono").src = imgUrl;
                    document.getElementById("hora").innerText = new Date();

                    // Enviar los datos al servidor
                    enviarDatosAlServidor(ciudadNombre, temperatura, descripcion, new Date().toISOString());
                })
                .catch(error => {
                    console.error("Error al obtener los datos del clima:", error);
                });
        }

        function enviarDatosAlServidor(ciudad, temperatura, descripcion, fecha) {
            const formData = new FormData();
            formData.append('ciudad', ciudad);
            formData.append('temperatura', temperatura);
            formData.append('descripcion', descripcion);
            formData.append('fecha', fecha);
            formData.append('user_id', '<?php echo $user_id; ?>'); // Incluye el ID de usuario en los datos

            fetch('insertar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("Respuesta del servidor:", data);
            })
            .catch(error => {
                console.error("Error al enviar los datos al servidor:", error);
            });
        }

        function errorCallback(error) {
            document.getElementById("ubicacion").innerText = "Error al obtener la ubicación: " + error.message;
        }

        function rechazarGeolocalizacion() {
            document.getElementById("ubicacion").innerText = "Has rechazado la geolocalización.";
        }

        function verificarHora() {
            const horaAceptada = new Date(localStorage.getItem("horaAceptada"));
            if (!horaAceptada) return; 
            const horaActual = new Date();

            if (horaActual.getHours() === horaAceptada.getHours() &&
                horaActual.getMinutes() === horaAceptada.getMinutes()) {
                
                notificacion();
            }
        }
        setInterval(verificarHora, 60000);

        function notificacion() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            }
        }
    </script>
</body>
</html>
