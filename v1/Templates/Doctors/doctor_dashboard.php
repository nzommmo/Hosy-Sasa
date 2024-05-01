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

// Retrieve username and user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch user's information from the database based on user_id
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $firstname = $user['first_name'];
    // You can fetch other user details here if needed
}

// Fetch user's medical records from the database based on user_id
$sql_medical = "SELECT * FROM medical_records 
                    INNER JOIN Doctors ON medical_records.doctor_id = Doctors.doctor_id 
                    WHERE Doctors.user_id = $user_id";

$result_medical = $conn->query($sql_medical);
$medical_records = array();
if ($result_medical) {
    while ($row = $result_medical->fetch_assoc()) {
        $medical_records[] = $row;
    }
} 
// Fetch user's lab results from the database based on user_id
$sql_lab = "SELECT * FROM lab_results 
                    INNER JOIN patients ON lab_results.patient_id = patients.patient_id 
                    WHERE patients.user_id = $user_id";

$result_lab = $conn->query($sql_lab);
$lab_results = array();
if ($result_lab) {
    while ($row = $result_lab->fetch_assoc()) {
        $lab_results[] = $row;
    }
} 
// Fetch user's appointments from the database based on user_id
$sql_appointments = "SELECT * 
                    FROM schedule 
                    INNER JOIN Doctors 
                    ON schedule.doctor_id = Doctors.doctor_id 
                    WHERE schedule.user_id = $user_id";

$result_appointments = $conn->query($sql_appointments);
$appointments = array();
if ($result_appointments) {
    while ($row = $result_appointments->fetch_assoc()) {
        $appointments[] = array(
            'title' => $row['title'],
            'start' => $row['start_datetime'], // Assuming your appointment table has a column named 'start_datetime' for the start date/time of the appointment
            'end' => $row['end_datetime'], // Assuming your appointment table has a column named 'end_datetime' for the end date/time of the appointment
            'doctor_name' => $row['first_name'], // Fetching the doctor's name from the 'Doctors' table
            'appointmentId' => $row['id']
        );
    }
}
// Fetch user's vital signs from the database based on user_id
$sql_vital_signs = "SELECT * FROM vital_signs 
                    INNER JOIN patients ON vital_signs.patient_id = patients.patient_id 
                    WHERE patients.user_id = $user_id";
$result_vital_signs = $conn->query($sql_vital_signs);
$vital_signs = array();
if ($result_vital_signs) {
    while ($row = $result_vital_signs->fetch_assoc()) {
        $vital_signs[$row['sign_name']] = $row['sign_value'];
    }
}

// Get values for body temperature, oxygen levels, and blood pressure
$body_temperature = isset($vital_signs['Body Temperature']) ? $vital_signs['Body Temperature'] : 'N/A';
$oxygen_levels = isset($vital_signs['Oxygen Levels']) ? $vital_signs['Oxygen Levels'] : 'N/A';
$blood_pressure = isset($vital_signs['Blood Pressure']) ? $vital_signs['Blood Pressure'] : 'N/A';



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggleable Sidebar</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../Static/patients.css">
    <script src="https://cdn.jsdelivr.net/npm/progressbar.js/dist/progressbar.min.js"></script>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <style>
        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #FF595A;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            z-index: 999;
        }
        /* Sidebar links */
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: #212529;
            display: block;
            transition: 0.3s;
        }
        /* Close button */
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        /* Close button on hover */
        .closebtn:hover {
            color: #aaa;
            cursor: pointer;
        }
        /* Divider */
        .divider {
            padding: 10px 15px;
            font-weight: bold;
            color: black;
            background-color: #FF595A;
        }
        /* Page content */
        .content {
            margin-left: 250px;
            transition: margin-left 0.5s;
            padding: 20px;
            width: calc(100% - 500px); /* Adjusted width */
            z-index: 1;
        }
        #date{
            margin-top: -60px;
        }
        a:hover{
            background-color: linen;
            border-radius: 10px;
        }
        /* Right sidebar */
        .right-sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #f8f9fa;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        /* Calendar */
        .calendar {
            padding: 20px;
        }
        .calendar h4 {
            font-weight: bold;
            margin-bottom: 20px;
        }
        /* Upcoming Appointments */
        .upcoming-appointments {
            padding: 20px;
        }
        .upcoming-appointments h4 {
            font-weight: bold;
            margin-bottom: 20px;
        }
        /* Flexible divs when sidebar is open */
        .flexible-div {
            transition: margin-left 0.5s;
        }
        /* Cards */
        .card {
            width: 100%; /* Adjusted width */
            margin-bottom: 20px;
        }
    </style>
</head>
<body id="patientbody">

<!-- Menu icon -->
<span style="font-size:30px;cursor:pointer; z-index: 1000;" onclick="toggleSidebar()">&#9776;</span>

