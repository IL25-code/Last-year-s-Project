<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_page.css">
    <title>Login Page</title>
</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form action="">
                <label for="chk" aria-hidden="true">Sign Up</label>
                <input type="text" name="txt" placeholder="Username" required="">
                <input type="text" name="email" placeholder="E-mail" required="">
                <input type="text" name="password" placeholder="Password" required="">
                <button>Sign Up</button>
            </form>
        </div>

        <div class="login">
            <form action="">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="email" placeholder="E-mail" required="">
                <input type="text" name="password" placeholder="Password" required="">
                <button>Login</button>
            </form>
        </div>
    </div>
</body>
</html>