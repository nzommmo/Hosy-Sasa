<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../config.php";
// Start PHP session
session_start();

// Check if user is not logged in, redirect to login page or display message
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display message
    header("Location: ../login.php"); // Change 'login.php' to your actual login page
    exit();
}


// Retrieve username and user_id from the session
$user_id = $_SESSION['user_id'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['newDateTime']) && isset($_POST['appointmentId'])) {
        // Sanitize and validate input (you should do more thorough validation)
        $newDateTime = $_POST['newDateTime'];
        $appointmentId = $_POST['appointmentId'];

        // Update the appointment record in the database
        $newDateTime = $conn->real_escape_string($newDateTime); // Sanitize datetime input
        $appointmentId = intval($appointmentId); // Sanitize appointment ID input

        $sql = "UPDATE schedule SET start_datetime = '$newDateTime' WHERE id = $appointmentId";

        if ($conn->query($sql) === TRUE) {
            // Appointment rescheduled successfully
            $_SESSION['success_message'] = "Appointment rescheduled successfully.";
        } else {
            // Failed to reschedule appointment
            $_SESSION['error_message'] = "Error: " . $conn->error;
        }
    } else {
        // Required fields are missing
        $_SESSION['error_message'] = "Error: Required fields are missing.";
    }

    // Redirect back to the form page
    header("Location: Reschedule.php"); // Change 'reschedule_form.php' to the actual page containing the form
    exit();
} else {
    // Redirect to the appointments page or show an error message
    header("Location: patient_dashboard.php");
    exit();
}
?>
