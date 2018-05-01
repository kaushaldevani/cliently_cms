<?php

	require dirname(__FILE__).'/api/wordpress_upsert.php';
	include 'config/dbconfig.php';
 
	if($_GET['id'])
	{
		$id = $_GET['id'];
		$dbclass  = new dbConnection();
        $conn = $dbclass-> db_connect();
		$sql = "SELECT * FROM `page` WHERE id = '$id'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				$wp_id = $row['wordpress_id'];
			}
		}
		
		if($wp_id != null)
		{
			$WpClassObj = new wordpressOps();
			$Wp_result = $WpClassObj->DeletePageInWordpress($wp_id);
			
    		if($Wp_result)
		    {
		    	$sql = "DELETE FROM page WHERE id=".$id;
		    	if ($conn->query($sql) === TRUE)
		    	{
		    		echo "<meta http-equiv='refresh' content='0;url=home.php'>";
		    	}
		    	else
		    	{
		    		alert("Error");
		    	}
		    	
	    	}
    		else
    		{
	    	 	alert("Error");
    	 	 }
		 }
		 else
		 {
		 	$sql = "DELETE FROM page WHERE id=".$id;
		 	if ($conn->query($sql) === TRUE)
		 	{
		 		echo "<meta http-equiv='refresh' content='0;url=home.php'>";
		 	}
		 	else
		 	{
		 			    		alert("Error");
 		    }
		 }
	    $conn->close();
			
	}
?>