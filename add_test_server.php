<?php
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	session_start();
	
	include('dbconnect.php');
	include 'send_to_gcm.php';

	include_once('logger.php');
	$TAG = basename(__FILE__, '.php'); 
	LogMessage($TAG, "Reached Add Test Server");

	$staffId = $_SESSION['college_id'];

	if($_SESSION['from']=="APP"){
		$subjectId = $_SESSION['subject_id'];
	}else{
		$subjectId = $_REQUEST['subject_id'];
	}

	$questionArray = $_REQUEST['question'];
	$optionArray = $_REQUEST['option'];
	$answerArray = $_REQUEST['answer'];

	$assignmentId = $staffId.'test'.time();
	$totalQuestions = count($questionArray);
	$testName = $_REQUEST['test_name'];
	$type="TEST";
	$duration = $_REQUEST['duration'];
	$time = time();

        $query = "INSERT INTO history(Actor, CollegeId, Action, Description) VALUES ('TEACHER','$staffId','ADD TEST','Subject : $subjectId - Test : $testName , $totalQuestions , $type , $duration , $time')";
	//echo $query;
        $result = mysqli_query($con, $query);
        //echo $result;

        $query = "INSERT INTO assignment(SubjectId, StaffId, AssignmentId, AssignmentName) VALUES ('$subjectId','$staffId','$assignmentId','$testName')";
	//echo $query;
        $result = mysqli_query($con, $query);
        //echo $result;

	$testNameUnmodified = $testName;
	$assignmentIdUnmodified =  $staffId.'test'.time();

	$optionIndex=0;
	$test = array();
	for($index=0; $index<$totalQuestions; $index++){
		$question = array();
		$question['question']=$questionArray[$index];
		$question['options'] = array($optionArray[$optionIndex++],$optionArray[$optionIndex++],$optionArray[$optionIndex++],$optionArray[$optionIndex++]);
		$question['answer'] = $answerArray[$index];
		array_push($test, $question);

                $a = $question['options'][0];
                $b = $question['options'][1];
                $c = $question['options'][2];
                $d = $question['options'][3];
 
                $query = "INSERT INTO Test(StaffId, SubjectId, AssignmentId, Question, Option1, Option2, Option3, Option4, Answer) VALUES ('$staffId','$subjectId','$assignmentIdUnmodified','$question[question]','$a','$b','$c','$d','$question[answer]')";
                echo $query;
                mysqli_query($con, $query);

	}

	$testName = $testNameUnmodified;

        $currentTime = time();
	notify_teacher($currentTime);
	notify_students($currentTime);
        

	if($_SESSION['from']=="APP"){
		echo "<br>Completed Successfully<br>";
		exit();
	}else{
		echo "<br>Completed Successfully<br>";
		header("Location:./");
		exit();
	}
	

	function notify_teacher(){
		GLOBAL $staffId, $subjectId, $assignmentIdUnmodified, $testName, $duration, $time, $con, $type;
	        $assignmentId = $assignmentIdUnmodified;
		$data = array('mode'=>'TEACHER','title'=>'ADD_ASSIGNMENT','assignment_id' => $assignmentId,'subject_id' => $subjectId, 'assignment_name' => $testName,'type' => $type,'number_of_days' => $duration,'time' => $time);
		echo "Teacher<br>";
                echo $assignmentId."  ".$data['assignment_name']."<br>";
                $query = "SELECT * FROM GCM WHERE CollegeId='$staffId'";
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$row = mysqli_fetch_assoc($results);
			$tokens = array($row['Token']);
			send_to_gcm($data, $tokens);
		}
	}

	function notify_students(){
		GLOBAL $staffId, $subjectId, $con, $test, $assignmentIdUnmodified, $totalQuestions, $duration, $time, $testName, $type;

                $assignmentId = $assignmentIdUnmodified;
                $query = "SELECT * FROM GCM WHERE CollegeId IN ( SELECT StudentId FROM enrollment WHERE TeacherId='$staffId' AND SubjectId='$subjectId')";
		$results = mysqli_query($con, $query);
		if(mysqli_num_rows($results)>=1){
			$tokens = array();

			while($row = mysqli_fetch_assoc($results)){
				array_push($tokens, $row['Token']);
			}

			//Sending Questions
			$index=0;
			foreach ($test as $question) {
				$data = array('mode'=>'STUDENT','title'=>'ADD_QUESTION','assignment_id' =>$assignmentId, 'total_questions'=>$totalQuestions,'question_id'=>$index,'question'=>$question['question'],'option_1'=>$question['options'][0],'option_2'=>$question['options'][1],'option_3'=>$question['options'][2],'option_4'=>$question['options'][3],'answer'=>$question['answer']);
				send_to_gcm($data, $tokens);
				$index++;
			}


			sleep(30);
			
			//Sending the Assignment of that Course
			$data = array('mode'=>'STUDENT','title'=>'ADD_ASSIGNMENT','subject_id' => $subjectId, 'assignment_id' => $assignmentId,'assignment_name' => $testName,'type' => $type,'number_of_days' => $duration,'time' => $time);
			echo "Student<br>";
                        echo $assignmentId."  ".$data['assignment_name']."<br>";
                        send_to_gcm($data, $tokens);
		}	
	}
	LogMessage($TAG, "Ended Add Test Server");
?>						