<?php
	session_start();

	include('dbconnect.php');
	include 'send_to_gcm.php';
	include_once('logger.php');
	$TAG = basename(__FILE__, '.php'); 

	LogMessage($TAG, "Add Course Started");

	$staffId = $_SESSION['college_id'];


	if($_SESSION['from']=="APP"){
		$subjectId = $_SESSION['subject_id'];
	}else{
		$subjectId = $_REQUEST['subject_id'];
	}

	$assignmentId = $staffId.'course'.time();

	$courseName = $_REQUEST['course_name'];
	$description = $_REQUEST['description'];
	$time=time();
	$duration  = $_REQUEST['duration'];
	$type="COURSE";

    $query = "INSERT INTO history(Actor, CollegeId, Action, Description) VALUES ('TEACHER','$staffId','ADD COURSE',' Subject : $subjectId - Course : $courseName , $description , $type , $duration , $time')";
	//echo $query;
    $result = mysqli_query($con, $query);
    //echo $result;
	echo "Teacher Called<br>";
	notify_teacher();
	echo "Student Called<br>";
	notify_students();

	if($_SESSION['from']=="APP"){
		echo "<br>Completed Successfully<br>";
		//exit();
	}else{
		header("Location:./");
		exit();
	}
	
	function notify_teacher(){
		GLOBAL $assignmentId, $subjectId, $courseName, $con, $type, $duration, $time, $staffId;
		$data = array('mode'=>'TEACHER','title'=>'ADD_ASSIGNMENT','assignment_id' => $assignmentId,'subject_id' => $subjectId, 'assignment_name' => $courseName,'type' => $type,'number_of_days' => $duration,'time' => $time);
		$query = "SELECT * FROM GCM WHERE CollegeId='$staffId'";
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$row = mysqli_fetch_assoc($results);
			$tokens = array($row['Token']);
			send_to_gcm($data, $tokens);
		}
	}

	function notify_students(){
		GLOBAL $con, $assignmentId, $courseName, $description, $subjectId, $staffId, $type, $duration, $time;
		$query = "SELECT * FROM GCM WHERE CollegeId IN ( SELECT StudentId FROM enrollment WHERE TeacherId='$staffId' AND SubjectId='$subjectId')";
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$tokens = array();
			while($row = mysqli_fetch_assoc($results)){
				array_push($tokens, $row['Token']);
			}

			//Sending Course First
			$data = array('mode'=>'STUDENT','title'=>'ADD_COURSE','assignment_id' => $assignmentId, 'course_name' => $courseName, 'description' => $description);
			send_to_gcm($data, $tokens);
			
			//Sending the Assignment of that Course
			$data = array('mode'=>'STUDENT','title'=>'ADD_ASSIGNMENT','subject_id' => $subjectId, 'assignment_id' => $assignmentId,'assignment_name' => $courseName,'type' => $type,'number_of_days' => $duration,'time' => $time);
			send_to_gcm($data, $tokens);
		}	
	}

	LogMessage($TAG, "Add Course Ended");
?>			