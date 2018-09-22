<?php

	function LogMessage($from, $msg)
	{
		$msg = var_export($msg, true);
		$fileName = '../logs/log_'.date('d-m-Y').'.txt';
		try {
			$msg = date("D, j M Y h:i:s A T")." : ".$from.".php\n".$msg."\n";
		} catch (Exception $e) {
			$msg = $e;
		}
		$msg = $msg."\n";

		file_put_contents($fileName, $msg, FILE_APPEND | LOCK_EX);
	}
?>