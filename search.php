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
    <title> Happy Smile </title>
</head>
<body onLoad="run_first()">
	<?php include("include/banner.inc") ?>
    <?php include("include/nav.inc") ?>
    <div class="container">
    <?php
    
        //make the database connection
        $conn  = db_connect();

        //get user input
        $key = '';
        if(isset($_GET['key'])) {
            $key = $conn -> real_escape_string($_GET['key']);
        }

		//create and execute a query
		$sql = "SELECT * FROM dentist";
        //note: SQL is case-insensitive by default
        $sql = $sql . " WHERE (FullName like '%$key%') or (Specialization like '%$key%') or (Detail like '%$key%');";
		$result = $conn -> query($sql);

        //output result
		print "<h1>Dentist</h1>\n";
        print "<div class='container mt-4'>\n";
        print "<div class='row'>\n";

        $count = 0;

        while ($row = $result->fetch_assoc()) {

            $DentistID = $row['DentistID'];  
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
                print "<img src='$Image' class='card-img-top' style='height:350px; object-fit:cover;'>\n";
            }

            print "<div class='card-body'>\n";
            print "<h5 class='card-title'>$FullName</h5>\n";
            print "<p class='card-text'><strong>Specialization:</strong> $Specialization</p>\n";
            print "<p class='card-text'>$shortDetail</p>\n";

            $bookLink = 'dentistDetail.php?id=' .$DentistID;
            print "<div class='text-center mt-2'>\n";
            print " <a href='$bookLink' class='btn btn-primary'>Book Now</a>\n";
            print " </div>\n";

            print "</div>\n";
            print "   </div>\n";
            print "</div>\n";

            $count++;
        }

        print "</div></div>\n";

        $conn -> close();
	?>	
    </div>
	<?php include("include/footer.inc") ?>
</body>
</html>