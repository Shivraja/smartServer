<?php
	
	 session_start();
	 
	 if(isset($_SESSION['college_id']))
	 {
	 	include('home.php');
	 }
	 else
	 {
	 	include("login.php");
	 }

?>