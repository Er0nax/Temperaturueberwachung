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
        <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Dashboard</a></li>
        <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
        <li class="nav-item"><a href="http://localhost/temperaturueberwachung/api/web/app/download" target="_blank" class="nav-link">Download</a></li>
    </ul>
</header>

<div class="row justify-content-center text-center">
    <!-- mehrere Leerzeilen -->
    <h1 class="text-center mt-3"><b>Temperaturüberwachung WEB</b></h1>

    <div class="card-container row">
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
                    <div class="circle-temp"></div>
                    <div class="my-circle">
                        <h1 class="Temp_Text">${sensor.currentTemperature}°C</h1>
                    </div>
                    <div class="circle-container-bottom"></div>
                </div>
            </div>
            <div class="mt-3 Max_Min_Temp">
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
                <div class="d-flex align-items-center">
                    <div class="bullet-item bg-primary-subtle me-2"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.:</h6>
                    <h6 class="text-body fw-semibold mb-0">${sensor.avgTemp}°C</h6>
                </div>
            </div>
            <button class="btn btn-primary card_User_Temp_history w-100" autofocus type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-${sensor.id}" aria-expanded="false" aria-controls="collapse-${sensor.id}">
                Temperatur Log
            </button>
            <div style="min-height: 120px;">
                <div class="collapse collapse-horizontal" id="collapse-${sensor.id}">
                    <div class="card card-body" style="width: 300px; top: 100px; z-index:250">
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
                                    <tr>
                                        <td>${temp.created_at}</td>
                                        <td>${temp.time}</td>
                                        <td>${temp.temperature}°C</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h6 class="Text-center"><b>Hersteller: ${sensor.manufacturer} </b></h6>`;
                // Append the card to the container
                container.appendChild(card);

                const circle = card.querySelector('.circle-temp');

                if (circle) {
                    const currentTemp = sensor.currentTemperature;
                    const maxTemp = sensor.maxTemp;
                    const minTemp = sensor.minTemp;

                    let procent = ((currentTemp - minTemp) / (maxTemp - minTemp)) * 100;

                        if (procent > 100) procent = 100;
                        if (procent < 0) procent = 100;

                        const angle = procent * 1.8;
                        circle.style.transform =`rotate(${angle}deg)`;  
                    // to hot?
                    if (currentTemp > maxTemp) {
                        circle.style.backgroundColor = "#ff1f1f";
                    }
                    // to cold?
                    else if (currentTemp < minTemp) {
                        circle.style.backgroundColor = "#1fbcff";
                    }
                    // perfect?
                    else {
                        circle.style.backgroundColor = "#4bd31f";
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });


  </script>
</body>
</html>
