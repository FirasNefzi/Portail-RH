<?php
require_once "config.php";
$conn = Config::getConnexion();

// Check if Matricule is present in the URL
if (!isset($_GET['Matricule'])) {
    header("Location: error_page.php");
    exit;
}

$Matricule = filter_var($_GET['Matricule'], FILTER_SANITIZE_NUMBER_INT);


// Get the employee ID from the URL and sanitize it

// Select the employee information from the database
$sql = "SELECT * FROM pointage WHERE Matricule = :Matricule";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':Matricule', $Matricule, PDO::PARAM_INT);
$stmt->execute();

// Check if any employee found with the given Matricule
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $date_pointage = $row['date_pointage'];
    $Date_entre = $row['Date_entre'];
    $date_sortie = $row['date_sortie'];
} else {
    header("Location: error_page.php");
    exit;
}

$sql2 = "SELECT * FROM conge WHERE Matricule = :Matricule";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':Matricule', $Matricule, PDO::PARAM_INT);
$stmt2->execute();

if ($stmt2->rowCount() > 0) {
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $nombre = $row['nombre'];
} else {
    header("Location: admin_page.php");
    exit;
}

if ($_POST) {
    // Get the updated information from the form
    $date_pointage = $_POST['date_pointage'];
    $Date_entre = $_POST['Date_entre'];
    $date_sortie = $_POST['date_sortie'];
    $nombre = $_POST['nombre'];

    // Update the employee information in the database
    $sql = "UPDATE pointage SET date_pointage=:date_pointage, Date_entre=:Date_entre, date_sortie=:date_sortie WHERE Matricule=:Matricule";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date_pointage', $date_pointage, PDO::PARAM_STR);
    $stmt->bindParam(':Date_entre', $Date_entre, PDO::PARAM_STR);
    $stmt->bindParam(':date_sortie', $date_sortie, PDO::PARAM_STR);
    $stmt->bindParam(':Matricule', $Matricule, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0 || $stmt2->rowCount() > 0) {
        $ktiba = "Employee information updated successfully.";
    } else {
        $ktiba = "No changes made to the employee information.";
    }
}

$conn = null;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body>
    <header>
        <h2 href="#">Portail_RH</h2>
        <nav>
            <li><a href="home.php">HOME</a> </li>
            <li><a href="http://www.arabsoft.com.tn/a-propos">ABOUT US</a> </li>
            <li><a href="logout_form.php">LOGOUT</a> </li>
            <li><a href="admin_page.php">GO BACK</a></li>

        </nav>
    </header>
    <br><br><br>
    <div class="login-box">
        <h2 class="text-warning">Edit Employer <?php echo $Matricule; ?></h2>
        <form action="edit_form.php?Matricule=<?php echo $Matricule; ?>" method="post">
            <label for="date_pointage">Date Pointage:</label>
            <div class="user-box">
                <input type="date" id="date_pointage" name="date_pointage" value="<?php echo $date_pointage; ?>">
            </div>
            <label for="date_entre">Date Entrer:</label>
            <div class="user-box">
                <input type="text" id="Date_entre" name="Date_entre" value="<?php echo $Date_entre; ?>">
            </div>

            <label for="date_sortie">Date Sortie:</label>
            <div class="user-box">
                <input type="text" id="date_sortie" name="date_sortie" value="<?php echo $date_sortie; ?>">
            </div>
            <label for="nombre">Conge (nombres des jours restants):</label>
            <div class="user-box">
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
            </div>
            <br>
            <?php
            if (isset($ktiba)) {
                echo "<p class='text-success'>$ktiba</p>";
            }
            ?>
            <input type="submit" value="Update" class="btn btn-primary">
        </form>
    </div>
</body>

</html>