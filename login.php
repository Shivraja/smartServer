<?php
  session_start();
  if(isset($_SESSION['college_id'])){
    header("Location:./");
    exit();
  }
?>
<html>
<head>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family: 'Times New Roman', Times, serif;">
		<br><br>
		<center>
		ADMIN LOGIN OF "SmartClass App" <br><br><br>
		<form method="POST" action="http://pradeepthangamuthu.in/SNACS/admin_login.php">
			<input type="text" class="form-control" style="width: 300px;" name="college_id" placeholder="CollegeID"><br><br>	
			<input type="password" class="form-control" name="password" style="width: 300px;" placeholder="Password"><br><br>
			<button class="btn btn-primary" type="submit">Submit</button>
		</form>
		</center>

</body>
</html>