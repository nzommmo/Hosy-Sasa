<?php
// Include the config.php file to establish database connection
include_once "../config.php";

// Start PHP session
session_start();

// Check if user is not logged in, redirect to login page or display message
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display message
    header("Location: ../login.php"); // Change 'login.php' to your actual login page
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user's vital signs from the database based on user ID
$sql_vital_signs = "SELECT * FROM vital_signs WHERE patient_id = $user_id";
$result_vital_signs = $conn->query($sql_vital_signs);

// Check if there are any vital signs
if ($result_vital_signs->num_rows > 0) {
    // Initialize an empty array to store vital signs
    $vital_signs = array();

    // Loop through the fetched vital signs and store them in the array
    while ($row = $result_vital_signs->fetch_assoc()) {
        $vital_signs[] = $row;
    }
} else {
    // No vital signs found, display a message
    $vital_signs = array(); // Empty array
    $error_message = "No vital signs found for the user.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vital Signs</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Vital Signs</h2>
        <?php if (!empty($error_message)): ?>
            <p><?php echo $error_message; ?></p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sign ID</th>
                        <th>Patient ID</th>
                        <th>Sign Date</th>
                        <th>Sign Name</th>
                        <th>Sign Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vital_signs as $sign): ?>
                        <tr>
                            <td><?php echo $sign['sign_id']; ?></td>
                            <td><?php echo $sign['patient_id']; ?></td>
                            <td><?php echo $sign['sign_date']; ?></td>
                            <td><?php echo $sign['sign_name']; ?></td>
                            <td><?php echo $sign['sign_value']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
