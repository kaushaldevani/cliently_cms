<?php
	

	require dirname(__FILE__).'/config/dbconfig.php';

	$dbclass  = new dbConnection();
	$conn = $dbclass-> db_connect();

	$ind_list = mysqli_query($conn,"SELECT * FROM industries");
	
	$list_ind = array();
	
	while($row = mysqli_fetch_array($ind_list))
	{
		array_push($list_ind,$row);
	}
	
	$aws_upload_url = 'https://cliently-wp.s3.us-west-2.amazonaws.com/cliently_cms/';
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	if($_GET['id'])
	{
		$id = $_GET['id'];
		
		$stmt = $conn->prepare("select * from page WHERE id = ?");
		
		$stmt->bind_param('i',$id);
		
		if ($stmt->execute())
		{
			$result = $stmt->get_result();
			
			while($row=mysqli_fetch_array($result))
			{
				$industry_1 =  $row["Industry_1"];
				$industry_2 =  $row["Industry_2"];
				$card_summary =  $row['card_summary'];
				$written_by = $row["written_by"];
				$job_title =  $row["job_title"];
				$action_data = $row["action_data"];
				$wp_id = $row["wordpress_id"];
				$similar_camp_data = $row["similar_camp_data"];
				$tips = $row["tips"];
				$author_img = str_replace('"', '', $row['author_image']) ;
				if($author_img)
				{
					$autho_img__url =$aws_upload_url. $author_img;
				}
				else
				{
					$autho_img__url = "~/../images/profile-blank.png";
				}
				?>
			
			             <!DOCTYPE html>
						<html>
				        <head>
							<meta charset="UTF-8">
							<script type="text/javascript" src="js/jquery.min.js"></script>
							<script type="text/javascript" src="js/bootstrap.min.js"></script>
							<script type="text/javascript" src="js/jquery-ui.js"></script>
							<script type="text/javascript" src="js/jquery.hotkeys.js"></script>
							<script type="text/javascript" src="js/bootstrap-wysiwyg.js"></script>
							<script type="text/javascript" src="js/advance.js"></script>
							<script type="text/javascript" src="js/wysihtml5-0.4.0pre.min.js"></script>
							<script type="text/javascript" src="js/add.js"></script>
							
							
							
							<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
							<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
							<link href="css/add.css" rel="stylesheet" type="text/css">
							<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
					
					
					
					          <?php echo "<script type=\"text/javascript\"> 
							        $(document).ready(function() { 
							            $('input#ind_1').val('$industry_1');
							            $('select#ind_2').val('$industry_2');
							            $('textarea#card_summary').val('$card_summary');
							            $('input#written_by').val('$written_by');
							            $('input#Job_title').val('$job_title');
							            $('textarea#editor-toolbar-for-tips').val('$tips');
							            console.log($action_data);
							            $action_data.forEach((action, index) => 
							            {
			  								 addaction(action);								
										});
										$similar_camp_data.forEach((camp, index) => 
							            {
			  								 addCampaign(camp);								
										});
							            
							            
							            
						            
					                 });
			 	   						  </script>";?>
							<title>clienty cms add</title>
						</head>	
						<body>
					       <div class="navigation" >
					          <a href="/cliently_cms/home.php" type="button" style="float:left;" class="btn btn-primary btn-md">Go to Home Page</button></a>
          					  <a href="/cliently_cms/logout.php" type="button" style="float:right;" class="btn btn-primary btn-md" >Logout</a>
					       </div>
						   <div class="row">
				     			<div class="col-sm-4"></div>
					 			<div class="main_area col-sm-4">
			             
			                 		<!-- basic detail area -->
			                 		<div class="detail">
				                     	<div class="form-group">
				  					 		<!-- <label for="page_name">Page Name</label> -->
				  							<input type="text" class="form-control" id="ind_1" placeholder="Industry 1" required>
  									   <!-- <input type="text" class="form-control" id="ind_2" placeholder="Industry 2" style="margin-top:10px;"required>  -->
				  						<select class="form-control" id="ind_2"placeholder="Industry 2" style="margin-top:10px;"required>
				      						 <?php 
				      						    foreach ($list_ind as $ind)
				      						    {?>
				      						    	<option><?php echo $ind["Industry"] ;?></option>  
				      						   <?php  }
				      						 ?>
				      					</select>
				      					<textarea id="card_summary" class="form-control" placeholder="Card Summary" style="margin-top: 10px;"></textarea>					
									 	</div>
			                	 	</div>        
			           		        <!-- end of basic detail area -->
			                          
			                 		<!-- action area -->
			                 		<div class="flow-action slimScrollBar-for-action-box">
			                      		<div id="action_template" style="display:none;" >
			                      			<div class="action-in-flow">
				                  	    		<i class="fa fa-bars fa-fw action-in-flow-Shape"></i>
				                     		    <div class="action-flow-image">
				  	                     			<img src="images/email.svg">
				                     			</div>  
					                  			<div class="action-details">
					                      			<div class="action-name">STEP 1 - EMAIL </div>
						   			  		    	<div class="action-detail">{FirstName}, quick question</div>
						   			  		    	<i class="fa fa-trash delete_action" aria-hidden="true"></i>	
						   			  		    	<div class="hidden_data_for_action"></div>
				                   				</div>    
			                       			</div>
			                      		</div>
			                    	</div>   
			                      <div class="action action-link" id="defaultAddLink" style="display:none;"><a>+</a></div>
			                      <button id="email_opener" style="display:none;" data-toggle="modal" data-target="#work-pane-email-send"></button>
			                      <button id="wait_opener" style="display:none;" data-toggle="modal" data-target="#work-pane-event-time-delay"></button>
			                      <button id="post_card_opener" style="display:none;" data-toggle="modal" data-target="#work-pane-postcard"></button>
			                      <button id="video_opener" style="display:none;" data-toggle="modal" data-target="#work-pane-email-video"></button>
			                      <button id="linkedin_opener" style="display:none;" data-toggle="modal" data-target="#linkedin"></button>
			                      <button id="twitter_opener" style="display:none;" data-toggle="modal" data-target="#twitter-follow"></button>
			                      <button id="gift_opener" style="display:none;" data-toggle="modal" data-target="#gifting"></button>
			                      <button id="handwritten_note_opener" style="display:none;" data-toggle="modal" data-target="#handwritten_notes"></button>
			                      
			                      <div class="mainAddActionLink">
			                      	  <select id="action_selector">
			                      	       <option value="email_opener" >EMAIL</option>
			                      	       <option value="wait_opener" >WAIT</option>
			                      	       <option value="video_opener">VIDEO MESSAGE</option>
			                      	       <option value="post_card_opener">POST CARD</option>
			                      	       <option value="handwritten_note_opener">HANDWRITTEN NOTES</option>
			                      	       <option value="gift_opener">GIFTS</option>
			                      	       <option value="linkedin_opener">LINKEDIN</option>
			                      	       <option value="twitter_opener">TWITTER</option>
			                      	  </select>
			                      	  <div id="mainAddActionLink" title="Add action">+</div>
			                       </div>
			                 
			                 <!-- end of action area -->
			                 
			                 <!-- Tips area -->
			                 <div class="tips">
			                 		
			                 	<div class="tips_clikable">
			               	    	<h1>TIPS <i class="fa fa-pencil" data-toggle="modal" data-target="#work-pane-tips" aria-hidden="true"></i></h1>
			  	                </div>
			                 
			                 
			                 </div>
			                 <!-- end of Tips area -->
			                 
			                 <!-- Author area -->
			                 <div class = "author">
			               	    <h4>AUTHOR</h4>
			               	    <div class="form-group">
			  						<input type="text" class="form-control" id="written_by" placeholder="WRITTEN BY">
			  						<input type="text" class="form-control" id="Job_title"  placeholder="JOB TITLE">
			  						
			  						<div style="display:inline-block">
			  							<img id="author_img" style="width: 100px;height: 100px;float: left;	" src=<?php echo $autho_img__url;?> alt="your image" />
			  							<input type='file'  id="author_img_input" style="padding: 36px;" />
			  							
								    </div>
								 </div>
			                 </div> 
			                 <!-- End of Author area -->
			                 
			                 <!-- Similar campaigns area -->
			                 <div class="sim_camp">
			                    <div class="sim_camp_header">
			                    	<h4 style="float:left">SIMILAR CAMPAIGNS</h4>
			                    	<div id="sim_camp_add_link" title="Add CAMPAIGNS">+</div>
			               	     </div> 
			               	      <div class="form-group similar_campaigns_template">
			  						<input type="text" class="form-control camp_title" placeholder="LINK TITLE">
			  						 <i class="fa fa-trash sim_camp_delete" aria-hidden="true"></i>
			  						 <input type="text" class="form-control camp_url"  placeholder="LINK URL">
			  						
								  </div>
			                 
			                 </div>
			                 <!-- end of Similar campaigns area  -->
			                 
			                 <!-- final Submit data Area -->
			                    <div class="submit_area">
			                       <button id="update_page" page_id ="<?php echo $id ;?>"  wp_id="<?php echo $wp_id ;?>" type="button" class="btn btn-primary btn-lg" style="width: 50%;">Update</button>
			                    </div>
			                  
			                 <!-- end of final Submit data Area  -->
			                 
			           
			             
			       </div>
			         <div class="col-sm-4"></div>
			       </div>
			       <!--End of main area--> 
			       
			       <!-- modal area -->
				     <div id="work-pane-event-time-delay" class="modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" data-dismiss="modal" class="close">×</button>
							<h4 class="modal-title"><i class="fa fa-clock-o"></i> Time
								Delay</h4>
					</div>
						<div class="modal-body">
							<div class="work-creation-wizard-step"
							id="work-creation-wizard-step-work-pane-event-time-delay"
							data-step="work-pane-event-time-delay">
								<form class="form work-form">
									<div class="row ">
										<div class="form-group col-sm-6 timedelayForm ">
										<label style="display: -webkit-inline-box; font-size: 23px">
											<input id="wait_day"type="text" name="type_value" class="form-control" size="2" />&nbsp;Days
										</label>
						                <label style="margin-bottom: 0px; margin-top: 15px;">Send
													only on Weekday 9AM - 5PM ?</label>
												<div class="radio"><label><input type="radio" name="only_weekend" value="yes">YES</label></div>
												<div class="radio"><label><input type="radio" name="only_weekend" value="no">NO</label></div></div>
									</div> <input type="hidden" name="type" value="day"> <input
										type="hidden" name="weekends" value="true">
								</form>
							</div>
						</div>
							<div class="modal-footer">
							    <button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
								<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
								<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
				</div>
				
				
					<div id="twitter-follow" class="modal">
				   	<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">×</button>
								<h4 class="modal-title"><i class="fa fa-user-plus"></i> Twitter - Follow</h4>
							</div>
							<div class="modal-body">
								<div class="work-creation-wizard-step" id="work-creation-wizard-step-work-pane-twitter-follow" data-step="work-pane-twitter-follow" style="display: block;">
									  <form class="form work-form">
											<div class="row ">
												<div class="form-group col-sm-6 ">
													<label style="margin-bottom: 0px; margin-top: 15px;">FOLLOW OR UNFOLLOW</label>
													<div class="radio"><label><input type="radio" value="FOLLOW" name="radio_twitter">FOLLOW</label></div>
													<div class="radio"><label><input type="radio" value="UNFOLLOW" name="radio_twitter">UNFOLLOW</label></div></div>
											</div> 
									   </form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
								<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
								<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					</div>
					
					
					<div id="handwritten_notes" class="modal">
				   	<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">×</button>
								<h4 class="modal-title"><img class="gmailimg" src="~/../images/hwnote.svg"> Handwritten Notes</h4>
							</div>
							<div class="modal-body">
								<div class="work-creation-wizard-step" id="work-creation-wizard-step-work-pane-handwritten-notes" data-step="work-pane-handwritten-notes" style="display: block;">
									  <form class="form work-form">
											<div class="row ">
												<div class="form-group col-sm-12">
													 <label for="message_for_handWrittent_note">MESSAGE</label>
												     <textarea class="form-control" rows="8" id="message_for_handWrittent_note"></textarea>
													 <select id="script_for_handWrittent_note" class="form-control select_form_35">
				                     	     			   <option value="PRINT" >PRINT</option>
				                      	  			 </select>
				                      	  			 <select id="ink_color_for_handWrittent_note" class="form-control select_form_35" style="margin-left:20px;">
				                      	     			   <option value="BLACK" >BLACK</option>
				                      	  			 </select>
				                      	  			 <div style="float: left;margin-top: 20px">
				                      	  			 	<label for="envelop_for_handWrittent_note" style="float: left;width: 100%;">ENVELOP :</label>
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_full_name" placeholder="TO : FULL NAME">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_full_name" placeholder="FROM : FULL NAME">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_company" placeholder="TO : COMPANY">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_company" placeholder="FROM : COMPANY">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_line1" placeholder="TO : LINE 1">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_line1" placeholder="FROM : LINE 1">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_line2" placeholder="TO : LINE 2">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_line2" placeholder="FROM : LINE 2">
													 </div>
													 <div style="float: left;margin-top: 20px">
				                      	  			 	<label for="envelop_for_handWrittent_note" style="float: left;width: 100%;">ENVELOPE / INK COLOR </label>
				                      	  			 	<select id="envelop_ink_color_for_handWrittent_note" class="form-control">
				                      	     			   <option value="WHITE w BLACK INK" >WHITE w BLACK INK</option>
				                      	  			    </select>
													 </div>
												</div>
												
											</div> 
									   </form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
								<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
								<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					</div>
				    
				    <div id="work-pane-postcard" class="modal">
				   	<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">×</button>
								<h4 class="modal-title"><img class="gmailimg" src="~/../images/postcard.svg"> Post Card</h4>
							</div>
							<div class="modal-body">
								<div class="work-creation-wizard-step" id="work-creation-wizard-step-work-postcard" data-step="work-pane-postcard" style="display: block;">
									  <form class="form work-form">
											<div class="row ">
												<div class="form-group col-sm-12">
													 
													 <div class="front_image_con postcard_img_con">
													    <img id="postcard_front_img"  src="~/../images/Postcard_Front_Image_Holder.png" alt="your image" />
													    <button id="front_img_btn" class="btn btn-rounded btn-primary" >UPLOAD FRONT ART</button>
										    			<p>* 1875 x 1275 pixels</p>
			  						                  	<input type='file'  id="postcard_front_img_input" style="display: none;" />
													 </div>
													 <div class="back_image_con postcard_img_con">
													    <img id="postcard_back_img" src="~/../images/Postcard_Back Image_Holder.png" alt="your image" />
													    <button id="back_img_btn" class="btn btn-rounded btn-primary" >UPLOAD BACK ART</button>
										   				<p>* 1875 x 390 pixels</p>
			  											<input type='file'  id="postcard_back_img_input" style="display:none;" />
													 </div>
													 
													 <label for="message_for_handWrittent_note">MESSAGE</label>
												     <textarea class="form-control" rows="8" id="message_for_postcard"></textarea>
				                      	  			 <div style="float: left;margin-top: 20px">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_full_name" placeholder="TO : FULL NAME">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_full_name" placeholder="FROM : FULL NAME">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_company" placeholder="TO : COMPANY">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_company" placeholder="FROM : COMPANY">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_line1" placeholder="TO : LINE 1">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_line1" placeholder="FROM : LINE 1">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_line2" placeholder="TO : LINE 2">
				                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_line2" placeholder="FROM : LINE 2">
													 </div>
													 
												</div>
												
											</div> 
									   </form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
								<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
								<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					</div>
				    
				    
					<div id="gifting" class="modal">
					   	<div class="modal-dialog" >
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<h4 class="modal-title"><img class="gmailimg" src="~/../images/gift.svg"> Gifting</h4>
								</div>
								<div class="modal-body">
									<div class="work-creation-wizard-step" id="work-creation-wizard-step-work-pane-gifting" data-step="work-pane-gifting" style="display: block;">
										  <form class="form work-form">
												<div class="row ">
													<div class="form-group col-sm-12">
													    <div style="width: 40%; margin-bottom: 15px;float:left;">
														    <label for="message_for_gifting">GIFT CARD</label> 
														    <select id="gift_card" class="form-control">
						                     	     			   <option value="print" >PRINT</option>
						                      	  			 </select>
					                      	  			</div> 
					                      	  			<div style="width: 40%; margin-bottom: 15px;margin-left:20%;float:left;">
														    <label for="ammount_for_gifting">AMOUNT</label> 
														    <input type="text" class="form-control" id="ammount_for_gifting" placeholder="$">
					                      	  			</div> 
													     
													
														 <label for="message_for_gifting">MESSAGE</label>
													     <textarea class="form-control" rows="8" id="message_for_gifting"></textarea>
														 <select id="script_for_gifting" class="form-control select_form_35">
					                     	     			   <option value="PRINT" >PRINT</option>
					                      	  			 </select>
					                      	  			 <select id="ink_color_for_gifting" class="form-control select_form_35" style="margin-left:20px;">
					                      	     			   <option value="BLACK" >BLACK</option>
					                      	  			 </select>
					                      	  			 <div style="float: left;margin-top: 20px">
					                      	  			 	<label for="envelop_for_gifting" style="float: left;width: 100%;">ENVELOP :</label>
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_full_name" placeholder="TO : FULL NAME">
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_full_name" placeholder="FROM : FULL NAME">
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_company" placeholder="TO : COMPANY">
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_company" placeholder="FROM : COMPANY">
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_line1" placeholder="TO : LINE 1">
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_line1" placeholder="FROM : LINE 1">
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40" id="to_line2" placeholder="TO : LINE 2">
					                      	  			 	<input type="text" class="form-control col-sm-4 form_40 mar_left_20" id="from_line2" placeholder="FROM : LINE 2">
														 </div>
														 <div style="float: left;margin-top: 20px">
					                      	  			 	<label for="envelop_for_handWrittent_note" style="float: left;width: 100%;">ENVELOPE / INK COLOR </label>
					                      	  			 	<select id="envelop_ink_color_for_gifting" class="form-control">
					                      	     			   <option value="WHITE w BLACK INK" >WHITE w BLACK INK</option>
					                      	  			    </select>
														 </div>
														 <div class="gift_image_con postcard_img_con">
														      <label style="float: left;width: 100%;margin-bottom:0;">IMAGE FOR GIFT: </label>
													  		  <img id="gifting_img" src="~/../images/profile-blank.png" alt="your image" />
													    	  <button id="gifting_img_btn" >UPLOAD Image</button>
															  <input type='file'  id="gifting_img_input" style="display:none;" />
														 </div>
													</div>
													
												</div> 
										   </form>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
									<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
									<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
						</div>
					
				    <div id="linkedin" class="modal">
				   	<div class="modal-dialog" >
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">×</button>
								<h4 class="modal-title"><img class="gmailimg" src="~/../images/linkedin.svg"> LinkedIn</h4>
							</div>
							<div class="modal-body">
								<div class="work-creation-wizard-step" id="work-creation-wizard-step-work-linkedin" data-step="work-pane-linkedin" style="display: block;">
									  <form class="form work-form">
											<div class="row ">
												<div class="form-group col-sm-12">
												    <div style="width: 40%; margin-bottom: 15px;float:left;">
													    <label for="connect_or_inmail_linkedin">CONNECT OR INMAIL ?</label> 
													    <select id="connect_or_inmail_linkedin" class="form-control">
					                     	     			   <option value="CONNECT" >CONNECT</option>
					                     	     			   <option value="INMAIL" >INMAIL</option>
					                      	  			 </select>
				                      	  			</div> 
												</div>
												<div class="form-group col-sm-12">
												    <input type="text" class="form-control" style="display:none;margin-bottom: 15px;" id="linkedin_inmail_subject" placeholder="INMAIL SUBJECT">
													<label for="message_for_linkedin">MESSAGE</label>
												    <textarea class="form-control" rows="8" id="message_for_linkedin"></textarea>
												</div>
											</div> 
									   </form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
								<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
								<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					</div>
					
					<div id="work-pane-tips" class="modal">
				     <div class="modal-dialog">
				    
				    <div class="modal-content">
				        <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" >×</button>
							<h4 class="modal-title mheaderTitle"><img class="gmailimg" src="~/../images/tips.svg"> Tips</h4> 
				        </div>
				        <div class="modal-body">
						   <div class="work-creation-wizard-step" id="work-creation-wizard-step-work-pane-tips" data-step="work-pane-tips" >
								<form class="form work-form form-horizontal">
								
									<div class="form-group">
										<div class="col-md-12">
											<div class="btn-toolbar" id="editor-toolbar-3" data-target="#editor-toolbar-for-tips">
												<div class="btn-group" >
												 	<a class="btn btn-xs" data-wysihtml5-command="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
											    	<a class="btn btn-xs" data-wysihtml5-command="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a> 
												    <a class="btn btn-xs" data-wysihtml5-command="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
												    <a class="btn btn-xs" data-wysihtml5-command="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a> 
												    
												 </div>
												<div class="btn-group dropdown token-dropdown"> <a class="btn dropdown-toggle btn-xs" title="Insert Token" data-toggle="dropdown">{-}</a>
													<ul class="dropdown-menu" role="menu">
														<li role="presentation"><a data-token="MySignature" href="#MySignature">My Signature</a></li>
														<li role="presentation"><a data-token="MyFirstName" href="#MyFirstName">My First Name</a></li>
														<li role="presentation"><a data-token="MyLastName" href="#MyLastName">My Last Name</a></li>
														<li role="presentation"><a data-token="FirstName" href="#FirstName">First Name</a></li>
														<li role="presentation"><a data-token="LastName" href="#LastName">Last Name</a></li>
														<li role="presentation"><a data-token="FullName" href="#FullName">Full Name</a></li>
														<li role="presentation"><a data-token="CompanyName" href="#CompanyName">Company Name</a></li>
														<li role="presentation"><a data-token="JobTitle" href="#JobTitle">Job Title</a></li>
														<li role="presentation"><a data-token="StreetAddress" href="#StreetAddress">Street Address</a></li>
														<li role="presentation"><a data-token="City" href="#City">City</a></li>
														<li role="presentation"><a data-token="State" href="#State">State</a></li>
														<li role="presentation"><a data-token="ZipCode" href="#ZipCode">Zip Code</a></li>
													</ul>
												</div>
											</div>
											<textarea id="editor-toolbar-for-tips" placeholder="Enter your text ..." autofocus></textarea>
										</div>
									</div>
								</form>
							</div>
						</div>
				        <div class="modal-footer">
							<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
				            <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
				        </div>
				    </div>
				</div>
				</div>
					
					<div id="work-pane-email-send" class="modal">
				     <div class="modal-dialog">
				    
				    <div class="modal-content">
				        <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" >×</button>
							<h4 class="modal-title mheaderTitle"><img class="gmailimg" src="~/../images/gmail-icon.png"> Send Email</h4> 
				        </div>
				        <div class="modal-body">
						   <div class="work-creation-wizard-step" id="work-creation-wizard-step-work-pane-email-send" data-step="work-pane-email-send" >
								<form class="form work-form form-horizontal">
									
									<div class="form-group">
										<label class="control-label col-md-2 text-right">Subject: </label>
										<div class="col-md-10">
								        	<span class="form-control" id="email-sub-spn" style="padding:0px;">
								        	    <input type="text" class="form-control email-title can-have-token email-sub" title="Subject" name="title"/>  
								        	</span>   				
									    </div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="btn-toolbar" id="editor-toolbar" data-target="#editor">
												<div class="btn-group" >
												 	<a class="btn btn-xs" data-wysihtml5-command="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
												 	<a class="btn btn-xs" data-wysihtml5-command="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a> 
												 	<a class="btn btn-xs" data-wysihtml5-command="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
											    	<a class="btn btn-xs" data-wysihtml5-command="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a> 
												    <a class="btn btn-xs" data-wysihtml5-command="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
												    <a class="btn btn-xs" data-wysihtml5-command="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a> 
												    
												 </div>
												<div class="btn-group dropdown token-dropdown"> <a class="btn dropdown-toggle btn-xs" title="Insert Token" data-toggle="dropdown">{-}</a>
													<ul class="dropdown-menu" role="menu">
														<li role="presentation"><a data-token="MySignature" href="#MySignature">My Signature</a></li>
														<li role="presentation"><a data-token="MyFirstName" href="#MyFirstName">My First Name</a></li>
														<li role="presentation"><a data-token="MyLastName" href="#MyLastName">My Last Name</a></li>
														<li role="presentation"><a data-token="FirstName" href="#FirstName">First Name</a></li>
														<li role="presentation"><a data-token="LastName" href="#LastName">Last Name</a></li>
														<li role="presentation"><a data-token="FullName" href="#FullName">Full Name</a></li>
														<li role="presentation"><a data-token="CompanyName" href="#CompanyName">Company Name</a></li>
														<li role="presentation"><a data-token="JobTitle" href="#JobTitle">Job Title</a></li>
														<li role="presentation"><a data-token="StreetAddress" href="#StreetAddress">Street Address</a></li>
														<li role="presentation"><a data-token="City" href="#City">City</a></li>
														<li role="presentation"><a data-token="State" href="#State">State</a></li>
														<li role="presentation"><a data-token="ZipCode" href="#ZipCode">Zip Code</a></li>
													</ul>
												</div>
											</div>
											<textarea id="editor" placeholder="Enter your text ..." autofocus></textarea>
										</div>
									</div>
								</form>
							</div>
						</div>
				        <div class="modal-footer">
				            <button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
							<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
				            <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
				        </div>
				    </div>
				</div>
				</div>
					
				    <div id="work-pane-email-video" class="modal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<h4 class="modal-title mheaderTitle"><i
										class="fa fa-video-camera"></i> Video Message</h4>
							</div>
								<div class="modal-body">
									<div class="work-creation-wizard-step"
									id="work-creation-wizard-step-work-pane-email-video"
									data-step="work-pane-email-video">
										<form class="form work-form form-horizontal">
											<ul class="nav nav-tabs">
												<li class="active"><a data-toggle="tab"
													href="#work-creation-wizard-step-work-pane-emailVideo-tab-pane-video"
													aria-expanded="false">Video</a></li>
												<li class=""><a data-toggle="tab"
													href="#work-creation-wizard-step-work-pane-emailVideo-tab-pane-Message"
													aria-expanded="true">Message</a></li>
											</ul>
											<div class="tab-content" style="margin-top: 3%;">
												<div
												id="work-creation-wizard-step-work-pane-emailVideo-tab-pane-video"
												class="tab-pane fade active in">
													<div class="form-group">
														<div class="col-md-12">
															<div class="video-recorder-wrapper">
			    												<video id="video_email_video" autoplay style="width: 310px;height: 230px;"></video>    
															    <div>
															    	<button id="video_start" class="btn btn-rounded btn-primary" >Start</button>
															    	<button id="video_stop" class="btn btn-rounded btn-danger">Stop</button>
															    	<!-- <button class="btn btn-rounded btn-success">Play</button> -->
															    	<button id="video_restart" class="btn btn-rounded btn-warning">Rerecord</button>
															    </div>
															    <div class="Upload_video">
															        <h3>OR</h3> 
															        <h5>UPLOAD VIDEO</h5>
															         <form id="video_upload_form">
															         	<input abc style="margin-left:42%;"type="file" id="video_emil_file" accept="video/mp4,video/x-m4v,video/*" value="">
															         </form>	
															    </div>
															    <input type="hidden" id="modalvideo" name="video" value="">
																<input type="hidden" id="modalthumb" name="thumb" value="">
																<input type="hidden" id="modaltoken_value" name="token_value" value=""> <input type="hidden" id="meta_token" name="meta_token_value" value="">
															</div>
													</div>
												</div>
											</div>
												<div id="work-creation-wizard-step-work-pane-emailVideo-tab-pane-Message" class="tab-pane fade">
													<div class="form-group"><label
														class="control-label col-md-2 text-right">Subject: </label>
														<div class="col-md-10">
														   <span class="form-control"id="email-sub-spn" style="padding: 0px;"> 
														      <input type="text" class="form-control email-title email-sub can-have-token" title="Subject" name="title">
															</span>
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-12">
															<div class="btn-toolbar" id="editor-toolbar-2" data-target="#editor-for-video-Email">
																<div class="btn-group"><a class="btn btn-xs" data-wysihtml5-command="bold" title="Bold (Ctrl/Cmd+B)">
																   <i class="fa fa-bold"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="italic" title="Italic (Ctrl/Cmd+I)"><i
																		class="fa fa-italic"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="strikethrough"
																	title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
																	<a class="btn btn-xs" data-wysihtml5-command="underline"
																	title="Underline (Ctrl/Cmd+U)"><i
																		class="fa fa-underline"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="insertunorderedlist"
																	title="Bullet list"><i class="fa fa-list-ul"></i></a> <a
																	class="btn btn-xs"
																	data-wysihtml5-command="insertorderedlist"
																	title="Number list"><i class="fa fa-list-ol"></i></a> <a
																	class="btn btn-xs" data-wysihtml5-command="justifyleft"
																	title="Align Left (Ctrl/Cmd+L)"><i
																		class="fa fa-align-left"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="justifycenter"
																	title="Center (Ctrl/Cmd+E)"><i
																		class="fa fa-align-center"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="justifyright"
																	title="Align Right (Ctrl/Cmd+R)"><i
																		class="fa fa-align-right"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="justifyfull"
																	title="Justify (Ctrl/Cmd+J)"><i
																		class="fa fa-align-justify"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="undo" title="Undo (Ctrl/Cmd+Z)"><i
																		class="fa fa-undo"></i></a> <a class="btn btn-xs"
																	data-wysihtml5-command="redo" title="Redo (Ctrl/Cmd+Y)"><i
																		class="fa fa-repeat"></i></a></div>
																<div class="btn-group dropdown token-dropdown"><a
																	class="btn dropdown-toggle btn-xs" title="Insert Token"
																	data-toggle="dropdown">{-}</a>
																	<ul class="dropdown-menu" role="menu">
																		<li role="presentation"><a data-token="MySignature"
																			href="#MySignature">My Signature</a></li>
																		<li role="presentation"><a data-token="MyFirstName"
																			href="#MyFirstName">My First Name</a></li>
																		<li role="presentation"><a data-token="MyLastName"
																			href="#MyLastName">My Last Name</a></li>
																		<li role="presentation"><a data-token="FirstName"
																			href="#FirstName">First Name</a></li>
																		<li role="presentation"><a data-token="LastName"
																			href="#LastName">Last Name</a></li>
																		<li role="presentation"><a data-token="FullName"
																			href="#FullName">Full Name</a></li>
																		<li role="presentation"><a data-token="CompanyName"
																			href="#CompanyName">Company Name</a></li>
																		<li role="presentation"><a data-token="JobTitle"
																			href="#JobTitle">Job Title</a></li>
																		<li role="presentation"><a data-token="StreetAddress"
																			href="#StreetAddress">Street Address</a></li>
																		<li role="presentation"><a data-token="City"
																			href="#City">City</a></li>
																		<li role="presentation"><a data-token="State"
																			href="#State">State</a></li>
																		<li role="presentation"><a data-token="ZipCode"
																			href="#ZipCode">Zip Code</a></li>
																	</ul></div>
														</div> <textarea id="editor-for-video-Email"
															placeholder="Enter your text ..." autofocus></textarea>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						    <div class="modal-footer">
						        <button type="button" class="btn btn-rounded btn-primary btn-add"><i class="fa fa-save"></i> Add</button>
								<button type="button" class="btn btn-rounded btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
								<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				    </div>
			 	<!-- end of modal area -->
			 	  
				
					
				</body>
			</html>
			
						
						
					<?php  }
						
		
		}
	}

	$stmt->close();
	$conn->close();
	

?>