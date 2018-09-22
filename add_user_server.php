<?php
	session_start();

	include('dbconnect.php');
	include('send_to_gcm.php');
	include_once('logger.php');
	$TAG = basename(__FILE__, '.php'); 
	LogMessage($TAG, "Reached Add User Server");

	$staffId = $_SESSION['college_id'];

	if($_SESSION['from']=="APP"){
		$subjectId = $_SESSION['subject_id'];
	}else{
		$subjectId = $_REQUEST['subject_id'];
	}

	$studentId = $_REQUEST['student_id'];
	
	$query = "INSERT INTO enrollment(TeacherId, SubjectId, StudentId) VALUES('$staffId','$subjectId','$studentId');";
	mysqli_query($con, $query);

	notify_teacher();
	notify_student();

	if($_SESSION['from']=="APP"){
		echo "<br>Completed Successfully<br>";
		exit();
	}else{
		header("Location:./");
		exit();
	}
	
	function notify_teacher(){
		GLOBAL $studentId, $subjectId, $staffId, $con;
		$studentName = getStudentName();
		if($studentName=='FAILURE')
			return;
		$data = array('mode'=>'TEACHER','title'=>'ADD_USER','staff_id' => $staffId, 'student_id' => $studentId,'student_name'=>$studentName, 'subject_id' => $subjectId);
		$query = "SELECT * FROM GCM WHERE CollegeId='$staffId'";
		LogMessage($TAG, "Query --> ".$query);
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$row = mysqli_fetch_assoc($results);
			$tokens = array($row['Token']);
			send_to_gcm($data, $tokens);
		}
	}

	function notify_student(){
		GLOBAL $studentId, $subjectId, $staffId, $con;
		$data = array('mode'=>'STUDENT','title'=>'ADD_SUBJECT','teacher_id' => $staffId, 'subject_id' => $subjectId);
		$query = "SELECT * FROM GCM WHERE CollegeId='$studentId'";
		LogMessage($TAG, "Query --> ".$query);
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$row = mysqli_fetch_assoc($results);
			$tokens = array($row['Token']);
			send_to_gcm($data, $tokens);
		}	
	}

	function getStudentName(){
		GLOBAL $studentId, $con;
		$query = "SELECT * FROM user WHERE CollegeId='$studentId' AND Designation='STUDENT'";
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$row = mysqli_fetch_assoc($results);
			return $row['Name'];
		}	
		return "FAILURE";
	}
	LogMessage($TAG, "Ended Add User Server");
?>