<?php
	require './utils.php';

	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {

		$sub_path_to_php = "/sub/";
		$sub_path_to_files = "/files/";
		$file_with_discussion = "discussion.txt";

		// identify real path on server to the file with discussion
		$full_path_to_php = realpath(dirname(__FILE__));
		$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
	
		$name = $commentary = $datetime = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			// clean album name
			$album_directory = clean_xss($_POST["album_directory"]);
			$album_directory = clean_basename($album_directory);
			
			// clean name
			$name = clean_xss($_POST["name"]);
			$name = clean_csv($name);
			
			// clean commentary
			$commentary = clean_xss($_POST["commentary"]);
			$commentary = clean_csv($commentary);
			$datetime = date('Y-m-d H:i:s');
			
			if ($album_directory != "") {
				$full_path_to_discussion_txt = $full_path_to_files . "/" . $album_directory . "/" . $file_with_discussion;
				add_commentary_to_file($full_path_to_discussion_txt, $datetime, $name, $commentary);
			} else {
				$full_path_to_discussion_txt = $full_path_to_files . "/" . $file_with_discussion;
				add_commentary_to_file($full_path_to_discussion_txt, $datetime, $name, $commentary);	
			}
			header("Content-Type: application/json");
			echo "{\"datetime\": \"" . $datetime . "\" , \"name\": \"" . $name . "\" , \"commentary\": \"" . $commentary . "\"}";
		} else {
			header("Location: ./unauthorized.php");
		}
	} else {
		header("Location: ./unauthorized.php");
	}
	
	function add_commentary_to_file($full_path_to_file, $datetime, $name, $commentary) {
		$text = "\"".$datetime."\"; \"".$name."\"; \"".$commentary."\"";
		add_text_to_file($full_path_to_file, $text);
	}
?>