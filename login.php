<?php


    require dirname(__FILE__).'/vendor/autoload.php';
    session_start();


    if (!empty($_POST))
    {
    	$user_name =  $_POST['username'];
    	$user_password =  $_POST['password'];
    	$user_id= 0;

    	$dotenv = new Dotenv\Dotenv(__DIR__);
    	$dotenv->load();

    	$servername = $_SERVER['DB_HOST'];
    	$username = $_SERVER['DB_USER'];
    	$password = $_SERVER["DB_PASSWORD"];
    	$dbname = $_SERVER["DB_NAME"];

    	// Create connection
    	$con = new mysqli($servername, $username ,$password, $dbname);

    	// Check connection
    	if ($con ->connect_error)
    	{
    		die("Connection failed: " . $conn->connect_error);
    	}
    	else
    	{

    		$stmt = $con->prepare( "SELECT id,user_name FROM user WHERE user_name = ? AND password = ?");
    		$stmt->bind_param('ss', $user_name, md5($user_password));
    		$stmt->execute();
    		$stmt->bind_result($user_id, $user_name );
    		$stmt->store_result();

    		if($stmt->num_rows == 1)  //To check if the row exists
    		{
    			if($stmt->fetch()) //fetching the contents of the row
    			{

    					$_SESSION['Logged'] = 1;
    					$_SESSION['user_id'] = $user_id;
    					$_SESSION['username'] = $username;
    					header('Location:home.php');
    			}

    		}
    		else
    		{
    			echo "INVALID USERNAME/PASSWORD Combination!";
    		}

		}


		$stmt->close();
		$conn->close();
	}


?>


<!DOCTYPE html>
	<html lang="en">
	<head>
  		<title>clienty cms home</title>
  		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  		<link rel="stylesheet" href="css/login.css" >
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	</head>
  	<body>
			<div class="container">
  <form action="" method="post">
    <div class="row">
      <h2 style="text-align:center">CLIENTLY CMS LOGIN</h2>
      <div class="col">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
      </div>
    </div>
  </form>
</div>


  	</body>
</html>