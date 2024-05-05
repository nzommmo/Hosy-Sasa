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
    $signname = $_POST['sign_name'];
    $signDate = $_POST['sign_date'];
   // $signvalue = $_POST['sign_value'];
    //$doctor_id = $_POST['Doctor_id'];

    // Get values for each vital sign
    $bodyTemperature = $_POST['sign_value_body_temperature'];
    $oxygenLevels = $_POST['sign_value_oxygen_levels'];
    $bloodPressure = $_POST['sign_value_blood_pressure'];


    // Insert the lab results into the database
    $sql = "INSERT INTO vital_signs (patient_id, sign_date, sign_name, sign_value, doctor_id) 
    VALUES ('$PatientID', '$signDate', 'Body Temperature', '$bodyTemperature', '$doctor_id'),
           ('$PatientID', '$signDate', 'Oxygen Levels', '$oxygenLevels', '$doctor_id'),
           ('$PatientID', '$signDate', 'Blood Pressure', '$bloodPressure', '$doctor_id')";


    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Vital Signs  recorded successfully.";
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
            <table class="table">
    <thead>
        <tr>
            <th>Vital Name</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
            <input type="text" class="form-control" id="sign_name" name="sign_name" value="Body Temperature" readonly>

            </td>
            <td>
                <input type="text" class="form-control" id="vital1" name="sign_value_body_temperature" required>
            </td>
        </tr>
        <tr>
            <td>
            <input type="text" class="form-control" id="sign_name" name="sign_name" value="Oxygen Levels" readonly>

            </td>
            <td>
                <input type="text" class="form-control" id="vital2" name="sign_value_oxygen_levels" required>
            </td>
        </tr>
        <tr>
            <td>
            <input type="text" class="form-control" id="sign_name" name="sign_name" value="Blood Pressure" readonly>

            </td>
            <td>
                <input type="text" class="form-control" id="vital3" name="sign_value_blood_pressure" required>
            </td>
        </tr>
    </tbody>
</table>


           
            <div class="mb-3">
                <label for="sign_date" class="form-label">Record Date:</label>
                <input type="date" class="form-control" id="sign_date" name="sign_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
