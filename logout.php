<?php
//must appear BEFORE the <html> tag
session_start();
unset($_SESSION['valid_user']);
unset($_SESSION['name']);
header("location: login.php");
?>
</html>
