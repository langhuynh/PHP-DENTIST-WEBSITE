<?php
session_start();
include_once('include/config.php'); 
$conn = db_connect();

// Redirect if not logged in
if (!isset($_SESSION['valid_user'])) {
    $redirect = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$redirect");
    exit;
}

// Get logged-in user info
$userEmail = $_SESSION['valid_user'];
$sqlUser = "SELECT FullName, Email FROM users WHERE Email='$userEmail'";
$userResult = $conn->query($sqlUser);
$user = $userResult->fetch_assoc();

$successMsg = "";

// Selected values
$serviceID = intval($_POST['service'] ?? 0);
$dentistID = intval($_POST['dentist'] ?? 0);
$availabilityID = intval($_POST['availability'] ?? 0);

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $availabilityID > 0) {

    // Check if patient already exists
    $sqlPatient = "SELECT * FROM Patient WHERE Email='" . $user['Email'] . "'";
    $patientResult = $conn->query($sqlPatient);

    if ($patientResult->num_rows > 0) {
        $patient = $patientResult->fetch_assoc();
        $patientID = $patient['PatientID'];
    } else {
        // Create new patient
        // $emptyPhone = "";
        $stmt = $conn->prepare("INSERT INTO Patient (FullName, Phone, Email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user['FullName'], $emptyPhone, $user['Email']);
        $stmt->execute();
        $patientID = $stmt->insert_id;
        $stmt->close();
    }

    // Get slot date/time
    $stmt = $conn->prepare("SELECT AvailableDate, StartTime, EndTime 
                            FROM Dentist_Availability WHERE AvailabilityID=?");
    $stmt->bind_param("i", $availabilityID);
    $stmt->execute();
    $stmt->bind_result($date, $startTime, $endTime);
    $stmt->fetch();
    $stmt->close();

    $appointmentDateTime = "$date $startTime";

    // Insert appointment
    $stmt = $conn->prepare("INSERT INTO Appointment 
        (PatientID, DentistID, ServiceID, AvailabilityID, AppointmentDateTime) 
        VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiis", $patientID, $dentistID, $serviceID, $availabilityID, $appointmentDateTime);
    $stmt->execute();
    $stmt->close();

    // Mark slot unavailable
    $stmt = $conn->prepare("UPDATE Dentist_Availability SET Status='Not Available' WHERE AvailabilityID=?");
    $stmt->bind_param("i", $availabilityID);
    $stmt->execute();
    $stmt->close();

    $successMsg = "Appointment booked successfully for {$user['FullName']} on $appointmentDateTime!";
}

// Fetch services
$services = $conn->query("SELECT * FROM Service");

// Fetch dentists for selected service
$dentists = $serviceID ? $conn->query("
    SELECT d.DentistID, d.FullName 
    FROM Dentist d
    INNER JOIN Dentist_Service ds ON d.DentistID = ds.DentistID
    WHERE ds.ServiceID=$serviceID
") : [];

// Fetch availability for selected dentist
$availability = $dentistID ? $conn->query("
    SELECT * FROM Dentist_Availability 
    WHERE DentistID=$dentistID AND Status='Available'
    ORDER BY AvailableDate, StartTime
") : [];
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
    <title>Book Appointment</title>
</head>

<body >
<?php include("include/banner.inc"); ?>
<?php include("include/nav.inc"); ?>

<div class="container mt-5">
    <h1 class="page-title mb-4">Book an Appointment</h1>

    <?php if($successMsg): ?>
        <div class="alert alert-success"><?= $successMsg ?></div>
    <?php endif; ?>

    <form method="POST">

        
        <div class="mb-3">
            <label>Select Service</label>
            <select name="service" class="form-select" onchange="this.form.submit()">
                <option value="">-- Select Service --</option>
                <?php while($s = $services->fetch_assoc()): ?>
                    <option value="<?= $s['ServiceID'] ?>" <?= $serviceID == $s['ServiceID'] ? 'selected' : '' ?>>
                        <?= $s['ServiceName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        
        <?php if($serviceID): ?>
        <div class="mb-3">
            <label>Select Dentist</label>
            <select name="dentist" class="form-select" onchange="this.form.submit()">
                <option value="">-- Select Dentist --</option>
                <?php while($d = $dentists->fetch_assoc()): ?>
                    <option value="<?= $d['DentistID'] ?>" <?= $dentistID == $d['DentistID'] ? 'selected' : '' ?>>
                        <?= $d['FullName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <?php endif; ?>

        
        <?php if($dentistID): ?>
        <div class="mb-3">
            <label>Select Time Slot</label>
            <select name="availability" class="form-select" required>
                <option value="">-- Select Slot --</option>
                <?php if($availability->num_rows > 0): ?>
                    <?php while($a = $availability->fetch_assoc()): ?>
                        <option value="<?= $a['AvailabilityID'] ?>">
                            <?= $a['AvailableDate'] ?> <?= $a['StartTime'] ?> - <?= $a['EndTime'] ?>
                        </option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No available slots</option>
                <?php endif; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Book Appointment</button>
        <?php endif; ?>

    </form>
</div>

<?php include("include/footer.inc"); ?>
</body>
</html>
