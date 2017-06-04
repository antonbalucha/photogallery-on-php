<?php
	function clean_xss($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function clean_basename($data) {
		$data = basename($data);
		$data = str_replace("\.", "", $data);
		$data = str_replace("\\", "", $data);
		return $data;
	}
	
	function clean_csv($data) {
		$data = str_replace("\"", "\\\"", $data);
		$data = str_replace(";", "", $data);
		return $data;
	}
	
	function add_text_to_file($full_path_to_file, $text) {
		$myfile = fopen($full_path_to_file, "a") or die("Unable to add text to the file!");
		fwrite($myfile, ($text . "\n"));
		fclose($myfile);
	}
?>