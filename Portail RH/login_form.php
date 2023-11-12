<?php
include_once "layout.php";
require_once "config.php";
$conn = Config::getConnexion();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM employer_form WHERE email = :email AND password = :password");
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $stmt = $conn->prepare("SELECT * FROM employer_form WHERE email = :email AND password = :password");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            // login success
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            header('Location: employer_page.php');
            exit;
        } elseif ($email == "admin@gmail.com" && $password == "admin123") {
            // admin login success
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            header('Location: admin_page.php');
            exit;
        } else {
            // login failed
            $error_message = "Invalid email or password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.css">
    <script>
        /* ------------------------------------ Click on login and Sign Up to  changue and view the effect
---------------------------------------
*/

        function cambiar_login() {
            document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_login";
            document.querySelector('.cont_form_login').style.display = "block";
            document.querySelector('.cont_form_sign_up').style.opacity = "0";

            setTimeout(function() {
                document.querySelector('.cont_form_login').style.opacity = "1";
            }, 400);

            setTimeout(function() {
                document.querySelector('.cont_form_sign_up').style.display = "none";
            }, 200);
        }

        function cambiar_sign_up(at) {
            document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_sign_up";
            document.querySelector('.cont_form_sign_up').style.display = "block";
            document.querySelector('.cont_form_login').style.opacity = "0";

            setTimeout(function() {
                document.querySelector('.cont_form_sign_up').style.opacity = "1";
            }, 100);

            setTimeout(function() {
                document.querySelector('.cont_form_login').style.display = "none";
            }, 400);


        }



        function ocultar_login_sign_up() {

            document.querySelector('.cont_forms').className = "cont_forms";
            document.querySelector('.cont_form_sign_up').style.opacity = "0";
            document.querySelector('.cont_form_login').style.opacity = "0";

            setTimeout(function() {
                document.querySelector('.cont_form_sign_up').style.display = "none";
                document.querySelector('.cont_form_login').style.display = "none";
            }, 500);

        }
    </script>
</head>

<body class="tasw">

    <br><br><br>
    <div class="login-container">
        <form action="" method="post" class="form-login">
            <ul class="login-nav">
                <li class="login-nav__item active">
                    <a href="login_form.php">Sign In</a>
                </li>
                <li class="login-nav__item">
                    <a href="register_form.php">Sign Up</a>
                </li>
            </ul>
            <label for="login-input-user" class="login__label">
                Email
            </label>
            <input id="login-input-user" class="login__input" type="email" name="email" required />
            <label for="login-input-password" class="login__label">
                Password
            </label>
            <input id="login-input-password" class="login__input" type="password" name="password" required />
            <label for="login-sign-up" class="login__label--checkbox">
                <input id="login-sign-up" type="checkbox" class="login__input--checkbox" required />
                Keep me Signed in
            </label>
            <?php
            if (isset($error_message)) {
                echo "<p style='text-align: center;' class='text-danger'>$error_message</p>";
            }
            ?>
            <button class="login__submit" type="submit" name="submit">Sign in</button>
        </form>
        <a href="#" class="login__forgot">Forgot Password?</a><br>
    </div><br>
</body>

</html>