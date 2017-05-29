<?php
	$sub_path_to_php = "/sub/";
	$sub_path_to_files = "/files/";
	$file_with_password = "password.txt";
	
	$full_path_to_php = realpath(dirname(__FILE__));
	$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
	$full_path_to_password = $full_path_to_files . "/" . $file_with_password;
	
	$myfile = fopen($full_path_to_password, "r") or die("Unable to verify password!");
	
	if (!feof($myfile)) {
		$default_password = fgets($myfile);
		
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(), '', 0, '/');
		session_regenerate_id(true);
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$password = trim($_POST["password"]);
			if ($password == $default_password) {
				session_start();
				$_SESSION["is_logged_in"] = "logged";
				header("Location: ./galleries.php");
			} else {
				header("Location: ./unauthorized.php");
			}
		} else {
			header("Location: ./unauthorized.php");
		}
	} else {
		header("Location: ./unauthorized.php");
	}
	fclose($myfile);						
?>