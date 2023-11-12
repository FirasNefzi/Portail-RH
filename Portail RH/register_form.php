<?php
require_once "config.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pw = $_POST['password'];
    $name = $_POST['name'];
    $Lname = $_POST['last_name'];
    $cin = $_POST['cin'];

    try {
        $cnx = new PDO("mysql:host=localhost;dbname=portail_rh", 'root', '');
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }

    $sql = "INSERT INTO employer_form (email, password, name, lastname, cin) 
            VALUES (:email, :password, :name, :lastname, :cin)";
    $requete = $cnx->prepare($sql);
    $requete->bindParam(':email', $email);
    $requete->bindParam(':password', $pw);
    $requete->bindParam(':name', $name);
    $requete->bindParam(':lastname', $Lname);
    $requete->bindParam(':cin', $cin);

    try {
        $requete->execute();
        header('Location: login_form.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

include_once "layout.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body class="tasw"><br><br><br>
    <div class="login-container">
        <form method="post" action="register_form.php" class="form-login">
            <ul class="login-nav">
                <li class="login-nav__item ">
                    <a href="login_form.php">Sign In</a>
                </li>
                <li class="login-nav__item active">
                    <a href="register_form.php">Sign Up</a>
                </li>
            </ul>
            <label for="login-input-user" class="login__label">
                Email
            </label>
            <input id="login-input-user" class="login__input" type="email" name="email" required placeholder="Email" />
            <label for="login-input-password" class="login__label">
                Password
            </label>
            <input id="login-input-password" class="login__input" type="password" name="password" required placeholder="Password" />
            <label for="login-input-password" class="login__label">
                Name
            </label>
            <input id="login-input-name" class="login__input" type="text" name="name" required placeholder="Nom" />
            <label for="login-input-password" class="login__label">
                Last name
            </label>
            <input id="login-input-last-name" class="login__input" type="text" name="last_name" required placeholder="Prenom" />
            <label for="login-input-password" class="login__label">
                Carte identité
            </label>
            <input id="login-input-cin" class="login__input" type="number" name="cin" required placeholder="Cin" />

            <br><br>
            <button class="login__submit" type="submit" name="submit">Sign up</button>
        </form>
        <a href="#" class="login__forgot">Forgot Password?</a><br>
    </div><br>

</body>

</html>