<?php

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

	$dbc = mysqli_connect("localhost", "root", "");

	if(!$dbc) {
		die("Server connection failed: " .mysqli_error($dbc));
		exit();
	}

	$dbs = mysqli_select_db($dbc, "Locator");

	if(!$dbs) {
		die("Database connection failed: " .mysqli_error($dbs));
		exit();
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	$name = '';
	$contact = '';
	$email = '';
	$age = '';
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		$name = $_GET['fullname'];
		$contact = $_GET['contact'];
		$email = $_GET['email'];
		$age = $_GET['age'];
	}

	$name = test_input($name);
	$contact = test_input($contact);
	$email = test_input($email);
	$age = test_input($age);

	$check = "SELECT * FROM SignedUp WHERE contact='$contact'";
	$raw_results = mysqli_query($dbc, $check) or trigger_error("Query MySQL Error: ".mysqli_error($raw_results)); 
	$rows = mysqli_num_rows($raw_results);

	if($rows==0) {

		$path = "user_info/".$contact;
		mkdir($path, 0777, true);
		$img_address = $path."/". $contact ."_image.jpg";
		$img_name = $contact."_image.jpg";

		if($_FILES["user_img"]["error"]>0) {
			echo "Error: " .$_FILES["user_img"]["error"]. "</br>";
		}
		else {
			move_uploaded_file($_FILES["user_img"]["tmp_name"], $img_address);
		}

		$file = $contact."txt";
		$c_query = "INSERT INTO e_contacts (contact, contacts) VALUES ('$contact', '$file')";

		$query = "INSERT into SignedUp (contact, name, email, age, image) VALUES ('$contact', '$name', '$email', '$age', '$img_name')";

		$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " .mysqli_error($dbc));

		if($result) {
			echo 1;
		}
		else {
			echo 3;
		}
	}
	else {

		echo 2;
	}

	mysqli_close($dbc);
?>