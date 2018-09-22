<?php
       ini_set('max_execution_time', 300); //300 seconds = 5 minutes
       

	include_once('logger.php');
	define( 'API_ACCESS_KEY', 'AIzaSyDdTFiWVlDYp-zNMxjlW5I_a3qHqeJJxGE' );
  
  	$TAG = basename(__FILE__, '.php'); 
	function send_to_gcm($data, $registrationIds){
		LogMessage($TAG, "Send to FCM Started");
	
		LogMessage($TAG, $data);
		LogMessage($TAG, $registrationIds);

  		$fields = array
  		(
    		'registration_ids'  => $registrationIds,
    		'data'      => $data
  		);
 
	    $headers = array
  		(
  			'Authorization: key=' . API_ACCESS_KEY,
  			'Content-Type: application/json'
  		);
 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		//echo $result;
		LogMessage($TAG, $result);
		LogMessage($TAG, "Send to FCM Ended");
	}
?>