<?php

		include '../config/dbconfig.php';
		header("Content-Type:multipart/form-data");
		header("Content-Type:application/octet-stream");
		$dbclass  = new dbConnection();
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
		       		if(move_uploaded_file($_FILES["photo"]["tmp_name"], __DIR__.'/../uploads/Images/'. $img_name))
		       		{
		       			$dbclass->response(200,"Image Uploaded successfully",$img_name);
		       		}
		       		else
		       		{
		       			$dbclass->response(400,"Something went wrong","Error : While Uploading Photo might be Invalid formate or Size is too big.");
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
				if(move_uploaded_file($_FILES["video"]["tmp_name"], __DIR__.'/../uploads/Video_email/'. $video_name))
				{
					$dbclass->response(200,"video Uploaded successfully",$video_name);
				}
				else
				{
					$dbclass->response(400,"Something went wrong","Error : While Uploading video might be Invalid formate or Size is too big.");
				}
		}
		else
		{
			$dbclass->response(400,"Something went wrong","Error : While Uploading video/photo might be Invalid formate or Size is too big.");
		}
		
		
		
?>