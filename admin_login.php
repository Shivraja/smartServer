<?php 
  session_start();
	include('dbconnect.php');

  $college_id = $_REQUEST['college_id'];
  $password = $_REQUEST['password'];

  //echo "$college_id"."  "."$password\n";

	$college_id = preg_replace("/[^a-zA-Z0-9_@]/", "", $college_id);
	$password = preg_replace("/[^a-zA-Z0-9_@]/", "", $password);

  //echo "$college_id"."  "."$password\n";

	$query = "SELECT * FROM user WHERE CollegeId='$college_id' AND Password='$password' AND Designation='TEACHER';";

  //echo "$query\n";	
  $result = mysqli_query($con, $query);

  $rows = mysqli_num_rows($result);

//  echo "$rows\n";

	if($rows>=1){
      echo "<br>success<br>";
  		$row = mysqli_fetch_assoc($result);
      $_SESSION['college_id']=$college_id;
      echo'<script>window.location.href="./home.php";</script>';
 	}else
   		echo "FAILURE";
?>