<?php
session_start();
include_once "layout.php";
require_once "config.php";
$conn = Config::getConnexion();

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get message and email from form
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Check if email is valid
    if ($email === false) {
        echo '<p class="text-danger">Invalid email address</p>';
    } else {
        // Prepare and execute SQL statement to insert message
        $stmt = $conn->prepare("INSERT INTO contact (email, message) VALUES (:email, :message)");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $res = '<p class="text-success">Your message has been sent successfully</p>';
        } else {
            $res = '<p class="text-danger">Failed to send message</p>';
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
</head>

<body>


    <section class="hero">
        <div class="hero-content-area">
            <h1 class="text-warning">Portail RH</h1>
            <h3> Empowering People, Fueling Business Success: Your One-Stop Shop for Human Resource Management.</h3>
            <a href="#contact" class="btn" id="btnC">Contact Us</a>
        </div>

    </section>
    <br><br><br>
    <section class="destinations">
        <h3 class="title">Rest information about <span class="text-warning"> Portail_RH </span>:</h3>
        <p>Welcome to our Human Resources (HR) page! Our goal is to provide a centralized platform for all HR-related activities, making it easier for our employees and management to access important information and resources. Our HR page is designed to be user-friendly and easy to navigate, ensuring that employees can quickly and easily find what they need. Whether you're an employee looking for benefits information, or a manager looking for information on how to handle a personnel issue, our HR page has everything you need. In addition, we have provided a contact form in the footer of the page, so you can easily get in touch with our HR team if you have any questions or concerns. With our comprehensive HR page, managing human resources has never been easier!</p>
        <hr>

    </section>





    <section class="contact" id="contact">
        <h2 class="text-secondary">Contact us</h2>
        <p class="text-secondary">For any inquiries or support, please feel free to contact us.</p>
        <hr>

        <form action="home.php" method="post">
            <input type="email" placeholder="Email" name="email">
            <textarea name="message" id="" cols="60" rows="2" placeholder=" Text here"></textarea>
            <button type="submit" class="btn" name="submit">Send now</button>
        </form>

    </section>
    <footer>
        <ul>
            <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
            <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
            <li><a href="#"><i class="fa fa-snapchat-square"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest-square"></i></a></li>
            <li><a href="#"><i class="fa fa-github-square"></i></a></li>
        </ul>
        <p>Made by Firas nefzi</p>
        <p>© 2019 ARABSOFT. Tous droits réservés</p>
    </footer>

</body>

</html>