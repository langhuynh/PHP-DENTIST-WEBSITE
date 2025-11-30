<?php
session_start();
include_once('include/config.php'); 
$conn = db_connect();

// Redirect to login if not logged in
if (!isset($_SESSION['valid_user'])) {
    $redirect = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$redirect");
    exit();
}

$userEmail = $_SESSION['valid_user'];

// Fetch user info and role
$stmt = $conn->prepare("SELECT UserID, FullName, Email, Phone, PostCode, Role FROM users WHERE Email=?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die("User not found");
$user = $result->fetch_assoc();

$role   = $user['Role'];
$userID = $user['UserID'];
$appointments = [];


if ($role === 'Patient') {

    // Check if patient record exists
    $stmt = $conn->prepare("SELECT PatientID FROM Patient WHERE UserID=?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $patientResult = $stmt->get_result();

    if ($patientResult->num_rows > 0) {
        // Patient exists
        $patientID = $patientResult->fetch_assoc()['PatientID'];

        // Now fetch appointments
        $stmt = $conn->prepare("
            SELECT a.AppointmentID, da.AvailableDate, da.StartTime, da.EndTime,
                   d.FullName AS DentistName, d.Specialization, s.ServiceName
            FROM Appointment a
            INNER JOIN Dentist d ON a.DentistID = d.DentistID
            INNER JOIN Service s ON a.ServiceID = s.ServiceID
            INNER JOIN Dentist_Availability da ON a.AvailabilityID = da.AvailabilityID
            WHERE a.PatientID = ?
            ORDER BY da.AvailableDate DESC, da.StartTime DESC
        ");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $appointments = $stmt->get_result();

    } else {
        // Patient record does NOT exist -> show empty dashboard
        $patientID = null;
        $appointments = [];
    }
}

elseif ($role === 'Dentist') {

    // Find DentistID
    $stmt = $conn->prepare("SELECT DentistID FROM Dentist WHERE UserID=?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $dentistResult = $stmt->get_result();

    if ($dentistResult->num_rows > 0) {
        $dentistID = $dentistResult->fetch_assoc()['DentistID'];

        // Fetch dentist's appointments
        $stmt = $conn->prepare("
            SELECT a.AppointmentID, da.AvailableDate, da.StartTime, da.EndTime,
                   p.FullName AS PatientName, s.ServiceName
            FROM Appointment a
            INNER JOIN Patient p ON a.PatientID = p.PatientID
            INNER JOIN Service s ON a.ServiceID = s.ServiceID
            INNER JOIN Dentist_Availability da ON a.AvailabilityID = da.AvailabilityID
            WHERE a.DentistID = ?
            ORDER BY da.AvailableDate DESC, da.StartTime DESC
        ");
        $stmt->bind_param("i", $dentistID);
        $stmt->execute();
        $appointments = $stmt->get_result();
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
<title><?= htmlspecialchars($role) ?> Dashboard</title>
</head>
<body>

<?php include("include/banner.inc"); ?>
<?php include("include/nav.inc"); ?>

<div class="container mt-5">
    <h1 class="mb-4">Welcome, <?= htmlspecialchars($user['FullName']) ?> (<?= $role ?>)</h1>

    <!-- User Information -->
    <div class="card mb-4">
        <div class="card-header"><strong>Your Information</strong></div>
        <div class="card-body">
            <p><strong>Full Name:</strong> <?= htmlspecialchars($user['FullName']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($user['Phone']) ?></p>
            <p><strong>Post Code:</strong> <?= htmlspecialchars($user['PostCode']) ?></p>
        </div>
    </div>

    <!-- Appointments -->
    <div class="card">
        <div class="card-header"><strong>Your Appointments</strong></div>
        <div class="card-body">
            <?php if ($appointments && $appointments->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <?php if ($role === 'Patient'): ?>
                                <th>Dentist</th>
                                <th>Specialization</th>
                            <?php else: ?>
                                <th>Patient</th>
                            <?php endif; ?>
                            <th>Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $appointments->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['AvailableDate']) ?></td>
                            <td><?= htmlspecialchars($row['StartTime']) ?> - <?= htmlspecialchars($row['EndTime']) ?></td>

                            <?php if ($role === 'Patient'): ?>
                                <td><?= htmlspecialchars($row['DentistName']) ?></td>
                                <td><?= htmlspecialchars($row['Specialization']) ?></td>
                            <?php else: ?>
                                <td><?= htmlspecialchars($row['PatientName']) ?></td>
                            <?php endif; ?>

                            <td><?= htmlspecialchars($row['ServiceName']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>

                <?php if ($role === 'Patient' && $patientID === null): ?>
                    <p>You do not have a patient profile yet.</p>
                <?php else: ?>
                    <p>No appointments found.</p>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("include/footer.inc"); ?>
</body>
</html>
