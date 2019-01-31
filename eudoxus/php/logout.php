<?php
	echo "<body bgcolor='red'>";
	session_unset($_SESSION['visitor']);
	echo "Session expired,loging out...";
    header("Location: http://localhost/login.php");
    exit;
?>