<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <!-- Divider with user's name and date -->
    <div class="divider"  id="date">
        <span><?php echo $firstname; ?></span><br>
        <span>Date: <?php echo date("Y-m-d"); ?></span>
    </div>
    <!-- Close button -->
    <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">&times;</a>
    <!-- Sidebar links -->
    <a href="" id="Homebtn">Home</a>
    <!-- Divider -->
    <div class="divider">____________</div>
    <a href="#" id="Recordvitalsbtn">Record Vital Signs</a>
    <a href="#" id="Recordmedicalsbtn">Record Medical Records </a>
    <a href="#" id="Recordlabsbtn">Record Lab Results</a>
    <a href="#" id="Recordappointment">Schedule appointment</a>

    <div class="divider">_________________</div>
   <a href="#" id="vitalsbtn">Patients Vital Signs</a>
    <a href="#" id="medicalsbtn">Patients Medical Records </a>
    <a href="#" id="labsbtn">Patients Lab Results</a>
    <a href="#" id="labsbtn">View Appointments</a>

    <div class="divider">_________________</div>


    <!-- Logout -->
    <a href="../logout.php">Logout</a>
</div>
<!-- Page content -->
<div class="container mt-5 content flexible-div" style="width: 650px;" id="maincont">
<div id="message">
    <style>
        #message{
    width: 400px;
    margin-bottom: 65px;
}

    </style>
    <?php
    session_start();

    // Display success message if set
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']); // Remove the success message from session
    }

    // Display error message if set
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Remove the error message from session
    }
    ?>
</div>



    <!-- Welcome Message Card -->
    <div class="row" id="mains">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    Welcome <?php echo $firstname; ?>!
                </div>
                <div class="card-body">
                    <p class="card-text">Welcome to your dashboard. Here you can manage your patients vital signs, medical records, lab results, and more.</p>
                </div>
            </div>
        </div>
    </div>


<!-- lab Results Form -->
<div class="card-patient" id="medicalrecordform">
    <div class="card-header">
        Record Medical Records
    </div>
    <div class="card-body">
        <?php include_once "Lab_Results_Form.php";
        ?>
    </div>


<!-- Lab Results Card -->
<div class="card-patient" id="labresults">
    <div class="card-header">
        Lab Results
    </div>
    <div class="card-body">
        <?php if (count($lab_results) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Test Name</th>
                        <th scope="col">Result Value</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lab_results as $result): ?>
                        <tr>
                            <td><?php echo $result['test_name']; ?></td>
                            <td><?php echo $result['result_value']; ?></td>
                            <td><?php echo $result['test_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No lab results found for the user.</p>
        <?php endif; ?>
    </div>
</div>


</div>

<!-- Right sidebar -->
<div class="right-sidebar" id="cal">
    
    <div class="calendar">
        <h4>Calendar</h4>
        <!-- Insert calendar here -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        })
        calendar.render()
      })
      

    </script>
        <div id='calendar'></div>
    </div>
<!-- Upcoming Appointments Card -->
<div class="card" id="appointments">
    <div class="card-header" style="margin-bottom: 10px;">
        Upcoming Appointments
    </div>
    <?php if (count($appointments) > 0): ?>
        <?php foreach ($appointments as $appointment): ?>
            <div class="card-body appointment-card-body">
                <strong>Reason:</strong> <?php echo $appointment['title']; ?><br>
                <strong>Doctor:</strong> <?php echo $appointment['doctor_name']; ?><br>
                <strong>Start Time:</strong> <?php echo $appointment['start']; ?><br>
                 <!-- Reschedule and Cancel buttons -->
                        <button class="btn btn-primary" onclick="openRescheduleForm(<?php echo $appointment['appointmentId']; ?>)">Reschedule</button>
                <button class="btn btn-danger">Cancel</button>
           </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card-body">
            <p>No upcoming appointments found.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Reschedule Form -->
<div id="rescheduleForm" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
        <h5 class="modal-title">Reschedule Appointment</h5>
        <button type="button" class="close" onclick="closeRescheduleForm()">&times;</button>
    </div>
            <div class="modal-body">
                <form id="rescheduleAppointmentForm" action="Reschedule.php" method="POST">
                    <div class="form-group">
                        <label for="newDateTime">New Date and Time</label>
                        <input type="datetime-local" class="form-control" id="newDateTime" name="newDateTime" required>
                    </div>
                    <input type="hidden" id="appointmentId" name="appointmentId">
                    <button type="submit" class="btn btn-primary">Reschedule</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function openRescheduleForm(appointmentId) {
        const form = document.getElementById("rescheduleForm")
       form.style.display = "block"

        // Assuming you want to set the appointment ID in a hidden input field inside the modal
        document.getElementById("appointmentId").value = appointmentId;
    }
    function closeRescheduleForm() {
        const form = document.getElementById("rescheduleForm");
        form.style.display = "none";
    }
