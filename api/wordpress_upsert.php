<?php

	include '../config/dbconfig.php';

	class wordpressOps
	{
		const wp_username = "root";
		const wp_password = "root@kd123";
		const wordpress_url = "http://127.0.0.1/wordpress/index.php/wp-json/wp/v2/pages";
		
		public function upsertPageInWordpress($db_id,$wp_id = null) 
		{
			$dbclass  = new dbConnection();
			$conn = $dbclass-> db_connect();
			if($wp_id != null)
			{
				$url = self::wordpress_url.'/'.$wp_id;
			}
			else
			{
				$url = self::wordpress_url;
			}
			$sql = "SELECT * FROM `page` WHERE id = '$db_id'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc()) 
				{

					$action_data = '"action_data" : ' . $row['action_data'];
					$similar_camp = '"similar_camp" : ' . $row['similar_camp_data'];
					$author = '"author" : { "written_by" :"' .$row['written_by'].'", "job_title" :"' .$row['job_title'] .'", "author_image" :"'.$row['author_image'].'"}'; 
					$tips = '"tips" :"' .$row['tips'] .'"';
					$json_str = '{' .$action_data. ',' .$similar_camp. ','. $author. ','. $tips . '}' ;
					
					$post = array(
							'title'  => $row['page_name'],
							'template' => 'main_template.php',
							'content' => $json_str,
					);
					$post = http_build_query($post);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_USERPWD, self::wp_username . ":" . self::wp_password);
					$headers    = array();
					$headers[]  = "Content-Type: application/x-www-form-urlencoded";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$result = curl_exec($ch);
					if (curl_errno($ch)) {
						echo 'Error:' . curl_error($ch);
					}
					curl_close ($ch);
					$raw  = json_decode($result, true);
					$wordpress_id = $raw['id'];
					if(isset($wordpress_id))
					{
						$sql = "UPDATE page SET wordpress_id ='$wordpress_id' WHERE id = '$db_id'";
							
						if ($conn->query($sql) === TRUE)
						{
							return true;
						}
						else
						{
							return false;
						}
					}
				}
			}					
			
			$conn->close();
			
			
		}
		
		public function DeletePageInWordpress($wp_id)
		{
			if($wp_id != null)
			{
			   $url = self::wordpress_url .'/'.	$wp_id;

			    $ch = curl_init();
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_USERPWD, self::wp_username . ":" . self::wp_password);
				
			
			    $result = curl_exec($ch);
			   
				if (curl_errno($ch)) 
				{
					echo '	:' . curl_error($ch);
				}
				curl_close ($ch);
				$raw  = json_decode($result,true);
				$status = $raw['status'] ;	
				if( $status == "trash")
				{
					return true;
				}
				else
				{
					return false;
				}
				
			}
			else
			{
				return true;
			}
			
		}
		
	}


	

?>