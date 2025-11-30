<?php
session_start();
include_once('include/config.php');
$conn = db_connect();

$dentistID = intval($_GET['id'] ?? 0);


$sqlDentist = "SELECT * FROM Dentist WHERE DentistID=$dentistID";
$dentistResult = $conn->query($sqlDentist);
$dentist = $dentistResult->fetch_assoc();

// Fetch dentist services
$sqlService = "SELECT s.ServiceID, s.ServiceName 
               FROM Service s
               INNER JOIN Dentist_Service ds ON s.ServiceID = ds.ServiceID
               WHERE ds.DentistID=$dentistID";
$serviceResult = $conn->query($sqlService);

// Base availability query
$sqlAvailability = "SELECT * FROM Dentist_Availability 
                    WHERE DentistID=$dentistID AND Status='Available' 
                    ORDER BY AvailableDate, StartTime";

$successMsg = "";
$errorMsg = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Login required
    if (!isset($_SESSION['valid_user'])) {
        $redirectUrl = "dentistDetail.php?id=" . $dentistID;
        header("Location: login.php?redirect=" . urlencode($redirectUrl));
        exit();
    }

    // Logged in user
    $userEmail = $_SESSION['valid_user'];
    $sqlUser = "SELECT UserID, FullName, Email, Phone, PostCode FROM users WHERE Email='$userEmail'";
    $userResult = $conn->query($sqlUser);
    $user = $userResult->fetch_assoc();

    if (!$user) {
        $errorMsg = "User not found.";
    } else {

        // Check if patient exists
        $sqlPatient = "SELECT * FROM Patient WHERE Email='" . $user['Email'] . "'";
        $patientResult = $conn->query($sqlPatient);

        if ($patientResult->num_rows > 0) {
            $patient = $patientResult->fetch_assoc();
            $patientID = $patient['PatientID'];
        } 
        else {
            // Create new patient (corrected)
            $stmt = $conn->prepare("INSERT INTO Patient (FullName, Phone, Email, PostCode, userID) VALUES (?, ?, ?, ?,?)");
            $stmt->bind_param("ssssi", $user['FullName'], $user['Phone'], $user['Email'], $user['PostCode'], $user['UserID']);
            $stmt->execute();
            $patientID = $stmt->insert_id;
            $stmt->close();
        }

        
        // Booking data
        $serviceID = intval($_POST['service']);
        $availabilityID = intval($_POST['availability']);

        // Get slot info
        $stmt = $conn->prepare("SELECT AvailableDate, StartTime, EndTime FROM Dentist_Availability WHERE AvailabilityID=?");
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

        $successMsg = "Appointment booked successfully for " . $user['FullName'] . " on $appointmentDateTime!";
    }
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

<title>Online Booking</title>
</head>

<body>

<?php include("include/banner.inc"); ?>
<?php include("include/nav.inc"); ?>

<div class="container mt-5">
    <h1 class="page-title mb-4">Online Booking</h1>

    <!-- Dentist Card -->
    <div class="row">
        <div class="col-md-5">
            <div class="card p-3 mb-4">
                <img src="<?= $dentist['Image']; ?>" class="img-fluid rounded mb-3" style="max-height:600px; object-fit:cover;">
                <h2><?= $dentist['FullName']; ?></h2>
                <p><strong>Specialization:</strong> <?= $dentist['Specialization']; ?></p>
                <p><?= $dentist['Detail']; ?></p>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-md-7">
            <div class="card p-3">
                <h3>Book an Appointment</h3>

                <?php 
                if ($successMsg) echo "<div class='alert alert-success'>$successMsg</div>";
                if ($errorMsg) echo "<div class='alert alert-danger'>$errorMsg</div>";
                ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Select Service</label>
                        <select name="service" class="form-select" required>
                            <option value="">-- Select Service --</option>
                            <?php while($s = $serviceResult->fetch_assoc()): ?>
                                <option value="<?= $s['ServiceID']; ?>"><?= $s['ServiceName']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Select Time Slot</label>
                        <select name="availability" class="form-select" required>
                            <option value="">-- Select Slot --</option>
                            <?php
                            $availabilityResult2 = $conn->query($sqlAvailability);
                            while($a = $availabilityResult2->fetch_assoc()):
                            ?>
                                <option value="<?= $a['AvailabilityID']; ?>">
                                    <?= $a['AvailableDate'] . " " . $a['StartTime'] . " - " . $a['EndTime']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-info text-white">Book Appointment</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Slots List -->
    <h4 class="mt-5">Available Slots</h4>
    <table class="table table-striped">
        <thead><tr><th>Date</th><th>Start</th><th>End</th></tr></thead>
        <tbody>
        <?php
        $availabilityResult3 = $conn->query($sqlAvailability);
        if ($availabilityResult3->num_rows > 0) {
            while($a = $availabilityResult3->fetch_assoc()) {
                echo "<tr><td>{$a['AvailableDate']}</td><td>{$a['StartTime']}</td><td>{$a['EndTime']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No Available Slots</td></tr>";
        }
        ?>
        </tbody>
    </table>

</div>

<?php include("include/footer.inc"); ?>

</body>
</html>
