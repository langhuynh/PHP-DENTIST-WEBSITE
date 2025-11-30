<?php

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
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title> Home </title>
</head>
<body onLoad="run_first()">
	<?php include("include/banner.inc") ?>
    <?php include("include/nav.inc") ?>
    <div class="container">
    <?php
        $conn = db_connect();
        $sql = "SELECT * FROM service;";
        $result = $conn->query($sql);
    ?>
    	<div id="hero">
            <div class="slider">
                <img src="images/AdobeStock_473854744.jpeg" class="slide active img-fluid w-100" alt="Smile 1">
                <img src="images/AdobeStock_3Dteeth.jpeg" class="slide img-fluid w-100" alt="Smile 2">
                <img src="images/AdobeStock_311198389.jpeg" class="slide img-fluid w-100" alt="Smile 3">
                <img src="images/AdobeStock_244031852.jpeg" class="slide img-fluid w-100" alt="Smile 4">
                <img src="images/AdobeStock_283903376.jpeg" class="slide img-fluid w-100" alt="Smile 5">

                <!-- Navigation Arrows -->
                <button class="nav left">&#10094;</button>
                <button class="nav right">&#10095;</button>

                <!-- Dots -->
                <div class="dots">
                    <span class="dot active" data-index="0"></span>
                    <span class="dot" data-index="1"></span>
                    <span class="dot" data-index="2"></span>
                    <span class="dot" data-index="3"></span>
                    <span class="dot" data-index="4"></span>
                </div>
            </div>
        </div>
        <main>
            <div id="intro">
                <p>Welcome to Happy Smile. From routine wellness check-ups and cleanings to dental
                    implants, orthodontics, and cosmetic dentistry, we provide a full spectrum of preventive and
                    restorative care to keep your smile healthy and beautiful.
                </p>
                <div class="promo-columns">
                    <p class="highlight" style="text-shadow: 5px 5px 8px #ccc">
                        <span class="action">HOT NEW!</span> 20% discount on your first dental visit when you book
                        through
                        email! Until April 30, enjoy a 10% discount on your Annual Dental Check-Up at Happy Smile.
                        
                        <a href="services.html"></a>
                    </p>

                    <p class="highlight" style="text-shadow: 5px 5px 8px #ccc">
                        <span class="action">Special offer</span> 25% discount on your next dental visit when you book
                        through our online booking form! Join us for a free dental checkup on Saturday 5th July,
                        starting at 9 am.
                        <a href="dentist.php">Booking now</a>
                    </p>
                </div>

                <div class="promo-columns1">
                    <h1 style="font-weight: bold;">Our Service</h1>
                    <div class="service-columns">
                        <ul class="highlight" style="text-shadow: 5px 5px 8px #ccc">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $ServiceName = $row["ServiceName"];
                                    echo "<li><strong>$ServiceName</strong></li>";
                                }
                            } else {
                                echo "<li>No services found</li>";
                            }
                            ?>
                        </ul>
                    </div>

                </div>

            <div id="trainpic">
                <img src="images/Advert.png" alt="pics" style="height: 322px;margin-top: 18px; margin-bottom: 18px;">
            </div>

            <div class="trainHour" style="background-color: #f2f2f2; padding: 15px;">
                <h1>Trading hours</h1>
                <p>Monday-Friday: 8:30am - 6:30 PM</p>
                <p>Saturday–Sunday: 8:30am - 1:00 PM</p>
            </div>

            <div class="trainHour">

                <p
                    style="border: 1px solid #ccc; text-shadow: 5px 5px 8px #ccc; padding: 15px; color: #0077cc;;">
                    <strong> Happy Smile is thrilled to introduce our new online booking system, making
                        appointment scheduling more convenient than ever. Feel free to give us a call.
                        we are excited to announce a new callout free trial for Dental-checkup for our valued clients.
                        We aim to provide seamless access to quality dental care.
                    </strong>
                </p>
            </div>

            <div id="staff-section">
                <h1 style="font-weight:bold;">Our Team</h1>

                <?php
                    // Fetch staff from database
                    $sqlStaff = "SELECT * FROM Dentist WHERE DentistID IN (2,5,6)";
                    $staffResult = $conn->query($sqlStaff);

                    if ($staffResult && $staffResult->num_rows > 0) {
                        while ($staff = $staffResult->fetch_assoc()) {
                            $name = $staff["FullName"];
                            $photo = $staff["Image"];
                            
                            echo "
                                <div class='homeStaff'>
                                    <h3>$name</h3>
                                    <img src='$photo' class='img-fluid equip' alt='$name'>
                                </div>
                            ";
                        }
                    } else {
                        echo "<p>No staff found</p>";
                    }
                ?>
                <div class='homeStaff'>
                    <h3>Dr. Daniel_Kim</h3>
                    <img src='images/Daniel_Kim.png' class='img-fluid equip' alt='$name'>
                </div>
            </div>


            <a id="link1" href="dentist.php" target="_blank" onclick="show_text('link1','text1','block')">Read more ...</a>
        </main>
	
	<?php include("include/footer.inc") ?>
</body>
</html>
