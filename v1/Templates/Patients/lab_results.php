<?php
// Include the config.php file to establish database connection
include_once "config.php";

// Start PHP session
session_start();

// Check if user is not logged in, redirect to login page or display message
if (!isset($_SESSION['username'])) {
    // Redirect to login page or display message
    header("Location: ../login.php"); // Change 'login.php' to your actual login page
    exit();
}

// Retrieve username from the session
$username = $_SESSION['username'];

// Retrieve medical records from the database
$medical_records = [];
$stmt = $pdo->prepare("SELECT * FROM medical_records");
$stmt->execute([$username]); // Pass username as a parameter to prevent SQL injection
$medical_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
</head>
<body>

<h1>Welcome, <?php echo $username; ?>!</h1>
<p>This is a simple welcome page.</p>
<p>You can customize this page according to your needs.</p>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medical_records as $record): ?>
            <tr>
                <td><?php echo $record['title']; ?></td>
                <td><?php echo $record['description']; ?></td>
                <td><?php echo $record['date']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
