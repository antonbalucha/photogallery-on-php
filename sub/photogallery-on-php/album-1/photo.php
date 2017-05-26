<?php
	$photogallery_name = "photogallery-on-php";
	$album_name = "album-1";
		
	$sub_path_to_php = "/sub/" . $photogallery_name . "/" . $album_name;
	$sub_path_to_files = "/files/" . $photogallery_name . "/" . $album_name;
	
	session_start();
	// show photo only if you are authorized
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
	
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			
			// clean photo name
			$photo_name = cleanXss($_GET["photo_name"]);
			$photo_name = basename($photo_name);
			
			// clean photo type
			$photo_type = cleanXss($_GET["photo_type"]);
			$photo_type = basename($photo_type);
			
			if ($photo_type == "thumb" || $photo_type == "photo") {
				
				if ($photo_name != "") {
			
					// identify real path on server to the photo
					$full_path_to_php = realpath(dirname(__FILE__));
					$sub_path_to_files = $sub_path_to_files . "/" . $photo_type;
					$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
					$full_path_to_photo = $full_path_to_files . "/" . $photo_name;
				
					// get the file's mime type to send the correct content type header
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$mime_type = finfo_file($finfo, $full_path_to_photo);

					if ($finfo != "" && $mime_type != "") {
						// send the headers
						header("Content-Type: $mime_type");
						header('Content-Length: ' . filesize($full_path_to_photo));

						// stream the file
						$fp = fopen($full_path_to_photo, 'rb');
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
	}
	
	function cleanXss($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function logger($text) {
		$myfile = fopen("log.txt", "a") or die("Unable to open file!");
		fwrite($myfile, ($text . "\n"));
		fclose($myfile);
	}?>