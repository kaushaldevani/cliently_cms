<?php

require dirname(__FILE__).'/wordpress_upsert.php';

$dbclass  = new dbConnection();
$conn = $dbclass-> db_connect();

	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$ind_list = mysqli_query($conn,"SELECT * FROM industries");
		$list_ind = array();
		
		while($row = mysqli_fetch_array($ind_list))
		{
			array_push($list_ind,$row);
		}
		if (count($list_ind) > 0)
		{
			$dbclass -> response(200,"Got Records",$list_ind);
		}
		else
		{
			$dbclass->response(400, "No record Found");
		}
	}
	else if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
   
		if($data['req_type'] == 'Update' )
		{
			if($data['ind_id'])
			{
				$id = $data['ind_id'];
				$old_value = trim( $data['old_value']);
				$new_value = trim($data['new_value']);
				$stmt = $conn->prepare("UPDATE industries SET Industry = ? WHERE id = ?");
				$stmt->bind_param('si', $new_value, $id);
			}
			else
			{
				$new_value = trim($data['new_value']);
				$old_value = $new_value;
				$stmt = $conn->prepare("Insert industries SET Industry = ? WHERE id = ?");
				$stmt = $conn->prepare( "INSERT INTO industries (Industry) VALUES ( ?)");
				$stmt->bind_param('s', $new_value);
			}
				
			if ($stmt->execute())
			{
				$stmt = $conn->prepare("SELECT * FROM page WHERE Industry = ?");
				$stmt->bind_param('s',$old_value);
					
				if ($stmt->execute())
				{
					$pages_to_update = array();
					$stmt->bind_result($page_id,$written_by,$job_title,$action_data,$similar_camp_data,$tips,$author_image,$wordpress_id,$Industry,$Target_1,$card_summary,$Target_2);
			
					while ($stmt->fetch())
					{
						$pages = array('page_id'=>$page_id, 'wordpress_id'=>$wordpress_id);
						array_push($pages_to_update,$pages);
					}
			
					foreach ($pages_to_update as $page_update)
					{
						$stmt = $conn->prepare("UPDATE page SET Industry = ? WHERE id = ?");
						$stmt->bind_param('si', $new_value, $page_update['page_id']);
						if ($stmt->execute())
						{
							$WpClassObj = new wordpressOps();
							if($page_update['wordpress_id'] != 0 && $page_update['wordpress_id'] != null)
							{
								$Wp_result = $WpClassObj->upsertPageInWordpress($page_update['page_id'], $page_update['wordpress_id']);
							}
							else
							{
								$Wp_result = $WpClassObj->upsertPageInWordpress($page_update['page_id']);
							}
			
							if(!$Wp_result)
							{
								$dbclass-> response(400, "Error", "Error While updating Page in Wordpress");
							}
						}
						else
						{
							$dbclass-> response(400, "Error","Error While updating Page in CMS");
						}
					}
					$dbclass-> response(200, "Success", "Updated Successfully ");
				}
				else
				{
					$dbclass-> response(400, "Error", $stmt->error);
				}
			}
			else
			{
				$dbclass-> response(400, "Error", "Error While updating Industry");
			}
			
			$stmt->close();
			
		}
		else if($data['req_type'] == 'Delete' )
		{
			
			if($data['ind_id'])
			{
				$id = $data['ind_id'];
				$value = $data['value'];
				$empty_value = "";
				$stmt = $conn->prepare("DELETE FROM industries WHERE id= ? ");
				$stmt->bind_param('i',$id);
				if ($stmt->execute())
				{
					$stmt = $conn->prepare("SELECT * FROM page WHERE Industry = ?");
					$stmt->bind_param('s',$value);
						
					if ($stmt->execute())
					{
						$pages_to_update = array();
						$stmt->bind_result($page_id,$written_by,$job_title,$action_data,$similar_camp_data,$tips,$author_image,$wordpress_id,$Industry,$Target_1,$card_summary,$Target_2);
							
						while ($stmt->fetch())
						{
							$pages = array('page_id'=>$page_id, 'wordpress_id'=>$wordpress_id);
							array_push($pages_to_update,$pages);
						}
						
						foreach ($pages_to_update as $page_update)
						{
							$stmt = $conn->prepare("UPDATE page SET Industry = ? WHERE id = ?");
							$stmt->bind_param('si', $empty_value, $page_update['page_id']);
							if ($stmt->execute())
							{
								$WpClassObj = new wordpressOps();
								if($page_update['wordpress_id'] != 0 && $page_update['wordpress_id'] != null)
								{
									$Wp_result = $WpClassObj->upsertPageInWordpress($page_update['page_id'], $page_update['wordpress_id']);
								}
								else
								{
									$Wp_result = $WpClassObj->upsertPageInWordpress($page_update['page_id']);
								}
									
								if(!$Wp_result)
								{
									$dbclass-> response(400, "Error", "Error While updating Page in Wordpress");
								}
							}
							else
							{
								$dbclass-> response(400, "Error","Error While updating Page in CMS");
							}
						}
						
						$dbclass-> response(200, "Success", "Deleted Successfully");
					}
					else
					{
						$dbclass-> response(400, "Error", $stmt->error);
					}
				}
				else
				{
					$dbclass-> response(400, "Error", "Error While Deleting Industry");
				}
			}
			else 
			{
				$dbclass-> response(400, "Error", "Bad Request");
			}
				
			$stmt->close();
		}
	}		
	

	
$conn->close();

?>