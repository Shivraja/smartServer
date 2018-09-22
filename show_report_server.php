<?php
       @session_start();
   if(!isset($_SESSION['college_id'])){
     header("Location:./");
     exit();
   }

	include('dbconnect.php');
	$fromDate = $_REQUEST['from_date'];
	$toDate = $_REQUEST['to_date'];
	$fromDateMilli = strtotime($fromDate) * 1000;
	$toDateMilli = strtotime($toDate) * 1000;

	show_user_registration();
	show_user_enrollment();
	show_assignment_history();
	show_test_history();
    
    function show_user_registration()
    {
        GLOBAL $con, $fromDate, $toDate;
	    echo "<h3>User Registration</h3>";
        
        $query = "SELECT * FROM user WHERE Date >= '$fromDate' and Date <= '$toDate'";
		$results = mysqli_query($con, $query);
        
		if(mysqli_num_rows($results)>=1){
			?>
			<table border="1">
	  			<thead>
	    			<tr>
				      <th>Name</th>
				      <th>College ID</th>
				      <th>Email ID</th>
	  			      <th>Designation</th>
				      <th>Date</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  		while ($row = mysqli_fetch_assoc($results)) {
				  			echo "<tr><td>{$row['Name']}</td><td>{$row['CollegeId']}</td><td>{$row['EmailId']}</td><td>{$row['Designation']}</td><td>{$row['Date']}</td></tr>\n";
				  		}
				  	?>
				  </tbody>
			</table>
			<?php
		}
                else{
                    echo "No Data Found<br>";
                }
    }

    function show_user_enrollment()
    {
        GLOBAL $con, $fromDate, $toDate;
	    echo "<h3>User Enrollment</h3>";
        
        $query = "SELECT * FROM enrollment WHERE Date >= '$fromDate' and Date <= '$toDate' ORDER BY TeacherId";
		$results = mysqli_query($con, $query);
        
        if(mysqli_num_rows($results)>=1){
        	?>
			<table border="1">
	  			<thead>
	    			<tr>
				      <th>Teacher ID</th>
				      <th>Subject ID</th>
				      <th>Student ID</th>
				      <th>Date</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  		while ($row = mysqli_fetch_assoc($results)) {
				  			echo "<tr><td>{$row['TeacherId']}</td><td>{$row['SubjectId']}</td><td>{$row['StudentId']}</td><td>{$row['Date']}</td></tr>\n";
				  		}
				  	?>
				  </tbody>
			</table>
			<?php
		}
                else{
                    echo "No Data Found<br>";
                }

    }

    function show_assignment_history()
    {
        GLOBAL $con, $fromDate, $toDate;
	    echo "<h3>Assignment History</h3>";
        
        $query = "SELECT * FROM history WHERE Date >= '$fromDate' and Date <= '$toDate' ORDER BY Actor, CollegeId, Date";
		$results = mysqli_query($con, $query);
        
     	if(mysqli_num_rows($results)>=1){
     		?>
			<table  border="1">
	  			<thead>
	    			<tr>
				      <th>Actor</th>
				      <th>College ID</th>
				      <th>Action</th>
	  			      <th>Description</th>
				      <th>Date</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  		while ($row = mysqli_fetch_assoc($results)) {
				  			echo "<tr><td>{$row['Actor']}</td><td>{$row['CollegeId']}</td><td>{$row['Action']}</td><td>{$row['Description']}</td><td>{$row['Date']}</td></tr>\n";
				  		}
				  	?>
				  </tbody>
			</table>
			<?php
		}
                else{
                    echo "No Data Found<br>";
                }
    }

    function show_test_history()
    {
        GLOBAL $con, $fromDate, $toDate;
	    echo "<h3>Test History</h3>";
        
        $query = "SELECT * FROM Test WHERE Date >= '$fromDate' and Date <= '$toDate'";
		$results = mysqli_query($con, $query);
        
        if(mysqli_num_rows($results)>=1){
	  		while ($row = mysqli_fetch_assoc($results)) {
	  			echo "<pre>Staff Id      : {$row['StaffId']}<br>Subject Id    : {$row['SubjectId']}<br>Assignment Id : {$row['AssignmentId']}<br>Date          : {$row['Date']}<br>Question      : {$row['Question']}<br>{$row['Option1']}<br>{$row['Option2']}<br>{$row['Option3']}<br>{$row['Option4']}<br>Answer : {$row['Answer']}<br></pre>
	  			      \n";
	  		}
				  	
	}
        else{
            echo "No Data Found<br>";
        }
    }
?>	  
				