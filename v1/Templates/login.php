<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'config.php'; // Include the database configuration file

// Login user
session_start(); // Start session if not already started

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            if ($row['user_type'] == 'Admin') { // Check if user is admin
                $_SESSION['user_id'] = $row['user_id']; // Store user ID in session
                echo "Login successful";

                // Redirect to admin panel after successful login
                header("Location: adminpanel.php");
                exit(); // Exit to prevent further execution
            } elseif ($row['user_type'] == 'Patient') { // Check if user is patient
                $_SESSION['user_id'] = $row['user_id']; // Store user ID in session
                echo "Login successful";

                // Redirect to patient dashboard after successful login
                header("Location: ../Templates/Patients/patient_dashboard.php");
                exit(); // Exit to prevent further execution
            }
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Email not found";
    }
}

// Signup user
if (isset($_POST['register'])) { // Changed 'signup' to 'register'
    $firstname = $_POST['firstname']; // Changed 'first_name' to 'firstname'
    $lastname = $_POST['lastname']; // Changed 'last_name' to 'lastname'
    $user_type = $_POST['user_type'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, user_type, email, password_hash) VALUES ('$firstname', '$lastname', '$user_type', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Static/student_dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
    <style>
        .form-container {
            margin-right: 30px; /* Adjust as needed */
        }
        #signupform {
            display: none; /* Hide the signup form initially */
        }
    </style>
</head>
<body id="loginpage">
    <div class="container" id="formcontent">
        <div class="row mt-5" id="formholder">
            <div class="col-md-6 d-flex justify-content-center align-items-center" id="log">
                <!-- Login Form -->
                <div class="form-container" id="loginform">
                    <h2>Login</h2>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="loginEmail">Email address</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="">
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" value="">
                        </div> <br>
                        <h4 id="not">Not Yet Registered? </h4>
                        <button type="button" class="btn btn-primary" id="showSignup">Sign Up</button>
                        <button type="submit" class="btn btn-primary" name="login" id="loginbtnm">Login</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
<!-- Signup Form -->
<div class="form-container" id="signupform">
    <h2>Sign Up</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="signupName">First Name</label>
            <input type="text" class="form-control" id="signupName" name="firstname" placeholder="Enter First Name" value="">
        </div>
        <div class="form-group">
            <label for="signupName">Last Name</label>
            <input type="text" class="form-control" id="signupName" name="lastname" placeholder="Enter Last Name" value="">
        </div>
        <div class="form-group">
            <label for="signupEmail">Email address</label>
            <input type="email" class="form-control" id="signupEmail" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="">
        </div>
        <div class="form-group">
            <label for="signupPassword">Password</label>
            <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Password" value="">
        </div>
        <div class="form-group">
            <label for="userType">User Type</label>
            <select class="form-control" id="userType" name="user_type">
                <option value="Admin">Admin</option>
                <option value="Doctor">Doctor</option>
                <option value="Patient">Patient</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="register" id="signupbtn">Sign Up</button><br>
        <p>or</p>
        <button type="submit" class="btn btn-primary" name="register" id="showLogin">Login</button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        document.getElementById('showSignup').addEventListener('click', function() {
            document.getElementById('signupform').style.display = 'block'; // Display the signup form
            document.getElementById('loginform').style.display = 'none'; // Hide the login form
        });
        document.getElementById('showLogin').addEventListener('click', function() {
            document.getElementById('signupform').style.display = 'none'; // Display the signup form
            document.getElementById('loginform').style.display = 'block'; // Hide the login form
        });
        
    </script>
</body>
</html>