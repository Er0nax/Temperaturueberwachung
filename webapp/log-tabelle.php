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

  <a data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4 login-btn" href="index.php">zurück</a>


  <script>

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
          });
      })
      .catch(error => {
          console.error('Error:', error);
      });


  </script>


</body>

</html>
