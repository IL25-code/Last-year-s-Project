<?php
    session_start();
    $_SESSION["db_connection"]= new Connection();
    $conn = $_SESSION["db_connection"]->connect();

    function isCodeValid($conn,$code){
        $codes=$_SESSION['db_connection']->select_queries($conn,"SELECT code from companies");
        foreach($codes as $n){
            if($n==$code){
                return true;
            }
        }
        return false;
    }

    function isEmailValid($conn,$email){
        $emails=$_SESSION['db_connection']->select_queries($conn,"SELECT email from users");
        foreach($emails as $n){
            if($n==$email){
                return true;
            }
        }
        return false;
    }

    function isPasswordValid($conn,$email,$password){
        $passwords=$_SESSION['db_connection']->select_queries($conn,"SELECT password from users where email='".$email."'");
        foreach($passwords as $n){
            if($n==$password){
                return true;
            }
        }
        return false;
    }
    
    if(isset($_POST['signup'])){
        if(isCodeValid($conn,$_POST['company_code']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            if($_SESSION['db_connection']->dml_query($conn,"INSERT INTO users (username, email, password, name, surname, fiscal_code, birth_date, company) VALUES ('" . $_POST['username'] . "', '" . $_POST['email'] . "', '" . $_POST['password'] . "', '" . $_POST['name'] . "', '" . $_POST['surname'] . "', '" . $_POST['fiscal_code'] . "', '" . $_POST['birthdate'] . "', '" . $_POST['company_code'] . "')")){
                echo "error";
            }
        }
    }
    if(isset($_POST['login'])){
        
    }
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
            <form method="POST">
                <label for="chk" aria-hidden="true">Sign Up</label>
                <input type="text" name="username" placeholder="Username" required="">
                <input type="text" name="email" placeholder="E-mail" required="">
                <input type="text" name="password" placeholder="Password" required="">
                <input type="text" name="name" placeholder="Name" required="">
                <input type="text" name="surname" placeholder="Surname" required="">
                <input type="text" name="fiscal_code" placeholder="Fiscal Code" required="">
                <input type="text" name="birthdate" placeholder="Birth Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                <input type="text" name="company_code" placeholder="Employee Code" required="">
                <button name="signup">Sign Up</button>
            </form>
        </div>

        <div class="login">
            <form method="POST">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="email" placeholder="E-mail" required="">
                <input type="text" name="password" placeholder="Password" required="">
                <button name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>