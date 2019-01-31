<?php
	session_start();
	$student_id='';

    if(isset($_SESSION['visitor']) && $_SESSION['visitor']===session_id())
	{
	$user=$_SESSION['username'];
	$id=$_SESSION['student_id'];
	
	@DEFINE("DB_USER","root");
	@DEFINE("DB_PASSWORD","potter96");
	@DEFINE("DB_HOST","localhost");
	@DEFINE("DB_NAME","eudoxus");
	
	$db=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	
	$query="SELECT student_id FROM users WHERE name='".$user."';";;
	$res= $db->query($query);
	$row=mysqli_fetch_array($res);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	$student_id = $row['student_id'];
	
	echo "$student_id";
	
	
	
?>



<html>
<head>
<title>Delete selection</title>
</head>
<body align="center" bgcolor='lightblue'>
	<h3>Are you sure you want to delete your selection?</h3>
	<form name="form1" action="" method="post">
	<td colspan="2" align="center">
		<input type="submit" name="sub_button" value="DELETE YOUR SELECTION">
		</td>
		</form>
<?php

	if(isset($_POST["sub_button"]))	
	{
		mysqli_query($db, "DELETE FROM students_books WHERE student_id='".$student_id."';");
		mysqli_query($db, "UPDATE users SET points='40' WHERE student_id='".$student_id."';");
		?>
		<script type="text/javascript">
		alert("Your selection is deleted.");
		</script>
		
		<?php
	}
}
else 
	{
 echo "sorry not in session";
 sleep(2);
  header("Location: http://localhost/logout.php");
 exit;
	}
?>

	<p><a href="./profile.php">Back to Profile</a></p>
</body>
</html>