</script>


<style>
    /* Add outline to appointment card bodies */
    .appointment-card-body {
        border: 1px solid #ccc; /* Gray border */
        padding: 10px; /* Add padding for better spacing */
        margin-bottom: 10px; /* Add margin between appointment cards */
        border-radius: 5px; /* Add border radius for rounded corners */
        margin-top: 10px;
        width: 250px;
        margin-left: 23px;
       
    }
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script to toggle medical and lab records cards-->
<script>
    const labresults = document.getElementById("labresults")

    //Home  button clicked
    function hideAllContent(){
        var contentcards = document.getElementsByClassName("card-patient");
        for (var i = 0;i < contentcards.length;i++ ){
            contentcards[i].style.display = "none";
        }
    }
    document.getElementById("Homebtn").addEventListener("click",hideAllContent())

    document.addEventListener("DOMContentLoaded",hideAllContent())

    //lab results button clicked
    document.getElementById("labsbtn").addEventListener("click",function(){
        hideAllContent();
        document.getElementById("labresults").style.display = "block";
    })

    //Medical records button clicked
    document.getElementById("medicalsbtn").addEventListener("click",function(){
        hideAllContent();
        document.getElementById("medicalrecord").style.display = "block";
    })
        //Lab Results Form button clicked
        document.getElementById("Recordlabsbtn").addEventListener("click",function(){
        hideAllContent();
        document.getElementById("medicalrecordform").style.display = "block";
    })



</script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("mySidebar");
        const content = document.getElementsByClassName("content")[0];
        if (sidebar.style.width === "250px") {
            sidebar.style.width = "0";
            content.style.marginLeft = "150px";
        } else {
            sidebar.style.width = "250px";
            content.style.marginLeft = "250px";
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                // Array of appointment objects
                <?php foreach ($appointments as $appointment): ?>{
                    title: '<?php echo $appointment['title']; ?>',
                    start: '<?php echo $appointment['start']; ?>',
                    end: '<?php echo $appointment['end']; ?>'
                },
                <?php endforeach; ?>
            ]
        });
        calendar.render();
    });
</script>
<script>
// Assuming you have a div element with id "bodyTemperatureProgress" for body temperature progress wheel
var bodyTemperatureProgress = new ProgressBar.Circle('#bodyTemperatureProgress', {
  strokeWidth: 6,
  easing: 'easeInOut',
  duration: 1400,
  color: '#8BC34A',
  trailColor: '#eee',
  trailWidth: 1,
  svgStyle: null
});

// Set initial value and text
var bodyTemperatureValue = <?php echo $body_temperature; ?>; // Assuming $body_temperature contains the temperature value
bodyTemperatureProgress.animate(bodyTemperatureValue / 100);  // Adjust the division as per your requirement
bodyTemperatureProgress.setText('<?php echo $body_temperature; ?>°C'); // Display temperature value inside the circle

// Initialize circular progress wheel for Oxygen Levels
// Assuming you have a div element with id "oxygenLevelsProgress" for oxygen levels progress wheel
var oxygenLevelsProgress = new ProgressBar.Circle('#oxygenLevelsProgress', {
  strokeWidth: 6,
  easing: 'easeInOut',
  duration: 1400,
  color: '#78C2AD',
  trailColor: '#eee',
  trailWidth: 1,
  svgStyle: null
});

// Set initial value and text
var oxygenLevelsValue = <?php echo $oxygen_levels; ?>; // Assuming $oxygen_levels contains the oxygen levels value
oxygenLevelsProgress.animate(oxygenLevelsValue / 100);  // Adjust the division as per your requirement
oxygenLevelsProgress.setText('<?php echo $oxygen_levels; ?>%'); // Display oxygen levels value inside the circle

// Assuming you have a div element with id "bloodPressureProgress" for blood pressure progress wheel
var bloodPressureProgress = new ProgressBar.Circle('#bloodPressureProgress', {
  strokeWidth: 6,
  easing: 'easeInOut',
  duration: 1400,
  color: '#D86159',
  trailColor: '#eee',
  trailWidth: 1,
  svgStyle: null
});

// Set initial value and text
var bloodPressureValue = <?php echo $blood_pressure; ?>; // Assuming $blood_pressure contains the blood pressure value
bloodPressureProgress.animate(bloodPressureValue / 100);  // Adjust the division as per your requirement
bloodPressureProgress.setText('<?php echo $blood_pressure; ?> mmHg'); // Display blood pressure value inside the circle
</script>

<!-- Include progressbar.js library -->

<script src="/Hosy-Sasa/v1/Static/patients.js"></script>

</body>
</html>
