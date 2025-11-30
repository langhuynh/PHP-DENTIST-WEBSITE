<?php

session_start();
include_once('include/config.php');

$conn = db_connect();

// 1. If already logged in → redirect to original page

if (isset($_SESSION['valid_user']) && !empty($_GET['redirect'])) {
    header("Location: " . $_GET['redirect']);
    exit();
}

// If no redirect provided, default
$redirect = $_GET['redirect'] ?? 'member_only.php';

$error = "";


// 2. Handle login submission

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // plain password input

    // Fetch user
    $sql = "SELECT * FROM users WHERE Email='$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {

        $row = $result->fetch_assoc();

        // Verify password hash
        if (password_verify($password, $row['Password'])) {

            // Successful login
            $_SESSION['valid_user'] = $row['Email'];

            // Extract first name
            $fullName = trim($row['FullName']);
            $firstName = explode(" ", $fullName)[0];
            $_SESSION['name'] = ucwords($firstName);

            // Redirect to original page or member area
            header("Location: $redirect");
            exit();
        }
    }

    // If login failed
    $error = "Your email or password is invalid.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
    <script src="js/nav.js"></script>
    <script src="js/read_more.js"></script>
    <link rel="stylesheet" href="css/member.css">
    <title>Log In</title>
</head>

<body onLoad="run_first()">

<?php include("include/banner.inc"); ?>
<?php include("include/nav.inc"); ?>

<div class="container">
    <form action="login.php?redirect=<?= urlencode($redirect) ?>" method="post">
        <div class="bg-light mt-3 px-3 py-3 member_frm" style="border-radius:5px; border:#0000ff solid thick;">
            <h1>Login</h1>
            <p>Please enter your email and password</p>

            <div class="row">
                <div class="col">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required class="form-control"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required class="form-control"/>
                </div>
            </div>

            <?php if (!empty($error)): ?>
                <p class="text-danger mt-2"><?= $error ?></p>
            <?php endif; ?>

            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
            </div>

            <p class="mt-3">
                Not registered yet? <a href="register.php">Click here to register</a>
            </p>
        </div>
    </form>
</div>

<?php include("include/footer.inc"); ?>
</body>
</html>
