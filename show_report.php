<?php
   @session_start();
   if(!isset($_SESSION['college_id'])){
     header("Location:./");
     exit();
   }
?>
<html>
<head>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family: 'Times New Roman', Times, serif;">
		<center>
			<br><br><h4><b>Report Page</b></h4> <br><br>
		<form method="GET" action="show_report_server.php">
			From Date : <input type="date" class="form-control" style="width: 300px; display:inline;" name="from_date"><br><br>	
			To Date &nbsp;&nbsp;&nbsp;&nbsp;: <input type="date" class="form-control" style="width: 300px; display:inline;" name="to_date"><br><br>
			<button class="btn btn-primary" type="submit">Submit</button>
		</form>
		</center>
</body>
</html>
