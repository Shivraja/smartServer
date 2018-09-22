<?php
	session_start();
	if(!isset($_SESSION['college_id'])){
		header("Location:./");
		exit();
	}else{
?>
	<html>
		<head>
			<link href="css/bootstrap.min.css" rel="stylesheet">
			<title>Home</title>
		</head>
		<body>
			<center>	
				<br><br><center><h3><b>Teacher's Control Panel</b></h3></center>
				<br><br><br>
 				<a href="./add_user.php?from=WEB"><button style="width: 250px;" class="btn btn-primary">Add User</button></a><br><br>
 				<a href="./add_course.php?from=WEB"><button style="width: 250px;" class="btn btn-primary">Add Course</button></a><br><br>
 				<a href="./add_test.php?from=WEB"><button style="width: 250px;" class="btn btn-primary">Conduct Test</button></a><br><br>
 				<a href="show_report.php"><button style="width: 250px;" class="btn btn-primary">Show Report</button></a><br><br>
                                <a href="show_test_report.php"><button style="width: 250px;" class="btn btn-primary">Show Test Report</button></a><br><br>
				<a href="logout.php"><button style="width: 250px;" class="btn btn-danger">Logout</button></a>
			</center>
		</body>
	</html>
<?php
	}
?>