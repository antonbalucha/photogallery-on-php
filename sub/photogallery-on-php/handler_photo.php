<?php
	require './utils.php';

	// show photo only if you are authorized
	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
	
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			
			$sub_path_to_php = "/sub/";
			$sub_path_to_files = "/files/";

			// identify real path on server to the used files
			$full_path_to_php = realpath(dirname(__FILE__));
			$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
			
			// clean album name
			$album_directory = clean_xss($_GET["album_directory"]);
			$album_directory = clean_basename($album_directory);
			
			// clean photo type
			$photo_type = clean_xss($_GET["photo_type"]);
			$photo_type = clean_basename($photo_type);
			
			// clean photo name
			$photo_name = clean_xss($_GET["photo_name"]);
			$photo_name = clean_basename($photo_name);
			
			if ($photo_type == "thumb" || $photo_type == "photo") {
				
				if ($album_directory != "" && $photo_name != "") {
			
					// identify real path on server to the photo
					$full_path_to_photo = $full_path_to_files . "/" . $album_directory . "/" . $photo_type . "/" . $photo_name;
				
					// get the file's mime type to send the correct content type header
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$mime_type = finfo_file($finfo, $full_path_to_photo);

					if ($finfo != "" && $mime_type != "") {
						// send the headers
						header("Content-Type: $mime_type");
						header("Content-Length: " . filesize($full_path_to_photo));

						// stream the file
						$fp = fopen($full_path_to_photo, "rb");
						fpassthru($fp);
					} else {
						header("Location: ./../unauthorized.php");
					}
				} else {
					header("Location: ./../unauthorized.php");
				}
			} else {
				header("Location: ./../unauthorized.php");
			}
		} else {
			header("Location: ./../unauthorized.php");
		}
	} else {
		header("Location: ./../unauthorized.php");
	}?>