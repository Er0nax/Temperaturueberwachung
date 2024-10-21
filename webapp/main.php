<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temperaturüberwachung</title>

    <style>
        .circle-container {
            width: 200px;
            height: 100px;
            border-radius: 200px 200px 0 0;
            background-color: #eee;
            z-index: 10;
            position: relative;
        }

        .my-circle {
            width: 150px;
            height: 75px;
            border-radius: 200px 200px 0 0;
            background-color: white; /* Ändere die Farbe nach Bedarf */
            z-index: 100;
            top: 25px;
            left: 25px;
            position: absolute;
            /* mask-image: conic-gradient(from -90deg, white, white 180deg, transparent 180deg, transparent 360deg) */
        }

        .circle-temp{
          width: 200px;
          height: 100px;
          border-radius: 200px 200px 0 0;
          background-color: green;
          z-index: 50;
          rotate: 180deg;
          transform-origin: 50% 100%;
          position: relative;
          animation: temperature * 1.8 linear; /* temperature * 1.8 muss ersetzt werden ist nur für berechnung für °C*/
        }

        @keyframes rotation {
          from {
            transform: rotate(0deg);
          }
          to {
            transform: rotate(180deg);
          }}

         .circle-container-bottom {
            width: 205px;
            height: 110px;
            border-radius: 200px 200px 0 0;
            background-color: white;
            z-index: 100;
            position: absolute;
            top: 100px;
            rotate: 180deg;
            /* mask-image: conic-gradient(from -90deg, transparent, transparent 180deg, transparent 180deg, transparent 360deg) */ */
        }

        p.solid {
            border-style: solid;
        }

        .card-border {
            width: 250px !important;
            height: 420px;
            border: 3px solid black;
            padding: 25px;
            margin: 10px;
        }

        .Max_Min_Temp{
          z-index: 200 !important;
          position: absolute;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    <p> <center> <b> <font size="7"> Temperaturüberwachung WEB </font> </b> </center> </p>

</head>
<body>

<div class="row justify-content-center text-center">
    <div class="card-border">
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
                <style>
                  .Temp_Text{
                  margin:20px 0px 0px 0px;
                  }
                </style>
                  <h1 class="Temp_Text">   37 °C </h1>
              </div>
              <div class="circle-container-bottom">
              </div>
            </div>
          </div>

        <div class="mt-3 Max_Min_Temp">
          <script>
            fetch('http://localhost/temperaturueberwachung/api/web/sensor/all')
              .then(response => response.json())
              .then(data => {
                const weatherElement = document.getElementById
              })
          </script>
          <div class="d-flex align-items-center mb-2">
            <div class="bullet-item bg-primary me-2">
            </div>
            <h6 class="text-body fw-semibold flex-1 mb-0">Maximal Temperatur: &nbsp</h6>
            <h6 class="text-body fw-semibold mb-0">30°C</h6>
          </div>
          <div class="d-flex align-items-center">
            <div class="bullet-item bg-primary-subtle me-2">
            </div>
            <h6 class="text-body fw-semibold flex-1 mb-0">Minimal Temperatur: &nbsp</h6>
            <h6 class="text-body fw-semibold mb-0">0°C</h6>
          </div>
      </div>
    </div>
    <div class="card-border">
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
                <style>
                  .Temp_Text{
                  margin:20px 0px 0px 0px;
                  }
                </style>
                  <h1 class="Temp_Text">   37 °C </h1>
              </div>
              <div class="circle-container-bottom">
              </div>
            </div>
          </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Maximal Temperatur: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Minimal Temperatur: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
            </div>
        </div>
    </div>
    <div class="card-border">
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
                <style>
                  .Temp_Text{
                  margin:20px 0px 0px 0px;
                  }
                </style>
                  <h1 class="Temp_Text">   37 °C </h1>
              </div>
              <div class="circle-container-bottom">
              </div>
            </div>
          </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Maximal Temperatur: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Minimal Temperatur: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
            </div>
        </div>
    </div>
    <div class="card-border">
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
                <style>
                  .Temp_Text{
                  margin:20px 0px 0px 0px;
                  }
                </style>
                  <h1 class="Temp_Text">   37 °C </h1>
              </div>
              <div class="circle-container-bottom">
              </div>
            </div>
          </div>

        <div class="mt-3 Max_Min_Temp">
            <div class="d-flex align-items-center mb-2">
                <div class="bullet-item bg-primary me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Maximal Temperatur: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">30°C</h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="bullet-item bg-primary-subtle me-2">
                </div>
                <h6 class="text-body fw-semibold flex-1 mb-0">Minimal Temperatur: &nbsp</h6>
                <h6 class="text-body fw-semibold mb-0">0°C</h6>
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

    </script>
  </body>
</html>
