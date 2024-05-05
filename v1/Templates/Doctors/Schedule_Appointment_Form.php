<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Retrieve user_id from the session
$user_id = $_SESSION['user_id'];
//var_dump($user_id);

//Retrieving the doctor's ID
$sql = "SELECT doctor_id FROM Doctors WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$doctor_id = $row['doctor_id'];
//var_dump($doctor_id);


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //var_dump($_POST);

    // Validate form data (you can add more validation as needed)
    $PatientID = $_POST['PatientID'];
    $startTime = $_POST['start_datetime'];
    $endTime = $_POST['end_datetime'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    //$doctor_id = $_POST['Doctor_id'];



    // Insert the lab results into the database
    $sql = "INSERT INTO schedule (patient_id, start_datetime, end_datetime,Title,Description,doctor_id) 
    VALUES ('$PatientID', '$startTime', '$endTime','$Title','$Description','$doctor_id')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Appointment Scheduled successfully.";
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
    }

  
}
//var_dump($user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Lab Results</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../Static/patients.css">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Lab Results Form -->
    <div class="container mt-5">
        <h2>Record Lab Results</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <input type="hidden" name="Doctor_id" value="<?php echo $doctor_id; ?>">
                <label for="PatientID" class="form-label">Patient ID:</label>
                <input type="text" class="form-control" id="PatientID" name="PatientID" required>
            </div>
            <div class="mb-3">
                <label for="start_datetime" class="form-label">Start Time:</label>
                <input type="datetime-local" class="form-control" id="start_datetime" name="start_datetime" required>
            </div>
        
            <div class="mb-3">
                <label for="end_datetime" class="form-label">End Time:</label>
                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" required>
            </div>
            <div class="mb-3">
                <label for="Title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="Title" name="Title" required>
            </div>
            <div class="mb-3">
                <label for="Description" class="form-label">Description:</label>
                <input type="text" class="form-control" id="Description" name="Description" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
