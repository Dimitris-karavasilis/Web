<?php
	session_start();
	
    $user_name='';
    $pass_word='';
	$student_id='';
    $error_message='';
    if(isset($_POST['sbmt']))
    {
        $user_name=trim($_POST['user_name']);
        $pass_word=trim($_POST['pass_word']);
        @DEFINE("DB_USER","root");
        @DEFINE("DB_PASSWORD","potter96");
        @DEFINE("DB_HOST","localhost");
        @DEFINE("DB_NAME","eudoxus");
		
		$db=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				exit();
			}
        $db_selected=@mysqli_select_db(DB_NAME);
		echo "$db_selected";

        $query="select * from users where name='" . $user_name . "' and password='" . $pass_word . "'";
        $res=mysqli_query($db,$query);
		$count=mysqli_num_rows($res);
		
        if($count==1)
        {
            $row=mysqli_fetch_array($res);
			$_SESSION['visitor']=session_id();
			$_SESSION['username']=$user_name;
			$_SESSION['student_id']=$row['student_id'];
            //--------------------------------------------------------------------
				 $value="ok";
                header("Location: http://localhost/profile.php");
                exit;
            //--------------------------------------------------------------------
        }
        else
        {
            $error_message.="invalid user name (and / or) password";
        }
    }

?>
<html>
<head>
<title>Login screen</title>
</head>
<body bgcolor='lightblue'>
    <h1>Eudoxus login</h1>
    <?php
        echo "<form name=\"loginform\" method=\"post\" action=\"\">";
        echo "<table border=\"0\">";
            echo "<tr><td>user name</td><td><input type=\"text\" name=\"user_name\" value=\"" . $user_name .  "\"</td></tr>";
            echo "<tr><td>password</td><td><input type=\"password\" name=\"pass_word\" value=\"" . $pass_word .  "\"</td></tr>";
            echo "<tr><td>&nbsp;</td><td><input type=\"submit\" name=\"sbmt\" value=\"log in\"</td></tr>";
        echo "</table>";
        echo "</form>";
        echo "<p style=\"color:#ff0000\">" . $error_message . "</p>";
		?>
		Not registered yet?
		 <p><a href="./register.php">Register</a></p>
</body>
</html>