<?php

	require dirname(__FILE__).'/api/wordpress_upsert.php';
	
 
	if($_GET['id'])
	{
		$id = $_GET['id'];
		$dbclass  = new dbConnection();
        $conn = $dbclass-> db_connect();
		$stmt = $conn->prepare("select * from page WHERE id = ?");
		
		$stmt->bind_param('i',$id);
		
		if ($stmt->execute())
		{
			    $result = $stmt->get_result();
				
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
						$stmt = $conn->prepare("DELETE FROM page WHERE id= ? ");
						$stmt->bind_param('i',$id);
						
						if ($stmt->execute())
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
					$stmt = $conn->prepare("DELETE FROM page WHERE id= ? ");
					$stmt->bind_param('i',$id);
					
					if ($stmt->execute())
					{
						echo "<meta http-equiv='refresh' content='0;url=home.php'>";
					}
					else
					{
						alert("Error");
					}
				}
		}
		
		$stmt->close();
		$conn->close();
			
	}
?>