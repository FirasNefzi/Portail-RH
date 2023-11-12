<?php
// Start the session

require_once "config.php";
$conn = Config::getConnexion();

// Connect to the database using the $conn object
try {
    // No need to create a new variable $db
    // $db = $conn;
} catch (PDOException $e) {
    echo "Error connecting to the database: " . $e->getMessage();
    exit;
}

// Check if the form was submitted
if (isset($_POST["submit"])) {
    // Update the employee information in the database
    $query = "UPDATE conge SET nombre = :nombre WHERE Matricule = :Matricule";
    $query2 = "UPDATE pointage SET date_pointage = :date_pointage, date_entrer = :date_entrer, date_sortie = :date_sortie WHERE Matricule = :Matricule";
    $stmt = $conn->prepare($query);
    $stmt2 = $conn->prepare($query2);
    $stmt->bindParam(":nombre", $_POST["nombre"]);
    $stmt2->bindParam(":date_pointage", $_POST["date_pointage"]);
    $stmt2->bindParam(":date_entrer", $_POST["date_entrer"]);
    $stmt2->bindParam(":date_sortie", $_POST["date_sortie"]);
    $stmt2->bindParam(":Matricule", $_POST["Matricule"]);
    $stmt->bindParam(":Matricule", $_POST["Matricule"]);
    $result = $stmt->execute();
    $result2 = $stmt2->execute();
    if ($result && $result2) {
        echo "Employee information updated successfully!";
    } else {
        echo "Error updating employee information.";
    }
}

// Get the employee information from the database
// Get the employee information from the database
$query = "SELECT c.Matricule, c.nombre, e.name, e.lastname, p.date_pointage, p.date_entre, p.date_sortie FROM conge c JOIN pointage p ON c.Matricule = p.Matricule JOIN employer_form e ON c.Matricule = e.Matricule";
$stmt = $conn->prepare($query);
$stmt->execute();
$num_rows = $stmt->rowCount();
$employees = $stmt->fetchAll();

?>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body>
    <header>
        <h2 href="#">Portail_RH</h2>
        <nav>
            <li><a href="home.php">HOME</a> </li>
            <li><a href="http://www.arabsoft.com.tn/a-propos">ABOUT US</a> </li>
            <li><a href="logout_form.php">LOGOUT</a> </li>

        </nav>
    </header>
    <br><br><br><br><br><br><br><br>
    <h1 style="text-align: center;" class="hero-content-area">Admin Page</h1>
    <br><br><br><br>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>name</th>
            <th>Last name</th>
            <th>Nombre des jours (congé)</th>
            <th>Date Pointage</th>
            <th>Date d'entrer</th>
            <th>Date Sortie</th>
            <th>Edit</th>
        </tr>
        <?php foreach ($employees as $employee) : ?>
            <tr>
                <td><?= $employee["Matricule"] ?></td>
                <td><?= $employee["name"] ?></td>
                <td><?= $employee["lastname"] ?></td>
                <td><?= $employee["nombre"] ?></td>
                <td><?= $employee["date_pointage"] ?></td>
                <td><?= $employee["date_entre"] ?></td>
                <td><?= $employee["date_sortie"] ?></td>
                <td><a href="edit_form.php?Matricule=<?= $employee["Matricule"] ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>