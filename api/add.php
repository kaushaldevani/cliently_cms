<?php

	header("Content-Type:application/json");
    require dirname(__FILE__).'/wordpress_upsert.php';

	$data = json_decode(file_get_contents('php://input'), true);
	
	$dbclass  = new dbConnection();
	$conn = $dbclass-> db_connect();
	
	$page_name = $data['Page_name'];
	$written_by = $data['Written_by'];
	$job_title = $data['Job_title'];
	$tips = $data['tips'];
	$action_data = json_encode($data['action_data']);
	$similar_camps = json_encode($data['similar_camps']);
    $author_image =  $data['author_image']; 	
	$sql = "INSERT INTO page (page_name, written_by, tips, job_title, action_data, similar_camp_data, author_image) VALUES ('$page_name','$written_by','$tips', '$job_title','$action_data','$similar_camps', '$author_image' )";	
	
	if ($conn->query($sql) === TRUE) 
	{
		if($conn->insert_id)
		{
			
			$WpClassObj = new wordpressOps();
			$Wp_result = $WpClassObj->upsertPageInWordpress($conn->insert_id);
			if($Wp_result)
			{
				$dbclass -> response(200,"Page added successfully",$conn->insert_id);
			}
			else
			{
				$dbclass -> response(201,"Page added successfully","Error While Creating Page in Wordpress");
			}
			
			
		}
	}
	else
	{
		$dbclass->response(400, "Error", $conn->error);
	}
	
	$conn->close();


?>