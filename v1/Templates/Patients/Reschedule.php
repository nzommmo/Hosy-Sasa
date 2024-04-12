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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the appointment ID is set in the POST data
    if (isset($_POST['appointmentId'])) {
        // Sanitize the input to prevent SQL injection
        $appointmentId = mysqli_real_escape_string($conn, $_POST['appointmentId']);
        // Assuming you want to update the appointment with a new date and time
        if (isset($_POST['newDateTime'])) {
            $newDateTime = mysqli_real_escape_string($conn, $_POST['newDateTime']);
            // Update the appointment in the database with the new date and time
            $updateQuery = "UPDATE schedule SET start_datetime = '$newDateTime' WHERE id = '$appointmentId'";
            if (mysqli_query($conn, $updateQuery)) {
                // Appointment rescheduled successfully
                echo "Appointment rescheduled successfully.";
            } else {
                // Error occurred while rescheduling appointment
                echo "Error updating appointment: " . mysqli_error($conn);
            }
        } else {
            // New date and time not provided
            echo "Error: New date and time not provided.";
        }
    } else {
        // Appointment ID not provided
        echo "Error: Appointment ID not provided.";
    }
} else {
    // Form not submitted via POST method
    echo "Error: Form not submitted.";
}
?>
