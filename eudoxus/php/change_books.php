
<?php
	session_start();
	
    $username='';
	$error_message='';
	$student_id='';
	$student_semester='';
	$selected_book_id='';
	
	
   if(isset($_SESSION['visitor']) && $_SESSION['visitor']===session_id())
{
	$user=$_SESSION['username'];
	$id=$_SESSION['student_id'];
	
	//database connection
	@DEFINE("DB_USER","root");
	@DEFINE("DB_PASSWORD","potter96");
	@DEFINE("DB_HOST","localhost");
	@DEFINE("DB_NAME","eudoxus");
	
	$db=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
		
		
	//queries to database (find student's data)
	$query="SELECT * FROM users WHERE name='".$user."';";
	$res= $db->query($query);
	$num_res=mysqli_num_rows($res);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	 if($num_res)
        {
            $row=mysqli_fetch_array($res);
            $student_semester=$row['semester'];
			$points=$row['points'];
			$student_id=$row['student_id'];
        }
     else
        {
            $error_message="invalid username";
        }
		
	//find books previously selected by user
	$query="SELECT book_id FROM students_books WHERE student_id='".$student_id."';";
    $res= $db->query($query);
    $num_res=mysqli_num_rows($res);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	if($num_res)
    {
		for ($i = 0 ; $i < $num_res ; $i++){
        $row=mysqli_fetch_array($res);
		$selected_book_id[$i] = $row['book_id'];
		}
		
	$prev_book_points=0;
	for($i = 0 ; $i < sizeof($selected_book_id) ; $i++)
	{
		$query="SELECT * FROM books WHERE id='".$selected_book_id[$i]."';";
		$res= $db->query($query);
		$row=mysqli_fetch_array($res);
		if (!$res) {
			printf("Error: %s\n", mysqli_error($db));
			exit();
		}
		$prev_book_points += $row['points'];
		//$prev_book_titles[$i] = $row['title'];
	}
            
     }
     else
     {
        $error_message="invalid user name (and / or) password";
     }
	 
	 //finds all the possible books the user can choose
	if($student_semester == 4)
	{
		$student_prev_semester = 2;
		$query="SELECT * FROM books WHERE semester='".$student_semester."' OR semester='".$student_prev_semester."';";
	}
	else if ($student_semester == 3)
	{
		$student_prev_semester = 1;
		$query="SELECT * FROM books WHERE semester='".$student_semester."' OR semester='".$student_prev_semester."';";
	}
	else
	{
		$query="SELECT * FROM books WHERE semester='".$student_semester."';";
	}
	
	$res= $db->query($query);
	$num_res_books=mysqli_num_rows($res);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	 if($num_res_books)
        {
            $row=mysqli_fetch_array($res);
        }
     else
        {
            $error_message="invalid username";
        }


?>

<html>
<head>
<title>Change Selection</title>
</head>
<body align="center" bgcolor='lightblue'>
<form name="select_books" method="post" action="">


<?php

   $count = 0;
   //emfanish vivliws pou borei na parei o foithths
   for($i = 0; $i < $num_res_books ; $i++ )
    {
	 
	   //sumvash oti uparxoun 2 vivlia gia kathe mathima
	   if($count % 2 == 0)
	    {
		    echo "<h2>".$row['lesson']."</h2>";
			$lesson_array[$count/2 ] = $row['lesson'];
	    }
	$flag = 0;
	for($j = 0 ; $j < sizeof($selected_book_id) ; $j++)
	{
		if($selected_book_id[$j] == $row['id'])
		{
			$flag = 1;
		}
	}
	if($flag)
	{
		echo "<input type='radio' name='".$row['lesson']."' value='".$row['id']."'checked=\"checked\"required>".$row['title']."-".$row['points']."points<br>";
	}
	else
	{
		echo "<input type='radio' name='".$row['lesson']."' value='".$row['id']."'required>".$row['title']."-".$row['points']."points<br>";
	}
	
	if($i % 2 != 0)
		{
			echo "<input type='radio' name='".$row['lesson']."' value='NULL'reuired>None-0points<br>";
		}
	
	$row=mysqli_fetch_array($res);
	$count++;  
	}
   //submit and it's functions
	echo "<br><br>";
    echo "<td colspan=\"\" align=\"right\">";
	echo "<input type=\"submit\" name=\"sub_button\" value=\"Submit\">";
	echo "</td>";
	
	if(isset($_POST["sub_button"]))	
	{
	for($i = 0 ; $i < sizeof($lesson_array) ; $i++)
	{
		$less=$lesson_array[$i];
		//echo "$less";
		$book_id_array[$i] = $_POST[$less];
	}
	
	//vriskw sunolo pontwn twn epilegmenwn vivliwn
	$book_points=0;
	for($i = 0 ; $i < sizeof($book_id_array) ; $i++)
	{
		$query="SELECT points FROM books WHERE id='".$book_id_array[$i]."';";
		$res= $db->query($query);
		$row=mysqli_fetch_array($res);
		if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
		$book_points += $row['points'];
	}

	if($points > $book_points+$prev_book_points)
	{
		mysqli_query($db, "DELETE FROM students_books WHERE student_id='".$student_id."'");
		for($i = 0 ; $i < sizeof($book_id_array) ; $i++)
		{
		mysqli_query($db, "INSERT INTO students_books VALUES ('$student_id','".$book_id_array[$i]."')");
		}

	$query="SELECT points FROM users WHERE student_id='".$student_id."';";
	$res= $db->query($query);
	$row=mysqli_fetch_array($res);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	$current_points = ($points - $book_points + $prev_book_points);
	mysqli_query($db, "UPDATE users SET points='".$current_points."' WHERE student_id='".$student_id."';");
	?>
	<script type="text/javascript">
	alert("Selection of books is complete!");
	</script>
	<?php
	}
	else{
	?>
	<script type="text/javascript">
	alert("Not enough points! Please try different books.");
	</script>
	<?php

	}
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


</form>
</body>
</html>
