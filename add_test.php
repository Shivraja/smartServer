<?php
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
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
		<script>
			var counter = 2;
			function addAnotherQuestion() {
				var newdiv = document.createElement('div');
          		newdiv.innerHTML = "<br><b>Question #" + (counter) + "<br></b>";
          		newdiv.innerHTML += "<br><textarea type='text' class='form-control' rows='5' cols='50' size='100' placeholder='Question' name='question[]' required></textarea><br>";
          		newdiv.innerHTML += "<input type='text' class='form-control' placeholder='Option One' name='option[]' required><br>";
          		newdiv.innerHTML += "<input type='text' class='form-control' placeholder='Option Two' name='option[]' required><br>";
          		newdiv.innerHTML += "<input type='text' class='form-control' placeholder='Option Three' name='option[]' required><br>";
          		newdiv.innerHTML += "<input type='text' class='form-control' placeholder='Option Four' name='option[]' required><br>";
          		newdiv.innerHTML += "<input type='number' class='form-control' placeholder='Answer(1/2/3/4)' name='answer[]' required><br>";
          		document.getElementById('questions').appendChild(newdiv);
          		counter++;
			}
		</script>
	</head>
	<body>
		<center><h3><b>Conduct Test</b></h3></center>
		<form style="padding: 20px;" method="POST" action="add_test_server.php">
			<?php
				if($_REQUEST['from']=='WEB'){ 
					echo"<input type='text' style='width: 250px;' class='form-control' placeholder='Subject Name (As Given in App)' name='subject_id' required><br>";
				}
			?>
			<input type='text' style="width: 250px;" class='form-control' placeholder='Test Title' name='test_name' required><br>
			<input type='number' style="width: 250px;" class='form-control' placeholder='Duration' name='duration' required><br>
			
			<div id="questions">
          		<b>Question #1</b><br>
          		<br><textarea type='text' class='form-control' rows="5" cols="50" size="100" placeholder='Question' name='question[]' required></textarea><br>
          		<input type='text' class='form-control' placeholder='Option One' name='option[]' required><br>
          		<input type='text' class='form-control' placeholder='Option Two' name='option[]' required><br>
          		<input type='text' class='form-control' placeholder='Option Three' name='option[]' required><br>
          		<input type='text' class='form-control' placeholder='Option Four' name='option[]' required><br>
          		<input type='number' class='form-control' placeholder='Answer(1/2/3/4)' name='answer[]' required><br>
     		</div>
			<input type="button" class="btn btn-secondary" value="Add another Question" onClick="addAnotherQuestion('dynamicInput');">
			<br><br><center><button class="btn btn-primary" type="submit">Submit</button></center>
		</form>
	</body>
</html>