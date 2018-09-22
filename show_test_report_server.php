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

	show_test_report();
    
    function show_test_report()
    {
        GLOBAL $con, $fromDate, $toDate;
	    echo "<h3>Test Report</h3>";
        
        $query = "SELECT * FROM test_report WHERE Date >= '$fromDate' and Date <= '$toDate' ORDER BY StudentId, TestName, Date";
	$results = mysqli_query($con, $query);
        
     	if(mysqli_num_rows($results)>=1){
     		?>
			<table  border="1">
	  			<thead>
	    			<tr>
				      <th>Student ID</th>
				      <th>Subject ID</th>
				      <th>Test Name</th>
	  			      <th>Score</th>
				      <th>Date</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  		while ($row = mysqli_fetch_assoc($results)) {
				  			echo "<tr><td>{$row['StudentId']}</td><td>{$row['SubjectId']}</td><td>{$row['TestName']}</td><td>{$row['Score']}</td><td>{$row['Date']}</td></tr>\n";
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

?>	  
				
