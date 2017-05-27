<?php

	$sub_path_to_php = "/sub/";
	$sub_path_to_files = "/files/";
	$file_with_discussion = "discussion.txt";

	// identify real path on server to the file with discussion
	$full_path_to_php = realpath(dirname(__FILE__));
	$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
	$full_path_to_discussion_txt = $full_path_to_files . "/" . $file_with_discussion;
	
	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {

		$name = $commentary = $datetime = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$name = cleanXss($_POST["name"]);
			$name = cleanCsv($name);
			$commentary = cleanXss($_POST["commentary"]);
			$commentary = cleanCsv($commentary);
			$datetime = date('Y-m-d H:i:s');
			
			$myfile = fopen($full_path_to_discussion_txt, "a") or die("full_path_to_php = $full_path_to_php; full_path_to_files = $full_path_to_files; full_path_to_discussion_txt = $full_path_to_discussion_txt " . "Unable to open file!");
			
			$text = "\"".$datetime."\"; \"".$name."\"; \"".$commentary."\"\n";
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
	
	function cleanCsv($data) {
		$data = str_replace("\"", "\\\"", $data);
		$data = str_replace(";", "", $data);
		return $data;
	}
?>