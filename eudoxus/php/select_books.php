
<?php
session_start();
if(isset($_SESSION['visitor']) && $_SESSION['visitor']===session_id())
{
	$user=$_SESSION['username'];
	$student_id=$_SESSION['student_id'];
	$error_message='';
	$student_semester='';
	$points='';
	$lessons_array='';
	$less='';
	$book_id_array='';

	
		@DEFINE("DB_USER","root");
        @DEFINE("DB_PASSWORD","potter96");
        @DEFINE("DB_HOST","localhost");
        @DEFINE("DB_NAME","eudoxus");
		
		$db=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
	//queries to database (1)
	$query="SELECT * FROM users WHERE name='".$user."';";
	$res= $db->query($query);
	$num_res=mysqli_num_rows($res);
	
	 if($num_res)
        {
            $row=mysqli_fetch_array($res);
            $student_semester=$row['semester'];
			$points=$row['points'];
        }
     else
        {
            $error_message="invalid username";
        }
		
	//queries to database (2)
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
<title>Book Selection</title>
</head>
<body align="center" bgcolor='lightblue'>
<form name="select_books" method="post" action="">
   <?php
   $count = 0;
  //emfanish vivliws pou borei na parei o foithths
   for($i = 0; $i < $num_res_books ; $i++ )
   {
	 
	   //sumvash oti uparxoun 2 vivlia gia kathe mathima
	   if($count % 2 == 0){
		    echo "<h2>".$row['lesson']."</h2>";
			$lesson_array[$count/2 ] = $row['lesson'];
	   }
		
		echo "<input type='radio' name='".$row['lesson']."' value='".$row['id']."'required>".$row['title']."-".$row['points']."points<br>";
		if($i % 2 != 0)
		{
			echo "<input type='radio' name='".$row['lesson']."' value='NULL'required>None-0points<br>";
		}
	   $row=mysqli_fetch_array($res);
	   $count++;
	   
   }
   //echo $lesson_array[0], $lesson_array[1], $lesson_array[2],$lesson_array[3];


    echo "<br><br>";
    echo "<td colspan=\"\" align=\"right\">";
	echo "<input type=\"submit\" name=\"sub_button\" value=\"Submit\">";
	echo "</td>";

	//ksekinaw to prohgoumeno query ap thn arxh gia na borw na prospelasw ta stoixeia pou epistrefei ksana
	$res= $db->query($query);
	$row=mysqli_fetch_array($res);
			if (!$res) {
			printf("Error: %s\n", mysqli_error($db));
			exit();
		}
	//Submit kai leitourgikothta 
	
if(isset($_POST["sub_button"]))	
	{
	for($i = 0 ; $i < sizeof($lesson_array) ; $i++)
	{
		$less=$lesson_array[$i];
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
	
	//------------------------------------------------------------------------------------------
	$query_num_books="SELECT * FROM students_books WHERE student_id='".$student_id."';";
	$res_num_books= $db->query($query_num_books);
	$num_of_books=mysqli_num_rows($res_num_books);
			if (!$res_num_books) {
			printf("Error: %s\n", mysqli_error($db));
			exit();
		}
	//------------------------------------------------------------------------------------------

	if(($points > $book_points) && ($num_of_books==''))
	{
		for($i = 0 ; $i < sizeof($book_id_array) ; $i++)
		{
			mysqli_query($db, "INSERT INTO students_books VALUES ('$student_id','".$book_id_array[$i]."')");
		}
		//kanei update stous pontous tou mathith
	$query="SELECT points FROM users WHERE student_id='".$student_id."';";
	$res= $db->query($query);
	$row=mysqli_fetch_array($res);
	$current_points = ($points - $book_points);
	mysqli_query($db, "UPDATE users SET points='".$current_points."' WHERE student_id='".$student_id."';");
	
		?>
		<script type="text/javascript">
		alert("Selection of books is complete!");
		</script>
		<?php
	}
	else
	{
		if($points < $book_points)
		{
			?>
			<script type="text/javascript">
			alert("Not enough points! Please try different books.");
			</script>
			<?php
		}
		else if($num_of_books)
		{
			?>
			<script type="text/javascript">
			alert("You have already selected your books.Go to \"Change your books\" to change them.");
			</script>
			<?php
		}
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
</form>
<p><a href="./profile.php">Back to profile</a></p>
</body>
</html>