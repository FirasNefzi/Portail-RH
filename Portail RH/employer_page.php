<?php
require_once "config.php";
$conn = Config::getConnexion();
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login_form.php");
    exit;
}

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM employer_form WHERE email = :email");
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header("Location: login_form.php");
    exit;
}

$name = $row['name'];
$Lname = $row['lastname'];
$password = $row['password'];
$cin = $row['cin'];
$mat = $row['Matricule'];

$congeResult = $conn->prepare("SELECT * FROM conge WHERE Matricule = :Matricule");
$congeResult->bindValue(':Matricule', $mat, PDO::PARAM_STR);
$congeResult->execute();
$row2 = $congeResult->fetch(PDO::FETCH_ASSOC);

if (!$row2) {
    $anne = null;
    $type = null;
    $nombre = null;
} else {
    $anne = $row2['anne'];
    $type = $row2['type'];
    $nombre = $row2['nombre'];
}

$pointageResult = $conn->prepare("SELECT * FROM pointage WHERE Matricule = :Matricule");
$pointageResult->bindValue(':Matricule', $mat, PDO::PARAM_STR);
$pointageResult->execute();
$row3 = $pointageResult->fetch(PDO::FETCH_ASSOC);

if (!$row3) {
    $date = null;
    $entre = null;
    $sortie = null;
    $Mentre = null;
    $Msortie = null;
} else {
    $date = $row3['date_pointage'];
    $entre = $row3['Date_entre'];
    $sortie = $row3['date_sortie'];
    $Mentre = $row3['ht_pointage'];
    $Msortie = $row3['mm_pointage'];
}




// message 



if (!isset($_SESSION['email'])) {
    header("Location: login_form.php");
    exit;
}

$email = $_SESSION['email'];

// Connect to database
require_once "config.php";
$conn = Config::getConnexion();

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get message and email from form
    $message = $_POST['message'];
    $sender = $_SESSION['email'];

    // Prepare and execute SQL statement to insert message
    $stmt = $conn->prepare("INSERT INTO employer_chat (sender, message) VALUES (:sender, :message)");
    $stmt->bindValue(':sender', $sender, PDO::PARAM_STR);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>employer page</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body class="tasw">
    <header>
        <h2 href="#">Portail_RH</h2>
        <nav>
            <li><a href="home.php">HOME</a> </li>
            <li><a href="http://www.arabsoft.com.tn/a-propos">ABOUT US</a> </li>
            <li><a href="logout_form.php">LOGOUT</a> </li>

        </nav>
    </header><br><br><br><br><br><br><br>
    <div class="container">
        <div class="content">
            <h1>Hello , <span class="text-muted"><?php echo $name ?></span> ! And welcome to our page</h1><br><br>
            <p class="text-muted">Welcome to the employer page! This is where you can access all of your important information and statistics as an employer. Here, you will be able to check your current stats, such as the number of employees you have under your management, as well as important information like your contact details and company information. You can also access the tools you need to manage your employees, such as the ability to view employee information, create schedules, and approve or deny time off requests. With this page, you will have everything you need to effectively manage your employees and your business.</p>
        </div>
        <br><br>
        <h1>Employer Chat</h1><br>
        <div id="chat-box" class="alert alert-dismissible alert-secondary">
            <!-- Display messages from database -->
            <?php
            $stmt = $conn->prepare("SELECT * FROM employer_chat ORDER BY Matricule DESC");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<p><strong>" . $name . ":</strong> " . $row['message'] . "</p>";
            }
            ?>
        </div>

        <form action="" method="post">
            <div class="talkbubble">
                <textarea name="message" placeholder="Type your message here"></textarea>
            </div><br>
            <input type="submit" name="submit" class="btn btn-primary" value="Send">
        </form>
        <br><br>
    </div>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Info
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card mb-3">
                        <h3 class="card-header"><?php echo $name . " " . $Lname ?></h3>
                        <div class="card-body">
                            <h5 class="card-title">employer in arabsoft</h5>
                            <h6 class="card-subtitle text-muted">Works in ...</h6>
                        </div>


                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Email : <?php echo $email ?></li>
                            <li class="list-group-item">Password : <?php echo $password ?></li>
                            <li class="list-group-item">Carte d'identiter : <?php echo $cin ?></li>
                        </ul>
                        <div class="card-footer text-muted">
                            Last checked 2 days ago
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Conge
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>You have only <?php echo $nombre ?> days left</strong><br>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"><strong><?php echo $nombre ?></strong></div>
                    </div><br>
                    <table class="table table-hover">
                        <tr>
                            <th>year</th>
                            <th>type</th>
                        </tr>
                        <tr>
                            <td><?php echo $anne ?></td>
                            <td><?php echo $type ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    pointage
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Date</th>
                            <th>heure d'entrer</th>
                            <th>heure de sortie</th>
                        </tr>
                        <tr>
                            <td><?php echo $date ?> </td>
                            <td><?php echo $entre ?> H <?php echo $Mentre ?> M</td>
                            <td><?php echo $sortie ?> H <?php echo $Msortie ?> M</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Get all accordion buttons
        var accordionButtons = document.querySelectorAll('.accordion-button');

        // Add click event listener to each accordion button
        // Add click event listener to each accordion button
        for (var i = 0; i < accordionButtons.length; i++) {
            accordionButtons[i].addEventListener('click', function() {
                // Toggle the "collapsed" class on the clicked button
                this.classList.toggle('collapsed');

                // Get the target collapse element using the data-bs-target attribute
                var targetId = this.getAttribute('data-bs-target');
                var targetCollapse = document.querySelector(targetId);

                // Toggle the "show" class on the target collapse element
                targetCollapse.classList.toggle('show');
            });
        }
    </script>




</body>

</html>