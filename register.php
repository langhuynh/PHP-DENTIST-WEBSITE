<?php
// must appear BEFORE <html>
session_start();
include_once('include/config.php');
$conn = db_connect();

// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $phone    = $conn->real_escape_string($_POST['phone']);
    $email    = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password
    $postcode = $conn->real_escape_string($_POST['postcode']);

    // Check if email already exists
    $checkSql = "SELECT * FROM users WHERE Email='$email'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        $error = "This email is already registered.";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (FullName, Phone, Email, Password, Postcode)
                VALUES ('$fullname', '$phone', '$email', '$password', '$postcode')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Registration successful! Please log in.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- <link rel="stylesheet" href="css/member.css"> -->
<title>Register </title>
<style>
    body, html { height: 100%; margin: 0; }
    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh; /* leave room for header/footer */
    }
    .register-form {
        width: 100%;
        max-width: 500px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
</style>
</head>
<body>
    <?php include("include/banner.inc"); ?>
    <?php include("include/nav.inc"); ?>

    <div class="center-container">
        <form action="register.php" method="post" class="register-form">
            <h2 class="text-center mb-4">Register</h2>

            <?php
            if (isset($error)) {
                echo "<p class='text-danger text-center'>$error</p>";
            }
            if (isset($success)) {
                echo "<p class='text-success text-center'>$success</p>";
            }
            ?>

            <div class="form-group">
                <label for="fullname">Full Name (*):</label>
                <input type="text" id="fullname" name="fullname" class="form-control" maxlength="50" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone (*):</label>
                <input type="text" id="phone" name="phone" class="form-control" maxlength="12" pattern="\d{10,12}" required>
                <small class="form-text text-muted">Enter 10-12 digit phone number.</small>
            </div>

            <div class="form-group">
                <label for="email">Email (*):</label>
                <input type="email" id="email" name="email" class="form-control" maxlength="40" required>
            </div>

            <div class="form-group">
                <label for="password">Password (*):</label>
                <input type="password" id="password" name="password" class="form-control" maxlength="30" required>
            </div>

            <div class="form-group">
                <label for="postcode">Postcode (*):</label>
                <input type="text" id="postcode" name="postcode" class="form-control" maxlength="4" pattern="\d{4}" required>
                <small class="form-text text-muted">Enter 4-digit postcode.</small>
            </div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Register">
                <input type="reset" class="btn btn-secondary" value="Clear">
            </div>

            <p class="text-center mt-3">Already registered? <a href="login.php">Login here</a></p>
        </form>
    </div>

    <?php include("include/footer.inc"); ?>
</body>
</html>
