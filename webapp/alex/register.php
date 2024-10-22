<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrieren Temperaturüberwachung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/css/register.css" rel="stylesheet">
</head>
<body>

  <center> <br> <b> <h1> Register </h1> </b> </br> </center>

  <center><div class="card-border row col-3 mt-5">
    <form>
    <!-- Email input -->
    <div data-mdb-input-init class="form-outline mb-4">
      <input type="Username" id="form2Example1" class="form-control" />
      <label class="form-label" for="form2Example1">Username</label>
    </div>

    <!-- Password input -->
    <div data-mdb-input-init class="form-outline mb-4">
      <input type="password" id="form2Example2" class="form-control" />
      <label class="form-label" for="form2Example2">Password</label>
    </div>

    <!-- Password wdh -->
    <div data-mdb-input-init class="form-outline mb-4">
      <input type="password" id="form2Example2" class="form-control" />
      <label class="form-label" for="form2Example2">confirm Password</label>
    </div>

    <!-- 2 column grid layout for inline styling -->
    <!-- <div class="row mb-4">
      <div class="col d-flex justify-content-center">
         Checkbox
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
          <label class="form-check-label" for="form2Example31"> Remember me </label>
        </div>
      </div>
    </div> -->

    <!-- Submit button -->
  <p> <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Register</button> </p>

    <a href="login.php"> abbrechen </a>

  </form>
</div></center>
</html>
