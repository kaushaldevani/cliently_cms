<?php 

    require dirname(__FILE__).'/vendor/autoload.php';
	require dirname(__FILE__).'/config/dbconfig.php';

	$dbclass  = new dbConnection();
	$conn = $dbclass-> db_connect();
	
	$result = mysqli_query($conn,"SELECT * FROM page");
	$ind_list = mysqli_query($conn,"SELECT * FROM industries");
	
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();
	$wp_url = $_SERVER['WORDPRESS_URL'];
    $wp_url_comp = parse_url($wp_url);
	$wordpress_url = $wp_url_comp['scheme'].'://'.$wp_url_comp['host'].'/?';
	
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
  		<title>clienty cms home</title>
  		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  		
  		<link rel="stylesheet" href="css/home.css" >
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  		<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  		<?php 
  		  
  			echo "<script type=\"text/javascript\">
  					$(document).ready(function() {
    		               
    		                var industry_text = '';
							$(\"#page_list\").DataTable();
    		
    		                $(\".update_ind_btn\").click(function(){
    		                     $(\"#page_list_2\").DataTable();
						         $('#myModal').modal('show');
						    });
    		 
    		                 $(\".modal-footer\").on('click','.add_ind',function(){
                               
    		                    var row = $('<tr></tr>');
    		                    var ind_td = $('<td class=\'industry\'></td>');
                                $(ind_td).append($('<input type=\'text\'></input>'));
    		                    
    		                    var ind_td_2 = $('<td class=\'ind_link\'></td>');    
    		
    		                    var save_link = $('<a  href=\'#\' class=\'save_ind\'>Save |</a> ');
    							var cancel_link = $('<a href=\'#\' class=\'cancel_ind\'> Cancel</a>');
    		                    $(ind_td_2).append(save_link,cancel_link);
    		
    		                    $(row).append(ind_td,ind_td_2);
    		                    $('#page_list_2 > tbody').prepend(row);
                            });
    		
    		                 $(\"#page_list_2 > tbody\").on('click','.ind_link > .edit_ind',function(){

    		 					 var data_id = $(this).attr('data_id');
    		                     var row =$(this).closest('tr');
    		                     $(row).parent().find('tr').not(row).addClass('disabled'	);
    		                     var thisPosition = $(row).find('.industry');
    		                     var thisPositionText = $(thisPosition).text();
    							 industry_text=thisPositionText;
    		                     thisPosition.empty().append($('<input type=\'text\'></input>'));
                                 $(row).find('.industry > input').val(thisPositionText);
    		                     var save_link = $('<a  href=\'#\' class=\'save_ind\' data_id='+ data_id +'>Save |</a> ');
    							 var cancel_link = $('<a href=\'#\' class=\'cancel_ind\' data_id='+ data_id +'> Cancel</a>');
    		                     $(row).find('.ind_link').empty().append(save_link,cancel_link);  
    		
						    });
    		                $(\"#page_list_2 > tbody\").on('click','.ind_link > .cancel_ind',function(){
    		
    		                    
    		                     var data_id = $(this).attr('data_id');
    		                     var row =$(this).closest('tr');
    							 $(row).parent().find('tr').removeClass('disabled');
    		                     if(data_id)
    		                     {
	    		                     var thisPosition = $(row).find('.industry');
	    		                     thisPosition.empty().append(industry_text);
	    		                     var edit_link = $('<a href=\'#\' class=\'edit_ind\' data_id='+ data_id +'>Edit |</a> ');
	    							 var delete_link = $('<a href=\'#\' class=\'delete_ind\' data_id='+ data_id +'> Delete</a>');
	    		                     $(row).find('.ind_link').empty().append(edit_link,delete_link);
								 }
    		                     else
    		                     {
 	                               $(this).closest('tr').remove();
								 }
    		                       
    		                });
    		                $(\"#page_list_2 > tbody\").on('click','.ind_link > .save_ind',function(){
    		                       
    		                      var data_id = $(this).attr('data_id');
    		                      var row =$(this).closest('tr');
    							  $(row).parent().find('tr').removeClass('disabled');
    		                      var thisPosition = $(row).find('.industry');
    							  var old_value = industry_text;
    						      industry_text = $(thisPosition).find('input').val();
   		                          var data  = new Object();
    							  data.req_type = 'Update';
    		                      if(data_id)
    		                      {
    		                          data.ind_id = data_id;
    		                          data.old_value = old_value;
    		                          data.new_value = industry_text; 
    		                      }
    		                      else 
    		                      {
    		                          data.new_value = industry_text; 
                                  }
    		
    							  $.ajax({
										        url: 'api/industry.php',
										        type: 'post',
    		                                    data:JSON.stringify(data),
										        success: function (response) {
										              var jsonResponse = JSON.parse(response);
    		                                         if(jsonResponse.status == 200)
    		                                         {
	    		                                          thisPosition.empty().append(industry_text);
		    		                                      var edit_link = $('<a href=\'#\' class=\'edit_ind\' data_id='+ data_id +'>Edit |</a> ');
		    							                  var delete_link = $('<a href=\'#\' class=\'delete_ind\' data_id='+ data_id +'> Delete</a>');
		    		                      				  $(row).find('.ind_link').empty().append(edit_link,delete_link);			
													 }
    		                                         else
    		                                         {
 															alert(jsonResponse.data);
                                                     }
    		                                          
										        },
										        error: function(jqXHR, textStatus, errorThrown)
										        {
										          alert(errorThrown);
										        }
   									  });
    		
    		
                            });
    		                $(\"#page_list_2 > tbody\").on('click','.ind_link > .delete_ind',function(){
    		
    		 
    		                      var data_id = $(this).attr('data_id');
    		                      var row =$(this).closest('tr');
    							  $(row).parent().find('tr').removeClass('disabled');
    		                      var thisPosition = $(row).find('.industry');
    						      industry_text = $(thisPosition).text();
   		                          var data  = new Object();
    		                       data.req_type = 'Delete';
    		                      if(data_id)
    		                      {
										data.ind_id = data_id;
    								    data.value = industry_text;
                                  }
    		                       $.ajax({
										        url: 'api/industry.php',
										        type: 'post',
    		                                    data:JSON.stringify(data),
										        success: function (response) {
										              var jsonResponse = JSON.parse(response);
    		                                         if(jsonResponse.status == 200)
    		                                         {
    		                                             $(row).remove(); 
													 }
    		                                         else
    		                                         {
 														lert(jsonResponse.data);
                                                     }
    		                                          
										        },
										        error: function(jqXHR, textStatus, errorThrown)
										        {
										          alert(errorThrown);
										        }
   									  });
    		
                            });
    		
    		                $('#myModal').on('hidden.bs.modal', function () {
        							location.reload();
    						});
                     });
  				</script>";
  		?>
	</head>
	<body>

	<div class="container">
  	   <div class="head_section">	
  	   		<h2>List of Pages</h2>
  	   		<a href="/cliently_cms/logout.php" type="button" style="float:right;" class="btn btn-primary btn-lg" >Logout</a>
  			<a href="/cliently_cms/add.php" type="button" class="add_page_btn btn btn-primary btn-lg" >Add new</a>
  			<a href="#" type="button" class="update_ind_btn btn btn-primary btn-lg" style="margin-left: 20px;" >Update Industry</a>
  	   </div>
  	
  	
  	<table  id="page_list" class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Target 1</th>
        <th>Target 2</th>  
        <th>Industry</th>        
        <th>Written By</th>
        <th>Edit / Delete / View</th>
      </tr>
    </thead>
    <tbody>
	
	<?php 
	
	while($row = mysqli_fetch_array($result))
	{ ?>
		<tr>
		<td><?php  echo $row['id']; ?></td>
		<td><?php  echo $row['Target_1'];?> </td>
		<td><?php  echo $row['Target_2'];?> </td>
		<td><?php  echo $row['Industry'];?> </td>
		<td><?php  echo $row['written_by']; ?> </td>
		<td>
			<a href='/cliently_cms/edit.php?id=<?php echo $row['id'];?>'>Edit</a> | 
		    <a href='/cliently_cms/delete.php?id=<?php echo $row['id'];?>'>Delete</a> |
		    <a href='<?php echo $wordpress_url;?>page_id=<?php echo $row['wordpress_id'];?>&preview=true'>View</a>
		</td>
		</tr>
	<?php
	}
	?>
	
	</tbody>
	</table>
  		
	</div>
	  
	  
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" id="myModalLabel">Industry List</h4>
	            </div>
	            <div class="modal-body">
	               <table  id="page_list_2" class="table table-striped">
    				<thead>
				    	<tr>
					        <th>Industry </th>        
					        <th>Edit / Delete </th>
				     	</tr>
   					</thead>
    				<tbody>
	
						<?php 
						
						while($row = mysqli_fetch_array($ind_list))
						{ ?>
							<tr>
							<td class="industry"><?php  echo $row['Industry'];?> </td>
							<td class="ind_link">
								<a href='#' class='edit_ind' data_id='<?php echo $row['id'];?>'>Edit</a> | 
							    <a href='#' class='delete_ind' data_id='<?php echo $row['id'];?>'>Delete</a>
							</td>
							</tr>
						<?php
						}
						?>
	
					</tbody>
				  </table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-primary add_ind">Add New</button>
	            </div>
	        </div>
	    </div>
	</div> 
	
	
	
	</body>
	</html>
	

	<?php $conn->close();

?>