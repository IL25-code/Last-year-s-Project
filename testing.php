<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="testing.css">
    <script src="testing.js"></script>
    <title>Testing</title>
</head>

<body>
    <div class="center">
        <button id="login">Login</button>
    </div>
    <div class="popups">
        <div class="popup_windows">
            <button class="close_button">&times;</button>
        </div>
        <div class="form">
            <h2>Login</h2>
            <div class="form-element">
                <input type="text" id="email" placeholder="Enter Email">
            </div>
            <div class="form-element">
                <input type="text" id="password" placeholder="Enter Password">
            </div>
            <div class="form-element">
                <input type="checkbox" id="remember_me" placeholder="Remember_me">
            </div>
            <div class="form-element">
                <button>Sign in</button>
            </div>
            <div class="form-element">
                <a href="#">Forgot Password</a>
            </div>
        </div>
    </div>
    <script>
        document.querySelector("#login").addEventListener("click", function() {
            document.querySelector(".popups").classList.add("active");
        });

        document.querySelector(".popups .close_button").addEventListener("click", function() {
            document.querySelector(".popups").classList.remove("active");
        });
    </script>
</body>

</html>