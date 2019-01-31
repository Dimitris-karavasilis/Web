<?php
session_start();
if(isset($_SESSION['visitor']) && $_SESSION['visitor']===session_id())
{
	$id=$_SESSION['student_id'];
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
		
		$query="select * from users where name='".$user."';";
        $res= $db->query($query);
		if (!$res) {
			printf("Error: %s\n", mysqli_error($db));
			exit();
		}
		$row=mysqli_fetch_array($res);
	?>
<html>
<head>
<meta content="text/html; charset=utf-8" />
<title>Profile</title>
 
</head>

<body align="center" bgcolor='lightblue'>
    <h1>
    <?php
        echo "Welcome " . $user . "</h3>";
		echo "Name:            ".$row['name']."<br>";
		echo "Remaining Points:".$row['points']."<br>";
    ?>
	</h1>
	<p><a href="./select_books.php">Select your books here</a></p>
    <p><a href="./check_books.php">Check your selected books</a></p>
	<p><a href="./change_books.php">Change your books</a></p>
	<p><a href="./delete_books.php">Delete your book selection</a></p>
	
	<br><br>
    <p><a href="./logout.php">logout</a></p>
</body>

</head>
</html>
<?php
}
else
{
 echo "sorry not in session";
 sleep(2);
  header("Location: http://localhost/logout.php");
 exit;
}
?>
