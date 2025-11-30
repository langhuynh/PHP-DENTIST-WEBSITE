<?php
session_start();
include_once('include/config.php'); // DB connection
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
    <link rel="stylesheet" href="css/styles.css">
    <title>Our Services</title>
</head>

<body onLoad="run_first()">

    <?php include("include/banner.inc"); ?>
    <?php include("include/nav.inc"); ?>

    <div class="container mt-5">
        <h1 class="page-title mb-4">Our Services</h1>

        <?php
        $conn = db_connect();
        $sql = "SELECT ServiceName, Description, Image FROM service";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $i = 0; // for zig-zag layout

            while ($row = $result->fetch_assoc()) {

                $serviceName = $row['ServiceName'];
                $description = $row['Description'];
                $image = $row['Image'];

                $reverse = ($i % 2 == 1); // even/odd rows
        ?>

        <div class="row service-card align-items-center mb-5">
            <?php if (!$reverse) { ?>
                <!-- IMAGE LEFT -->
                <div class="col-md-6 p-0">
                    <img src="<?php echo $image; ?>" class="img-fluid service-img">
                </div>
                <!-- TEXT RIGHT -->
                <div class="col-md-6 p-4">
                    <h3><?php echo $serviceName; ?></h3>
                    <p><?php echo $description; ?></p>
                </div>

            <?php } else { ?>
                <!-- TEXT LEFT -->
                <div class="col-md-6 p-4">
                    <h3><?php echo $serviceName; ?></h3>
                    <p><?php echo $description; ?></p>
                </div>
                <!-- IMAGE RIGHT -->
                <div class="col-md-6 p-0">
                    <img src="<?php echo $image; ?>" class="img-fluid service-img">
                </div>
            <?php } ?>

        </div>

        <?php
                $i++;
            }
        } else {
            echo "<p class='text-center'>No services found.</p>";
        }
        ?>

    </div>

    <?php include("include/footer.inc"); ?>
    

</body>
</html>
