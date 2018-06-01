<?php

		include '../config/dbconfig.php';
		require dirname(__FILE__).'/../vendor/autoload.php';
		
		header("Content-Type:multipart/form-data");
		header("Content-Type:application/octet-stream");
		$dbclass  = new dbConnection();
		
		$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
		$dotenv->load();
		
		$aws_access_key = $_SERVER['AWS_ACCESS_KEY_ID'];
		$aws_secret =   $_SERVER['AWS_SECRET_ACCESS_KEY'] ;
		
		$credentials = new \Aws\Credentials\Credentials($aws_access_key, $aws_secret);
		$s3_client = new \Aws\S3\S3Client([
  			'version'     => 'latest',
  			'region'      => 'us-west-2',
  			'credentials' => $credentials,
		]);
		
		// Check if file was uploaded without errors
		if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0)
		{
			$allowed = array("jpg" => "image/JPG", "JPG" => "image/JPG", "JPG" => "image/jpeg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
			$filename = $_FILES["photo"]["name"];
			$filetype = $_FILES["photo"]["type"];
			$filesize = $_FILES["photo"]["size"];
			
			
			// Verify file extension
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(!array_key_exists($ext, $allowed)) 
			{
				 $dbclass->response(400,"Something went wrong","Please select a valid file format.");
			}
	       else
	       {
		       	if(in_array($filetype, $allowed))
		       	{
		       		$CurrentDateTime = new Datetime("now");
		       		$timeStamp =  $CurrentDateTime->format('U');
		       		$img_name = str_replace('.'.$ext,'',$_FILES["photo"]["name"]).'_'.$CurrentDateTime->format('U').'.'.$ext;
		       		
		       		//Aws Part
		       		$object = [
		       				'Bucket'      => 'cliently-wp',
		       				'Key'         => 'cliently_cms/' . $img_name,
		       				'SourceFile'  => $_FILES["photo"]["tmp_name"],
		       				'ContentType' => $filetype,
		       				'ACL'         => 'public-read',
		       		];
		       		try
		       		{
		       			$result = $s3_client->putObject($object);
		       			
		       			if($result['@metadata']['statusCode'] == '200')
		       			{
		       				$dbclass->response(200,"Image Uploaded successfully",$img_name);
		       			}
		       			else
		       			{
		       				$dbclass->response(400,"Something went wrong","Error:While uploading Photo to AWS");
		       			}
		       			
		       		}
		       		catch (\Aws\S3\Exception\S3Exception $e)
		       		{
		       			$dbclass->response(400,"Something went wrong",$e->getMessage());
		       		}
		       		
		       	}
		       	else
		       	{
		       		$dbclass->response(400,"Something went wrong","Error : While Uploading Photo might be Invalid formate or Size is too big.");
		       	}
	       }
			// Verify MYME type of the file
			
		} 
		else if(isset($_FILES["video"]) )
		{
			$filetype = $_POST['video-formate'];
		
				$CurrentDateTime = new Datetime("now");
		
				$timeStamp =  $CurrentDateTime->format('U');
				$video_name =  $timeStamp .'.'. $filetype;
				
				$object = [
						'Bucket'      => 'cliently-wp',
						'Key'         => 'cliently_cms/' . $video_name,
						'SourceFile'  => $_FILES["video"]["tmp_name"],
						'ContentType' => $filetype,
						'ACL'         => 'public-read',
				];
				try
				{
					$result = $s3_client->putObject($object);
				
					if($result['@metadata']['statusCode'] == '200')
					{
						$dbclass->response(200,"video Uploaded successfully",$video_name);
					}
					else
					{
						$dbclass->response(400,"Something went wrong","Error:While uploading video to AWS");
					}
				
				}
				catch (\Aws\S3\Exception\S3Exception $e)
				{
					$dbclass->response(400,"Something went wrong",$e->getMessage());
				}
				
		}
		else
		{
			$dbclass->response(400,"Something went wrong","Error : While Uploading video/photo might be Invalid formate or Size is too big.");
		}
		
		
		
?>