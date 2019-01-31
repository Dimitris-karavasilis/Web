<html>
<head>
<title>Custom Eudoxos</title>
</head>
<body bgcolor='lightblue'>

<h1>Give your data</h1>
<form name="form1" action="" method="post">
    <table>
	<tr>
	<td>Enter Username</td>
	<td><input type="text" name="username" required pattern="[A-Za-Z0-9]+"><td>
	</tr>
	
	<tr>
	<td>Enter Password</td>
	<td><input type="password" name="password" required ><td>
	</tr>
		
	<td colspan="2" align="center">
	<input type="submit" name="sub_button" value="Submit">
	</td>
	</table>
	</form>
	
<?php

if(isset($_POST["sub_button"]))	
{
	 @DEFINE("DB_USER","root");
        @DEFINE("DB_PASSWORD","potter96");
        @DEFINE("DB_HOST","localhost");
        @DEFINE("DB_NAME","eudoxus");
		
		$db=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	
	$count = 0;
	$res = mysqli_query($db, "select * from users where name = '$_POST[username]'");
	$count = mysqli_num_rows($res);
	
	if($count > 0)
	{?>
	
	<script type="text/javascript">
	alert("This username already exists. Please try another.");
	</script>
	<?php	
	}
	else
	{
	mysqli_query($db, "insert into users values(NULL,'$_POST[username]','$_POST[password]',40,1 )");
	?>
	<script type="text/javascript">
	alert("Registratiuon is complete!");
	</script>
	<?php
	}
}
?>
	
	<p><a href="./login.php">Go Back to Login</a></p>
	
</body>
</html>