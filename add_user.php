<?php
	session_start();
	if($_REQUEST['from']=="WEB"){
		if(!isset($_SESSION['college_id'])){
			header("Location:./");
			exit();
		}
		$_SESSION['from']="WEB";
	}else{
		$_SESSION['college_id']=$_REQUEST['college_id'];
		$_SESSION['subject_id']=$_REQUEST['subject_id'];
		$_SESSION['from']="APP";
	}
?>

<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<title>Add User</title>
	</head>
	<body style="font-family: 'Times New Roman', Times, serif;">
		<br><br>
		<center><h3><b>ADD User</b></h3><br><br>
		<form method="POST" action="http://pradeepthangamuthu.in/SNACS/add_user_server.php">
			<?php
				if($_REQUEST['from']=='WEB'){ 
					echo"<input type='text' class='form-control' style='width: 300px;' placeholder='Subject Name (As Given in App)' name='subject_id' required><br>";
				}
			?>
			<input type='text' class='form-control' style="width: 300px;" placeholder='Student Id' name='student_id' required><br>
			<button class="btn btn-primary" type="submit">Submit</button>
		</form>
		</center>
	</body>
</html>