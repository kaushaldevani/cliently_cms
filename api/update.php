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

			$dbclass  = new dbConnection();
			$conn = $dbclass-> db_connect();
			
			$stmt = $conn->prepare("UPDATE page SET page_name = ? , written_by = ?, tips =?, job_title = ?, action_data = ?, similar_camp_data=?, author_image=? WHERE id = ?");
			
			$stmt->bind_param('sssssssi', $page_name, $written_by, $tips, $job_title, $action_data, $similar_camps, $author_image, $id);
			
			if ($stmt->execute())
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
				$dbclass-> response(400, "Error", $stmt->error);
			}
		}
		$stmt->close();
		$conn->close();
		
?>
		