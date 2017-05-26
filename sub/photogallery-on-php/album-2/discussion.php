<?php

	$photogallery_name = "photogallery-on-php";
	$album_name = "album-2";
		
	$sub_path_to_php = "/sub/" . $photogallery_name . "/" . $album_name;
	$sub_path_to_files = "/files/" . $photogallery_name . "/" . $album_name;

	// identify real path on server to the discussion.txt file
	$full_path_to_php = realpath(dirname(__FILE__));
	$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
	$full_path_to_discussion_txt = $full_path_to_files . "/discussion.txt";
	
	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {

		$name = $commentary = $datetime = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$name = cleanXss($_POST["name"]);
			$commentary = cleanXss($_POST["commentary"]);
			$datetime = date('Y-m-d H:i:s');
			
			$myfile = fopen($full_path_to_discussion_txt, "a") or die("full_path_to_php = $full_path_to_php; full_path_to_files = $full_path_to_files; full_path_to_discussion_txt = $full_path_to_discussion_txt " . "Unable to open file!");
			$text = "\"".$datetime."\";;; \"".$name."\";;; \"".$commentary."\"\n";
			fwrite($myfile, $text);
			fclose($myfile);
			
			header("Location: ./index.php");
		} else {
			header("Location: ./../unauthorized.php");
		}
	} else {
		header("Location: ./../unauthorized.php");
	}
	
	function cleanXss($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>