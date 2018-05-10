<?php 


	require dirname(__FILE__).'/config/dbconfig.php';

	$dbclass  = new dbConnection();
	$conn = $dbclass-> db_connect();
	
	$result = mysqli_query($conn,"SELECT * FROM page");
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
							
							$(\"#page_list\").DataTable();
                   
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
  	   </div>
  	
  	
  	<table  id="page_list" class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Page Name</th>        
        <th>Written By</th>
        <th>Edit / Delete</th>
      </tr>
    </thead>
    <tbody>
	
	<?php 
	
	while($row = mysqli_fetch_array($result))
	{ ?>
		<tr>
		<td><?php  echo $row['id']; ?></td>
		<td><?php  echo $row['page_name'];?> </td>
		<td><?php  echo $row['written_by']; ?> </td>
		<td><a href='/cliently_cms/edit.php?id=<?php echo $row['id'];?>'>Edit</a> | <a href='/cliently_cms/delete.php?id=<?php echo $row['id'];?>'>Delete</a></td>
		</tr>
	<?php
	}
	?>
	
	</tbody>
	</table>
  		
	</div>
	</body>
	</html>
	

	<?php $conn->close();

?>