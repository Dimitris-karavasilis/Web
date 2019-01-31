<?php
	session_start();
	if(isset($_SESSION['visitor']) && $_SESSION['visitor']===session_id())
	{
	$user=$_SESSION['username'];
	
	@DEFINE("DB_USER","root");
	@DEFINE("DB_PASSWORD","potter96");
	@DEFINE("DB_HOST","localhost");
	@DEFINE("DB_NAME","eudoxus");
	
	$db=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	
	$query="SELECT student_id FROM users WHERE name='".$user."';";
	$res= $db->query($query);
	$row=mysqli_fetch_array($res);
	$student_id = $row['student_id'];
	if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	$query="SELECT books.title FROM books,students_books WHERE students_books.student_id='".$student_id."' AND students_books.book_id = books.id;";
    $res= $db->query($query);
    $num_res=mysqli_num_rows($res);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	
	?>
	
	<html>
<head>
<title>View Selection</title>
</head>
<body align="center" bgcolor='lightblue'>
<h3>The books you have selected are:</h3>

<?php
echo "$num_res";
if($num_res)
    {
		for ($i = 0 ; $i < $num_res ; $i++){
        $row=mysqli_fetch_array($res);
		echo "<li>".$row['title']."</li><br>";
		}
            
     }
     else
     {
        $error_message="invalid user name (and / or) password";
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