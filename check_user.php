<?php 
	include('dbconnect.php');
  include_once('logger.php');

  $TAG = basename(__FILE__, '.php'); 
  $college_id = $_REQUEST['college_id'];
  $password = $_REQUEST['password'];
  
  LogMessage($college_id, $password);

	$college_id = preg_replace("/[^a-zA-Z0-9_@]/", "", $college_id);
	$password = preg_replace("/[^a-zA-Z0-9_@]/", "", $password);

	$query = "SELECT * FROM user WHERE CollegeId='".$college_id."' AND Password='".$password."';";
	
	$result = mysqli_query($con, $query);

    $rows = mysqli_num_rows($result);

  	if($rows>=1){
  		$row = mysqli_fetch_assoc($result);
      LogMessage($TAG,$row['Designation']);
  		echo $row['Designation'];
   	}else{
      LogMessage($TAG,'INVALID');
   		echo "INVALID";
      }
?>