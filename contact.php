<?php
session_start();
include_once('include/config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = db_connect();
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check login
$user_logged_in = $_SESSION['valid_user'] ?? null;

$name_value = $user_logged_in ?? '';
$email_value = ''; // you can fetch email from DB if available

$message_text = $user_logged_in
    ? "Hello " . htmlspecialchars($user_logged_in) . "! You can submit your enquiry below."
    : "Please provide your details so we can get back to you.";

// Handle POST first
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['name'] ?? '';
    $phone_input = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $message_input = $_POST['message'] ?? '';

    // Validate numeric phone
    if (!is_numeric($phone_input)) {
        die("Error: Phone must be numeric only.");
    }
    $phone = intval($phone_input);

    // Prepare insert
    $stmt = $conn->prepare("INSERT INTO User_Feedback(FullName, Phone, Email, Message) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("siss", $name, $phone, $email, $message_input);

    if ($stmt->execute()) {
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact.php';</script>";
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact Us</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="js/nav.js"></script>
<script src="js/script.js"></script>
<link rel="stylesheet" href="css/styles.css">
<style>
.page-heading { text-align:center; font-size:36px; font-weight:700; margin:40px 0;}
.form-card { background:#fff; border:1px solid #ddd; padding:25px; border-radius:5px;}
.submit-btn { background-color:#009999; border:none;}
.submit-btn:hover { background-color:#007777;}
.section-title { font-size:20px; font-weight:600; margin-top:25px;}
.map-container { width:100%; height:380px; border:1px solid #ccc; border-radius:5px; overflow:hidden;}
</style>
</head>
<body onLoad="run_first()">

<?php include("include/banner.inc"); ?>
<?php include("include/nav.inc"); ?>

<br>
<h1 class="page-title mb-4">Contact Us</h1>

<div class="container mb-5">
<div class="row">
    <div class="col-md-5">
        <div class="section-title">100SMILES DENTAL CENTRE</div>
        <p>123 Sunshine Road, Townsville QLD 4810<br>Phone: (07) 4000 1234<br>Email: info@Happysmiles.com</p>

        <div class="section-title">OPENING HOURS</div>
        <p>Monday – Friday: 8:30am - 6:30 PM<br>Saturday - Sunday: 8:30am - 1:00 PM</p>

        <div class="section-title">GENERAL ENQUIRIES</div>
        <p><?php echo $message_text; ?></p>

        <div class="section-title">FOR URGENT MATTERS</div>
        <p style="color:red; font-weight:600;">PLEASE CALL 000 IMMEDIATELY.</p>
    </div>

    <div class="col-md-7">
        <div class="form-card">
            <h4 class="mb-3">Enquiry & Feedback Form</h4>
            <form action="contact.php" method="POST">
                <label>Name (*)</label>
                <input type="text" name="name" class="form-control mb-3" value="<?php echo htmlspecialchars($name_value); ?>" required>

                <label>Phone (*)</label>
                <input type="text" name="phone" class="form-control mb-3" maxlength="12" pattern="\d{10,12}" required>


                <label>Email (*)</label>
                <input type="email" name="email" class="form-control mb-3" value="<?php echo htmlspecialchars($email_value); ?>" required>

                <label>Message (*)</label>
                <textarea name="message" class="form-control mb-4" rows="6"></textarea>

                <button type="submit" class="btn submit-btn btn-block" style="background-color:#1FBFDC;color:white;">SUBMIT</button>
            </form>
        </div>
    </div>
</div>

<div class="row mt-5">
<div class="col-12">
<h3 class="mb-3">Find Us</h3>
<div class="map-container">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3586.5630909055385!2d146.81787991502476!3d-19.26281298700783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6bd98d46cd6671a5%3A0x6f1a820b0d6fbef5!2sTownsville%20QLD!5e0!3m2!1sen!2sau!4v1700000000000" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
</div>
</div>
</div>

<?php include("include/footer.inc"); ?>
</body>
</html>
