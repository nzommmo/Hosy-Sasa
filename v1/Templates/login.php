<?php
// Include database connection
include_once '../config.php';

// Start PHP session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if login form is submitted
    if (isset($_POST['login'])) {
        // Get username and password from form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to check if user exists
        $sql = "SELECT * FROM users WHERE username = '$username' AND password_hash = '$password'";
        $result = mysqli_query($conn, $sql);

        // Check if query executed successfully and if user exists
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch user details
            $user = mysqli_fetch_assoc($result);

            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];

            // Check user type and redirect accordingly
            if ($user['user_type'] == 'Admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['user_type'] == 'Doctor') {
                header("Location: doctor_dashboard.php");
            } elseif ($user['user_type'] == 'Patient') {
                header("Location: ../Templates/Patients/patient_dashboard.php");
            }
            exit();
        } else {
            // User not found, display error message
            $login_error = "Invalid username or password.";
        }
    } elseif (isset($_POST['signup'])) { // Check if signup form is submitted
        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $user_type = $_POST['user_type'];

        // Query to insert user into database
        $sql = "INSERT INTO users (username, password_hash, email, first_name, last_name, user_type) VALUES ('$username', '$password', '$email', '$first_name', '$last_name', '$user_type')";
        
        // Execute query
        if (mysqli_query($conn, $sql)) {
            // User successfully added, redirect to login page
            header("Location: login.php");
            exit();
        } else {
            // Error in adding user
            $signup_error = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
            <?php if (isset($login_error)) { echo "<p class='text-danger'>$login_error</p>"; } ?>
        </form>
        <hr>
        <h2>Signup</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="user_type">User Type</label>
                <select class="form-control" id="user_type" name="user_type">
                    <option value="Admin">Admin</option>
                    <option value="Doctor">Doctor</option>
                    <option value="Patient">Patient</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="signup">Signup</button>
            <?php if (isset($signup_error)) { echo "<p class='text-danger'>$signup_error</p>"; } ?>
        </form>
    </div>
</body>
</html>