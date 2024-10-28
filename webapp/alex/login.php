<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Temperaturüberwachung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>

<center>
    <p class="text-center mt-3"><b><h1> Login </h1></b></p>
</center>

<center>
    <div class="card-border row col-3 mt-5">
        <form>
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="Username" name="username" class="form-control"/>
                <label class="form-label" for="form2Example1">Username</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password" class="form-control"/>
                <label class="form-label" for="form2Example2">Password</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember_me" checked/>
                        <label class="form-check-label" for="remember_me"> Remember me </label>
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4 login-btn">Sign in</button>

            <div class="row">
                <p id="errorMsg" style="color: orangered;"></p>
            </div>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="register.php">Register</a></p>
            </div>

            <a href="index.php"> abbrechen </a>

        </form>

    </div>
</center>

<script>

    const login_btn = document.querySelector(".login-btn");

    if (login_btn) {
        login_btn.addEventListener("click", (e) => {
            e.preventDefault();

            const username = document.querySelector("input[name='username']").value;
            const password = document.querySelector("input[name='password']").value;
            const errorMsg = document.getElementById("errorMsg");

            const url = 'http://localhost/temperaturueberwachung/api/web/user/login'; // Ersetze diese URL durch die tatsächliche API-URL

            const formData = new FormData();
            formData.append('username', username);
            formData.append('password', password);

            fetch(url, {
                method: 'POST',
                body: formData,
            }).then(response => {
                return response.json();
            }).then(data => {

                // success?
                if (data.status === 200) {
                    const cookieName = "api_token";
                    const cookieValue = data.response.info.token;

                    // remember me checked?
                    if (document.getElementById("remember_me").checked) {
                        // save token for 1 week
                        const today = new Date();
                        const expire = new Date();
                        expire.setTime(today.getTime() + 3600000 * 24 * 7);
                        document.cookie = cookieName + "=" + encodeURI(cookieValue) + ";expires=" + expire.toGMTString();
                    } else {
                        // save cookie only for session
                        document.cookie = cookieName + "=" + encodeURI(cookieValue);
                    }

                    // redirect to dashboard
                    location.href = "index.php";
                }
                //error
                else {
                    if (errorMsg) {
                        errorMsg.innerText = data.response.message;
                    }
                }
            });
        });
    }

</script>

</body>
</html>
