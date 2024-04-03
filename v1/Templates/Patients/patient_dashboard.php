
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggleable Sidebar</title>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link rel="stylesheet" href="../Static/admin_dashboard.css">
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
        <span><?php echo $username; ?></span><br>
        <span>Date: <?php echo date("Y-m-d"); ?></span>
    </div>
    <!-- Close button -->
    <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">&times;</a>
    <!-- Sidebar links -->
    <a href="#" id="accountdetailsbtn">Home</a>
    <!-- Divider -->
    <div class="divider">____________</div>
    <a href="#" id="addstudentbtn">Vital Signs</a>
    <a href="#" id="addstudentbtn">Medical Records </a>
    <a href="#" id="addstudentbtn">Lab Results</a>
    <div class="divider">_________________</div>

    <!-- Logout -->
    <a href="#">Logout</a>
</div>
<!-- Page content -->
<div class="container mt-5 content flexible-div">
    <!-- Welcome Message Card -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    Welcome <?php echo $username; ?>!
                </div>
                <div class="card-body">
                    <p class="card-text">Welcome to your dashboard. Here you can manage your vital signs, medical records, lab results, and more.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Existing Cards -->
    <div class="row">
        <!-- Body Temperature Card -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    Body Temperature
                </div>
                <div class="card-body">
                    <p class="card-text">37°C</p>
                </div>
            </div>
        </div>
        <!-- Oxygen Levels Card -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    Oxygen Levels
                </div>
                <div class="card-body">
                    <p class="card-text">98%</p>
                </div>
            </div>
        </div>
        <!-- Blood Pressure Card -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    Blood Pressure
                </div>
                <div class="card-body">
                    <p class="card-text">120/80 mmHg</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Right sidebar -->
<div class="right-sidebar">
    <div class="calendar">
        <h4>Calendar</h4>
        <!-- Insert calendar here -->
        <div id='calendar'></div>
    </div>
    <div class="upcoming-appointments">
        <h4>Upcoming Appointments</h4>
        <!-- Insert upcoming appointments here -->
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("mySidebar");
        const content = document.getElementsByClassName("content")[0];
        if (sidebar.style.width === "250px") {
            sidebar.style.width = "0";
            content.style.marginLeft = "0";
        } else {
            sidebar.style.width = "250px";
            content.style.marginLeft = "250px";
        }
    }
</script>

<script src="../Static/adminpanel.js"></script>

</body>
</html>
