<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temperaturüberwachung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<a href="login.php" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4 card_User_Login"> <h4> Login </h4> </a>

<div class="row justify-content-center text-center">
      <!-- mehrere Leerzeilen -->
    <p class="text-center mt-3"><b> <h1> Temperaturüberwachung WEB </h1> </b></p>

    <div class="card-border mt-4">
      <div><h5 class="mb-2">Server: </h5>
          <h6 class="text-body-tertiary">Temperatur</h6>
      </div>

      <div class="d-flex justify-content-left pt-3 flex-1">
          <canvas style="position: absolute; left: 0; top: 0; width: 144px; height: 144px; user-select: none; padding: 0; margin: 0; border-width: 0px;" data-zr-dom-id="zr_0" width="668"
                  height="180"></canvas>
          <div
          <div class="circle-container">
              <div class="circle-temp">
              </div>
              <div class="my-circle">
                  <h1 class="Temp_Text"> 37 °C </h1>
              </div>
              <div class="circle-container-bottom">
              </div>
          </div>
      </div>

      <div class="mt-3 Max_Min_Temp">
          <div class="d-flex align-items-center mb-2">
              <div class="bullet-item bg-primary me-2">
              </div>
              <h6 class="text-body fw-semibold flex-1 mb-0">Max. Temp.: &nbsp</h6>
              <h6 class="text-body fw-semibold mb-0">30°C</h6>
          </div>
          <div class="d-flex align-items-center mb-2">
              <div class="bullet-item bg-primary-subtle me-2">
              </div>
              <h6 class="text-body fw-semibold flex-1 mb-0">Min. Temp.: &nbsp</h6>
              <h6 class="text-body fw-semibold mb-0">0°C</h6>
          </div>
          <div class="d-flex align-items-center">
              <div class="bullet-item bg-primary-subtle me-2">
              </div>
              <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.: &nbsp</h6>
              <h6 class="text-body fw-semibold mb-0">10°C</h6>
          </div>
      </div>

      <button class="btn btn-primary card_User_Temp_history" autofocus type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
          Temperatur Log
        </button>
      <div style="min-height: 120px;">
        <div class="collapse collapse-horizontal" id="collapseWidthExample">
          <div class="card card-body" style="width: 300px; top: 100px;">

            <table id="temperatureTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Temperature</th>
                        </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

          </div>
        </div>
      </div>

    </div>
    <div class="card-border mt-4">
        <div><h5 class="mb-2">Server: </h5>
            <h6 class="text-body-tertiary">Temperatur</h6>
        </div>

        <div class="d-flex justify-content-left pt-3 flex-1">
            <canvas style="position: absolute; left: 0; top: 0; width: 144px; height: 144px; user-select: none; padding: 0; margin: 0; border-width: 0px;" data-zr-dom-id="zr_0" width="668"
                    height="180"></canvas>
            <div
            <div class="circle-container">
                <div class="circle-temp">
                </div>
                <div class="my-circle">
                    <h1 class="Temp_Text"> 37 °C </h1>
                </div>
                <div class="circle-container-bottom">
                </div>
            </div>
        </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Max. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Min. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">10°C</h6>
            </div>
        </div>
    </div>
    <div class="card-border mt-4">
        <div><h5 class="mb-2">Server: </h5>
            <h6 class="text-body-tertiary">Temperatur</h6>
        </div>

        <div class="d-flex justify-content-left pt-3 flex-1">
            <canvas style="position: absolute; left: 0; top: 0; width: 144px; height: 144px; user-select: none; padding: 0; margin: 0; border-width: 0px;" data-zr-dom-id="zr_0" width="668"
                    height="180"></canvas>
            <div
            <div class="circle-container">
                <div class="circle-temp">
                </div>
                <div class="my-circle">
                    <h1 class="Temp_Text"> 37 °C </h1>
                </div>
                <div class="circle-container-bottom">
                </div>
            </div>
        </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Max. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Min. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">10°C</h6>
            </div>
        </div>
    </div>
    <div class="card-border mt-4">
        <div><h5 class="mb-2">Server: </h5>
            <h6 class="text-body-tertiary">Temperatur</h6>
        </div>

        <div class="d-flex justify-content-left pt-3 flex-1">
            <canvas style="position: absolute; left: 0; top: 0; width: 144px; height: 144px; user-select: none; padding: 0; margin: 0; border-width: 0px;" data-zr-dom-id="zr_0" width="668"
                    height="180"></canvas>
            <div
            <div class="circle-container">
                <div class="circle-temp">
                </div>
                <div class="my-circle">
                    <h1 class="Temp_Text"> 37 °C </h1>
                </div>
                <div class="circle-container-bottom">
                </div>
            </div>
        </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Max. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Min. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">10°C</h6>
            </div>
        </div>
    </div>
    <div class="card-border mt-4">
        <div><h5 class="mb-2">Server: </h5>
            <h6 class="text-body-tertiary">Temperatur</h6>
        </div>

        <div class="d-flex justify-content-left pt-3 flex-1">
            <canvas style="position: absolute; left: 0; top: 0; width: 144px; height: 144px; user-select: none; padding: 0; margin: 0; border-width: 0px;" data-zr-dom-id="zr_0" width="668"
                    height="180"></canvas>
            <div
            <div class="circle-container">
                <div class="circle-temp">
                </div>
                <div class="my-circle">
                    <h1 class="Temp_Text"> 37 °C </h1>
                </div>
                <div class="circle-container-bottom">
                </div>
            </div>
        </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Max. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Min. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">10°C</h6>
            </div>
        </div>
    </div>
    <div class="card-border mt-4">
        <div><h5 class="mb-2">Server: </h5>
            <h6 class="text-body-tertiary">Temperatur</h6>
        </div>

        <div class="d-flex justify-content-left pt-3 flex-1">
            <canvas style="position: absolute; left: 0; top: 0; width: 144px; height: 144px; user-select: none; padding: 0; margin: 0; border-width: 0px;" data-zr-dom-id="zr_0" width="668"
                    height="180"></canvas>
            <div
            <div class="circle-container">
                <div class="circle-temp">
                </div>
                <div class="my-circle">
                    <h1 class="Temp_Text"> 37 °C </h1>
                </div>
                <div class="circle-container-bottom">
                </div>
            </div>
        </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Max. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Min. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Durchs. Temp.: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">10°C</h6>
            </div>
        </div>
    </div>

    <script>

        const circles = document.querySelectorAll('.circle-temp');
        const temperature = 37; // Assuming temperature in Celsius

        function rotateCircle() {
            circles.forEach((circle) => {
                const angle = temperature * 1.8; // Adjust factor for desired rotation range
                circle.style.transform = `rotate(${angle}deg)`;
            });
            requestAnimationFrame(rotateCircle);
        }

        rotateCircle();


        const url = "http://localhost/temperaturueberwachung/api/web/sensor/all";

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Failed to fetch data. Status code: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Access the sensors array from the JSON response
                const sensors = data.response;

                // Loop through each sensor
                sensors.forEach(sensor => {
                    console.log(`Sensor ID: ${sensor.id}`);
                    console.log(`Name: ${sensor.name}`);
                    console.log(`Current Temperature: ${sensor.currentTemperature}`);
                    console.log(`Manufacturer: ${sensor.manufacturer}`);
                    console.log('---');

                    // If you want to loop through the temperatures of each sensor:
                    sensor.temperatures.forEach(temp => {
                        console.log(`Temperature ID: ${temp.id}, Temperature: ${temp.temperature}`);
                    });

                    console.log('=====================');
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });


    </script>
</body>
</html>
