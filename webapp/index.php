<?php

// default values
$loggedin = false;
$errorMsg = null;
$response = null;
$user = null;

if (!empty($_COOKIE['api_token'])) {
    try {
        // Suppress warnings with @ and check if the result is false
        $content = @file_get_contents('http://localhost/temperaturueberwachung/api/web/user/info/' . $_COOKIE['api_token']);

        // If the request failed, store the error message
        if ($content === false) {
            $errorMsg = 'Failed to fetch user information. The server returned an error.';
        } else {
            // Decode the JSON response
            $content = json_decode($content);

            // Check if the response contains user information
            if (!empty($content->response)) {
                $loggedin = true;
                $user = $content->response;
            }
        }
    } catch (Exception $e) {
        // Catch any exceptions and store the error message
        $errorMsg = $e->getMessage();
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temperaturüberwachung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body>

<header class="d-flex justify-content-center py-3">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a href="index.php"
               class="nav-link active"
               aria-current="page">
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="doku.html"
               class="nav-link"
               target="_blank"
               aria-current="page">
                API-Doku
            </a>
        </li>

        <li class="nav-item">
            <a href="http://localhost/temperaturueberwachung/api/web/app/download"
               target="_blank"
               class="nav-link">
                Download</a>
        </li>

        <li class="nav-item">
            <a href="<?= $loggedin ? 'logout' : 'login' ?>.php"
                <?= $loggedin ? 'style="color: lightcoral;"' : '' ?>
               class="nav-link">
                <?= $loggedin ? 'Logout' : 'Login' ?>
            </a>
        </li>

        <li class="nav-item">
          <a href="log-tabelle.php"
             class="nav-link"
             aria-current="page">
            Log-Tabelle </a>
        </li>
    </ul>
</header>

<div class="row justify-content-center text-center">
    <!-- mehrere Leerzeilen -->
    <h1 class="text-center mt-3"><b><?= $loggedin ? 'Welcome back, ' . $user->username : 'Temperaturüberwachung WEB' ?></b></h1>

    <div class="card-container row justify-content-center">
        <!-- card will be here -->
    </div>
</div>

<script>
    const url = "http://localhost/temperaturueberwachung/api/web/sensor/all";

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to fetch data. Status code: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const container = document.querySelector('.card-container');

            if (!container) {
                console.error("Could not find the container.");
                return;
            }

            // Access the sensors array from the JSON response
            const sensors = data.response;

            // Loop through each sensor
            sensors.forEach(sensor => {
                // Create a new card for each sensor
                const card = document.createElement('div');
                card.classList.add('card-border', 'mt-4');

                // Generate the HTML for the sensor card
                card.innerHTML = `
            <div>
                <h5 class="mb-2">Server: </h5>
                <h6 class="text-body-tertiary">${sensor.name}</h6>
            </div>
            <div class="d-flex justify-content-left pt-3 flex-1">
                <div class="circle-container">
                    <div class="circle-temp" style="background-color: ${sensor.infoColor};"></div>
                    <div class="my-circle">
                        <h1 class="Temp_Text">${sensor.currentTemperature}°C</h1>
                    </div>
                    <div class="circle-container-bottom"></div>
                </div>
            </div>
            <div class="mt-3 justify-content-center text-center Max_Min_Temp">
                <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary me-2"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Max. Temp.:</h6>
                    <h6 class="text-body fw-semibold mb-0">${sensor.maxTemp}°C</h6>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary-subtle me-2"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Min. Temp.:</h6>
                    <h6 class="text-body fw-semibold mb-0">${sensor.minTemp}°C</h6>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary-subtle me-2"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.:</h6>
                    <h6 class="text-body fw-semibold mb-0">${sensor.avgTemp}°C</h6>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary-subtle me-2"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Hersteller: <b>${sensor.manufacturer}</b></h6>
                </div>
            </div>
            <button class="btn btn-secondary open-temp-log-btn w-100"
                    autofocus
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse-${sensor.id}"
                    aria-expanded="false"
                    aria-controls="collapse-${sensor.id}">
                Temperatur Log
            </button>
                <div class="collapse collapse-horizontal justify-content-center mt-5"
                     id="collapse-${sensor.id}">
                    <div class="card card-body"
                         style="width: 300px; top: 100px; z-index:250">
                        <table id="temperatureTable">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Temperature</th>
                            </tr>
                            </thead>
                            <tbody>
                                ${sensor.temperatures.map(temp => `
                                    <tr style="color: ${temp.color}">
                                        <td>${temp.created_at}</td>
                                        <td>${temp.time}</td>
                                        <td>${temp.temperature}°C</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>`;
                // Append the card to the container
                container.appendChild(card);

                const circle = card.querySelector('.circle-temp');

                if (circle) {
                    const currentTemp = sensor.currentTemperature;
                    const maxTemp = sensor.maxTemp;
                    const minTemp = sensor.minTemp;

                    let procent = ((currentTemp - minTemp) / (maxTemp - minTemp)) * 100;

                    if (procent > 100) procent = 100;
                    if (procent < 0) procent = 0;

                    const angle = procent * 1.8;
                    circle.style.transform = `rotate(${angle}deg)`;
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });


</script>
</body>
</html>
