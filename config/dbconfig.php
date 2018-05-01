<?php


class dbConnection
{

   
   function db_connect()
    {
    	$servername = "localhost";
    	$username = "root";
    	$password = "root";
    	$dbname = "cliently_cms_backend";
    	
    	// Create connection
    	 $con = new mysqli($servername, $username, $password, $dbname);
    	
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