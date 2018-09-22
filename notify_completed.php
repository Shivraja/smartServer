<?php
	include('dbconnect.php');
	include 'send_to_gcm.php';
	include_once('logger.php');
	$TAG = basename(__FILE__, '.php'); 
	LogMessage($TAG, "Reached Notify-Completed");

	$staffId = urldecode($_REQUEST['teacher_id']);
	$studentId = urldecode($_REQUEST['student_id']);
	$assignmentId = urldecode($_REQUEST['assignment_id']);
	$score = urldecode($_REQUEST['score']);

    $assignmentName=$assignmentId;
    $subjectName = $assignmentId;
    $query = "INSERT INTO history(Actor, CollegeId, Action, Description) VALUES ('STUDENT','$studentId','ASSIGNMENT COMPLETED','STAFF : $staffId - Assignment : $assignmentId , $score')";
    $result = mysqli_query($con, $query);

    echo "$query";
    echo "<br/>";

    $query = "SELECT * FROM assignment WHERE AssignmentId='$assignmentId'";
	$results = mysqli_query($con, $query);
	if(mysqli_num_rows($results)>=1){
		$row = mysqli_fetch_assoc($results);
		$assignmentName = $row['AssignmentName'];
	        $subjectName = $row['SubjectId'];
        }

        $query = "INSERT INTO test_report(StudentId, SubjectId, StaffId, TestName, Score) VALUES ('$studentId','$subjectName','$staffId','$assignmentName','$score')";
        $result = mysqli_query($con, $query);

		LogMessage($TAG, "Query --> ".$query);

        echo "$query";
	echo "<br/>";

        notify_teacher();


	function notify_teacher(){
		GLOBAL $staffId, $studentId, $assignmentId, $con, $score;
		$data = array('mode'=>'TEACHER','title'=>'ASSIGNMENT_COMPLETED','student_id'=>$studentId, 'assignment_id' => $assignmentId, 'score'=>$score);
		$query = "SELECT * FROM GCM WHERE CollegeId='$staffId'";
		LogMessage($TAG, "Query --> ".$query);
                echo "$query";
                echo "<br/>";
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$row = mysqli_fetch_assoc($results);
			$tokens = array($row['Token']);
                        var_dump($tokens);
			send_to_gcm($data, $tokens);
		}
	}
	LogMessage($TAG, "Ended Notify-Completed");
	echo "success";

?>							