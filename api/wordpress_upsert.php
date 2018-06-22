<?php

// 	include '../config/dbconfig.php';
	require dirname(__FILE__).'/../config/dbconfig.php';
	require dirname(__FILE__).'/../vendor/autoload.php';

	class wordpressOps
	{

		private $wp_username;
		private $wp_password;
		private $wordpress_url;

		public function __construct()
		{
			$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
			$dotenv->load();

			$this->wp_username = $_SERVER['WP_USERNAME'];  //"root";
			$this->wp_password =   $_SERVER['WP_PASSWORD'] ;//"root@kd123";
			$this->wordpress_url = $_SERVER['WORDPRESS_URL'];; //"http://127.0.0.1/wordpress/index.php/wp-json/wp/v2/pages";

		}

		public function upsertPageInWordpress($db_id,$wp_id = null)
		{
			$dbclass  = new dbConnection();
			$conn = $dbclass-> db_connect();
			if($wp_id != null)
			{
				$url = $this->wordpress_url.'/'.$wp_id;
			}
			else
			{
				$url = $this->wordpress_url;
			}

			$sql = "SELECT * FROM `page` WHERE id = '$db_id'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{

					$industry = '"industry_data":{ "ind_1":"'.$row['Target_1'] .'","ind_2":"'.$row['Target_2'].'"}';
					$action_data = '"action_data" : ' . $row['action_data'];
					$similar_camp = '"similar_camp" : ' . $row['similar_camp_data'];
					$author = '"author" : { "written_by" :"' .$row['written_by'].'", "job_title" :"' .$row['job_title'] .'", "author_image" :"'.$row['author_image'].'"}';
					$tips = '"tips" :"' .$row['tips'] .'"';
					$card_summary = '"card_summary":"'. $row['card_summary'].'"';
					$json_str = '{'.$card_summary. ','. $industry. ',' .$action_data. ',' .$similar_camp. ','. $author. ','. $tips . '}' ;

					$post = array(
							'title'  => $row['Target_1'].' targeting '.$row['Target_2'],
							'template' => 'main_template.php',
							'content' => $json_str,
							'slug'=> $row['Target_1'].' targeting '.$row['Target_2']
					);
					$cat = array();

					$sql = "SELECT * FROM `industries` WHERE Industry = '" . $row['Industry'] . "'";
					$ind_result = $conn->query($sql);
					if ($ind_result->num_rows > 0)
					{
						while($ind_row = $ind_result->fetch_assoc())
						{
							$ind_wp_id = $ind_row['wordpress_id'];
					
							if($ind_wp_id != null)
							{
								array_push($cat,$ind_wp_id);
							}
						}
					}
					
					
					if(count($cat) > 0)
					{
						$post['categories'] = $cat;
					}
					else
					{
						$post['categories'] = array(1);
					}
					
					
					
					$post = http_build_query($post);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_USERPWD, $this->wp_username. ":" . $this->wp_password);
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
			   $url = $this->wordpress_url .'/'.	$wp_id;

			    $ch = curl_init();
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_USERPWD, $this->wp_username . ":" . $this->wp_password);


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
		
		public function upsertCategoryInWordpress($db_id)
		{
			$dbclass  = new dbConnection();
			$conn = $dbclass-> db_connect();
			$wp_url = $this->wordpress_url;
			
		
			$sql = "SELECT * FROM `industries` WHERE id = '$db_id'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					
					$wp_id = $row['wordpress_id'];

					if($wp_id != null)
					{
						$url = str_replace("pages","categories",$wp_url).'/'. $wp_id;
					}
					else
					{
						$url = str_replace("pages","categories",$wp_url);
					}
					$post = array(
							'name'  => $row['Industry']
					);
					$post = http_build_query($post);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_USERPWD, $this->wp_username. ":" . $this->wp_password);
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
						$sql = "UPDATE industries SET wordpress_id ='$wordpress_id' WHERE id = '$db_id'";
					
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
		
		public function DeleteCategoryInWordpress($db_id)
		{
			if($db_id != null)
			{
				$dbclass  = new dbConnection();
				$conn = $dbclass-> db_connect();
				
				$sql = "SELECT * FROM `industries` WHERE id = '$db_id'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
					{
						$wp_id = $row['wordpress_id'];
						
						if($wp_id != null)
						{
							$url = str_replace("pages","categories",$this->wordpress_url).'/'. $wp_id .'?force=true';
								
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_USERPWD, $this->wp_username . ":" . $this->wp_password);
							
							$result = curl_exec($ch);
							
							if (curl_errno($ch))
							{
								echo '	:' . curl_error($ch);
							}
							curl_close ($ch);
							$raw  = json_decode($result,true);
							$status = $raw['deleted'];
							
							if($status)
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
				
				$conn->close();
			}
			
		
		}

	}




?>