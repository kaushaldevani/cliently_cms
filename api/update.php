<?php
		header("Content-Type:application/json");
		require dirname(__FILE__).'/wordpress_upsert.php';

		if($_GET['id'])
		{
			$id = $_GET['id'];
			$data = json_decode(file_get_contents('php://input'), true);
			
			$page_name = $data['Page_name'];
			$written_by = $data['Written_by'];
			$job_title = $data['Job_title'];
			$wp_id =$data['wp_id'];
			$tips = $data['tips'];
			$action_data = json_encode($data['action_data']);
			$similar_camps = json_encode($data['similar_camps']);
			$author_image =  $data['author_image'];
			$sql = "UPDATE page SET page_name ='$page_name' , written_by = '$written_by', tips ='$tips', job_title = '$job_title', action_data = '$action_data', similar_camp_data='$similar_camps', author_image='$author_image' WHERE id = '$id'";
			
			$dbclass  = new dbConnection();
			$conn = $dbclass-> db_connect();
			
			if ($conn->query($sql) === TRUE)
			{
				$WpClassObj = new wordpressOps();
				if($wp_id != 0 && $wp_id != null)
				{
					$Wp_result = $WpClassObj->upsertPageInWordpress($id, $wp_id);
				}
				else 
				{
					$Wp_result = $WpClassObj->upsertPageInWordpress($id);
				}
				if($Wp_result)
				{
					$dbclass-> response(200,"Page updated successfully","Sucess");
				}
				else
				{
					$dbclass -> response(201,"Page Updated successfully","Error While Updating Page in Wordpress");
				}
			}
			else
			{
				$dbclass-> response(400, "Error", $conn->error);
			}
		}
		$conn->close();
		
?>
		