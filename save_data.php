<?php

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

	$dbc = mysqli_connect("localhost", "root", "");
	if(!$dbc) {
		die("Server connection failed.")
		exit();
	}

	$dbs = mysqli_select_db($dbc, "Locator");
	if(!$dbs) {
		die("Database connection failed.");
		exit();
	}
	date_default_timezone_set("Asia/Kolkata");
	$datetime = date('Y/m/d H:i:s');

	if($_GET["userid"]) {
		$contact = $_GET["userid"];
	}

	$curr_long = '';
	$curr_lat = '';

	if($_GET['start']==1) {
		// Create a new file using the current timestamp
		$name = date("YmdHis");
		$path = "user_info/".$contact."/".$name.".txt";
		echo $path;
	}
	else {
		// Get file path 
		if($_GET["path"]) {
			$file_path = $_GET["path"];
		}

		if($_GET["long"]) {
			$curr_long = $_GET["long"];
		}

		if($_GET["lat"]) {
			$curr_lat = $_GET["lat"];
		}
		$data = $curr_long . "," . $curr_lat . ":	" . $datetime."\n";

		// Write to the file
		$ret = file_put_contents($file_path, $data, FILE_APPEND | LOCK_EX);
		if($ret==false) {
			die("Something went wrong.");
			exit();
		} 
	}	

?>