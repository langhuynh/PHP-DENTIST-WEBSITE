    <nav class="container navbar navbar-expand-lg bg-dark navbar-dark" style="border-radius: 5px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <!-- md-auto: left, ml-auto: right, mx-auto: center -->
            <ul class="navbar-nav md-auto">
                <li class="nav-item"><a class="nav-link" id="0" onClick="nav_item_selected(0)" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" id="1" onClick="nav_item_selected(1)" href="service.php">Service</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="dentist.php" id="2" onClick="nav_item_selected(2)">Dentist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php" id="3" onClick="nav_item_selected(3)">Contact Us</a>
                </li>
                <?php if(isset($_SESSION['valid_user'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="member_only.php" id="4" onClick="nav_item_selected(4)"><?php echo $_SESSION['name']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" id="5" onClick="nav_item_selected(4)">Sign-out</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php" id="4" onClick="nav_item_selected(4)">Log-In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking.php" id="5" onClick="nav_item_selected(5)">Booking Now</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <form class="form-inline" action="search.php">
            <input class="form-control mr-sm-2" type="Search" name="key" placeholder="Search">
            <button class="btn light my-sm-0" type="submit">Search</button>
        </form>
    </nav>

