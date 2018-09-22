<?php
  
  include('dbconnect.php');
  
  include_once('logger.php');
  $TAG = basename(__FILE__, '.php'); 
  LogMessage($TAG, "GCM Registration Started");

  $collegeId = $_GET["college_id"];
  $registrationToken=$_GET["token"];

  LogMessage($TAG, "College Id -> ".$collegeId);
  LogMessage($TAG, "Registration Token -> ".$registrationToken);

  $sql = "DELETE FROM GCM WHERE CollegeId='$collegeId'";  
  
  mysqli_query($con, $sql);
  
  $sql = "INSERT INTO GCM(CollegeId,Token) VALUES('$collegeId','$registrationToken')";

  if(mysqli_query($con,$sql)==TRUE){
    echo "success";
  }else{
    echo "failure";
  }

  mysqli_close($con);
  LogMessage($TAG, "GCM Registration Ended");
?>