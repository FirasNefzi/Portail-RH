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
        $stmt->execute();

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
</head>

<body>
    <section class="contact" id="contact">
        <h2 class="text-secondary">Contact us</h2>
        <p class="text-secondary">For any inquiries or support, please feel free to contact us.</p>
        <hr>

        <form action="home.php" method="post">
            <input type="email" placeholder="Email" name="email">
            <textarea name="message" id="" cols="60" rows="2" placeholder=" Text here"></textarea>
            <button type="submit" class="btn">Send now</button>
        </form>
        <?php
        if (isset($res)) {
            echo "<p style='text-align: center;' class='text-danger'>$res</p>";
        }
        ?>

    </section>
</body>

</html>