<?php
require dirname(__FILE__).'/../vendor/autoload.php';

session_start();
class dbConnection
{
	
	public function __construct()
	{
		if(!($_SESSION['Logged'] == 1 && !empty($_SESSION['user_id'])) )
		{
			header('Location:login.php');
		}
	
	}
	
   function db_connect()
    {
    	
    	$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
    	$dotenv->load();
    	
    	$servername = $_SERVER['servername'];
    	$username = $_SERVER['username'];
    	$password = $_SERVER["password"];
    	$dbname = $_SERVER["dbname"];
    	
    
    	// Create connection
    	 $con = new mysqli($servername, $username ,$password, $dbname);
    	
    	// Check connection
    	if ($con ->connect_error)
    	{
    		die("Connection failed: " . $conn->connect_error);
    	}
    	else
    	{
    		return $con;
    	}
    	
    	 
    }
    

    
    function response($status,$status_message,$data)
    {
    	header("HTTP/1.1 ".$status);
    
    	$response['status']=$status;
    	$response['status_message']=$status_message;
    	$response['data']=$data;
    
    	$json_response = json_encode($response);
    	echo $json_response;
    }

}
		
	
?>