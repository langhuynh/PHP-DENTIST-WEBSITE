<?php
//must appear BEFORE the <html> tag
session_start();
include_once('include/config.php');
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
    
    <title>Happy Smile</title>
</head>
<body onLoad="run_first()">
    <?php include("include/banner.inc") ?>
    <?php include("include/nav.inc") ?>
    <div class="container">
    <?php
        //make the database connection
        $conn  = db_connect();
        $sql = "SELECT DentistID, FullName, Specialization, Detail, Image FROM dentist;";
        $result = $conn -> query($sql);
        print "<div class='container mt-4'>\n";
        print "<div class='row'>\n";

        $count = 0;

        while ($row = $result->fetch_assoc()) {

            $Image = $row["Image"];
            $FullName = $row["FullName"];
            $Specialization = $row["Specialization"];
            // $Email = $row["Email"];
            $Detail = $row["Detail"];
            $shortDetail = strlen($Detail) > 100 ? substr($Detail, 0, 100) . "..." : $Detail;

            // Start a new row after every 3 items
            if ($count % 3 == 0 && $count != 0) {
                print "</div><div class='row mt-4'>\n";
            }

            print "<div class='col-md-4'>\n";
            print "   <div class='card mb-4'>\n";

            if ($Image && file_exists($Image)) {
                print "<img src='$Image' class='card-img-top' style='height:500px; object-fit:cover;'>\n";
            }

            print "<div class='card-body'>\n";
            print "<h5 class='card-title'>$FullName</h5>\n";
            print "<p class='card-text'><strong>Specialization:</strong> $Specialization</p>\n";
            print "<p class='card-text'>$shortDetail</p>\n";

            $bookLink = 'book.php?dentist=' . urlencode($FullName);
            print "<div class='text-center mt-2'>\n";   
            print "<a href='dentistDetail.php?id=".$row['DentistID'] . "' class='btn' style='background-color:#1FBFDC; color:white; border:none;'> Read Bio</a>\n";

            // print "<a href='login.php?redirect=dentistDetail.php&dentist=" . $row['DentistID'] . "' class='btn'  style='background-color:#1FBFDC; color:white; border:none;'> Read Bio</a>\n";

            // print "<a href='login.php?id=" . $row['DentistID'] . "' class='btn' style='background-color:#1FBFDC; color:white; border:none;'>Read Bio</a>\n";
            print " </div>\n";

            print "</div>\n";
            print "   </div>\n";
            print "</div>\n";

            $count++;
        }

        print "</div></div>\n";


        $conn->close();
    ?>  
    </div>
    <?php include("include/footer.inc") ?>
</body>
</html>
