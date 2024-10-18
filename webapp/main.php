<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temperaturüberwachung</title>
		
		<style>
			.circle-container {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      background-color: #eee;
      position: relative; 
			}
			
			.circle {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      background-color: white; /* Ändere die Farbe nach Bedarf */
      position: absolute;
      top: 25px;
      left: 25px;
			/* mask-image: conic-gradient(from -90deg, white, white 180deg, transparent 180deg, transparent 360deg) */
			}
			
			p.solid {border-style: solid;}
		</style>
		
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	</head>
  <body>
		<style> .Border { width: 250px;
			height: 420px;
			border: 3px solid black;
			padding: 25px;
			margin: 10px;} 
		</style>
		
		<div class="row justify-content-center text-center">
		<div class="Border"> 
			<div><h5 class="mb-2">Server: </h5>
				<h6 class="text-body-tertiary">Temperatur</h6>
			</div>
			
			<div class="d-flex justify-content-left pt-3 flex-1">
				<canvas style="position: absolute; left: 0px; top: 0px; width: 144px; height: 144px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="668" height="180"></canvas>
				<div <div class="circle-container">
					<div class="circle" id="myCircle">
					</div>
				</div>
				<script>
					// Hier definieren wir die Variable, die den Füllstand bestimmt
					let progress = 75; // Wert zwischen 0 und 100
					
					// Hole das Element mit der ID "myCircle"
					const circle = document.getElementById('myCircle');
					
					// Berechne die Breite des Kreises basierend auf dem Fortschritt
					const newWidth = (progress / 100) * 150;
				
					// Setze die Breite des Kreises
					circle.style.width = newWidth + 'px';
				
					/*setInterval(() => {
					progress++;
					if (progress > 100) {
					progress = 0;
					}
					const newWidth = (progress / 100) * 150;
					circle.style.width = new	Width + 'px';
					}, 100); */ // Ändert den Wert alle 100 Millisekunden
				</script> <! Hier kommt die Grafik rein !>
			</div>
				
				
			<div class="mt-3">
				<div class="d-flex align-items-center mb-2">
					<div class="bullet-item bg-primary me-2">
					</div>
					<h6 class="text-body fw-semibold flex-1 mb-0">Maximal Temperatur: &nbsp </h6> <! Das ist für den Text der Max. Temp das &nbsp macht das Leerzeichen zwischen der Temp und dem : !> 
					<h6 class="text-body fw-semibold mb-0">30°C</h6>
				</div>
				<div class="d-flex align-items-center">
					<div class="bullet-item bg-primary-subtle me-2">
					</div><h6 class="text-body fw-semibold flex-1 mb-0">Minimal Temperatur: &nbsp </h6> <!Das ist für den Text der Min. Temp das &nbsp macht das Leerzeichen zwischen der Temp und dem : !>
					<h6 class="text-body fw-semibold mb-0">0°C</h6>
				</div>
			</div>
		</div>
		
		<! Hier ist die 2 Box !>
		<div class="Border">
		
			<div><h5 class="mb-2">Server: </h5>
				<h6 class="text-body-tertiary">Temperatur</h6>
			</div>
			
			<div class="d-flex justify-content-left pt-3 flex-1">
				<canvas style="position: absolute; left: 0px; top: 0px; width: 144px; height: 144px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="668" height="180"></canvas>
				<div <div class="circle-container">
					<div class="circle" id="myCircle">
					</div>
				</div>
				<script>
					// Hier definieren wir die Variable, die den Füllstand bestimmt
					let progress = 75; // Wert zwischen 0 und 100
					
					// Hole das Element mit der ID "myCircle"
					const circle = document.getElementById('myCircle');
					
					// Berechne die Breite des Kreises basierend auf dem Fortschritt
					const newWidth = (progress / 100) * 150;
				
					// Setze die Breite des Kreises
					circle.style.width = newWidth + 'px';
				
					setInterval(() => {
					progress++;
					if (progress > 100) {
					progress = 0;
					}
					const newWidth = (progress / 100) * 150;
					circle.style.width = newWidth + 'px';
					}, 100); // Ändert den Wert alle 100 Millisekunden
				</script> <! Hier kommt die Grafik rein !>
			</div>
				
				
			<div class="mt-3">
				<div class="d-flex align-items-center mb-2">
					<div class="bullet-item bg-primary me-2">
					</div>
					<h6 class="text-body fw-semibold flex-1 mb-0">Maximal Temperatur: &nbsp </h6> <! Das ist für den Text der Max. Temp das &nbsp macht das Leerzeichen zwischen der Temp und dem : !> 
					<h6 class="text-body fw-semibold mb-0">30°C</h6>
				</div>
				<div class="d-flex align-items-center">
					<div class="bullet-item bg-primary-subtle me-2">
					</div><h6 class="text-body fw-semibold flex-1 mb-0">Minimal Temperatur: &nbsp </h6> <!Das ist für den Text der Min. Temp das &nbsp macht das Leerzeichen zwischen der Temp und dem : !>
					<h6 class="text-body fw-semibold mb-0">0°C</h6>
				</div>
			</div>
		</div>
		</div>
	</body>
</html>				