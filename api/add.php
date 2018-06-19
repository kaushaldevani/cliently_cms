<?php

	header("Content-Type:application/json");
    require dirname(__FILE__).'/wordpress_upsert.php';

	$data = json_decode(file_get_contents('php://input'), true);
	$dbclass  = new dbConnection();
	$conn = $dbclass-> db_connect();
	
	$target_1 = $data['Target_1'];
	$target_2 = $data['Target_2'];
	$industry = $data['Industry'];
	$card_summary =  $data['card_summary'];
	$written_by = $data['Written_by'];
	$job_title = $data['Job_title'];
	$tips = $data['tips'];
	$action_data = json_encode($data['action_data']);
	$similar_camps = json_encode($data['similar_camps']);
    $author_image =  $data['author_image']; 	
	
	$stmt = $conn->prepare( "INSERT INTO page (Target_1, Target_2, Industry, written_by, tips, job_title, action_data, similar_camp_data, author_image, card_summary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	
	$stmt->bind_param('ssssssssss', $target_1, $target_2, $industry, $written_by, $tips, $job_title, $action_data, $similar_camps, $author_image, $card_summary); 

	if ($stmt->execute()) 
	{
		if($stmt->insert_id)
		{
			
			$WpClassObj = new wordpressOps();
			$Wp_result = $WpClassObj->upsertPageInWordpress($stmt->insert_id);
			if($Wp_result)
			{
				$dbclass -> response(200,"Page added successfully",$stmt->insert_id);
			}
			else
			{
				$dbclass -> response(201,"Page added successfully","Error While Creating Page in Wordpress");
			}
			
			
		}
	}
	else
	{
		$dbclass->response(400, "Error", $stmt->error);
	}
	
	$stmt->close();
	$conn->close();


?>