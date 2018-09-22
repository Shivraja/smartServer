<?php
	include('dbconnect.php');

	$name = urldecode($_REQUEST['name']);
	$collegeId = urldecode($_REQUEST['college_id']);
	$emailId = urldecode($_REQUEST['email_id']);
	$password = urldecode($_REQUEST['password']);
	$designation = urldecode($_REQUEST['designation']);

	$collegeId = preg_replace("/[^a-zA-Z0-9_@]/", "", $collegeId);
	$password = preg_replace("/[^a-zA-Z0-9_@]/", "", $password);

	$query = "SELECT * FROM user WHERE CollegeId='$collegeId'";

	$result = mysqli_query($con, $query);

	if(mysqli_num_rows($result)>=1){
		echo "EXISTS";
		exit();
	}
	
	$query = "INSERT INTO user(Name, CollegeId, Password, EmailId, Designation) VALUES('$name','$collegeId','$password', '$emailId', '$designation');";
	$result = mysqli_query($con, $query);

	if($result){
		echo "$designation"; 
	}else{
		echo "FAILURE";
	}

	mysqli_close($con);
?>