<?php
  	include('dbconnect.php');
  	include('logger.php');
    $TAG = basename(__FILE__, '.php'); 
  
    $assignmentId = $_REQUEST['assignmentId'];

  	LogMessage($TAG,"Get Questions Started");
		
    $query = "SELECT * FROM Test WHERE AssignmentId='$assignmentId'";
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);
    $questions = array();
    $index=0;
    if($rows > 0 ){
      while($row = mysqli_fetch_assoc($result)){
        $question = array(
            'assignment_id' => $assignmentId,
            'total_questions' => $rows,
            'question_id' => $index++,
            'question' =>$row['Question'],
            'option_1' =>$row['Option1'],
            'option_2' =>$row['Option2'],
            'option_3' =>$row['Option3'],
            'option_4' =>$row['Option4'],
            'answer' =>$row['Answer']
        );
        array_push($questions, $question);
      }
    }
    json_encode($questions);
   	echo json_encode( $questions );
	
    LogMessage($TAG,"Get Questions Ended");
?>