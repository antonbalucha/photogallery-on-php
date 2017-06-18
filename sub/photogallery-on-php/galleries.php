<?php
	require './utils.php';

	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
		
		$sub_path_to_php = "/sub/";
		$sub_path_to_files = "/files/";
		$file_with_discussion = "discussion.txt";
		$file_with_info_photos = "info_photos.csv";
		$file_with_info_gallery = "info_gallery.ini";
		$file_with_info_album = "info_album.ini";
		
		// identify real path on server to the used files
		$full_path_to_php = realpath(dirname(__FILE__));
		$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
		$full_path_to_discussion_txt = $full_path_to_files . "/" . $file_with_discussion;
		$full_path_to_info_gallery_ini = $full_path_to_files . "/" . $file_with_info_gallery;
				
		$info_gallery_ini_content = parse_ini_file($full_path_to_info_gallery_ini);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="description" content="<?php echo $info_gallery_ini_content["gallery_short_description"] ?>" />
		<meta name="keywords" content="<?php echo $info_gallery_ini_content["gallery_keywords"] ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8">
		
		<title><?php echo $info_gallery_ini_content["gallery_name"] ?></title>
		<script src="https://code.jquery.com/jquery-1.7.2.js"></script>
		<script src="./photogallery-on-php/discussion.js"></script>
		
		<link rel="stylesheet" href="./photogallery-on-php/style-discussion.css"></link>
		<link rel="stylesheet" href="./photogallery-on-php/style-gallery.css"></link>
	</head>
	
	<body>
	
		<div class="container">
			<a href="./handler_logout.php" alt="Logout" title="Logout">Logout</a>
		</div>
		
		<div class="container">
			<h1><?php echo $info_gallery_ini_content["gallery_name"] ?></h1>
			<p><?php echo $info_gallery_ini_content["gallery_description"] ?></p>
		</div>
	
		<div class="container">
			<div class="gallery">
				<?php
					$directories = glob($full_path_to_files . '/*' , GLOB_ONLYDIR);
				
					for ($i = 0; $i < count($directories); $i++) {
						
						$full_path_to_info_photos_csv = $directories[$i] . "/" . $file_with_info_photos;
						$album_directory = basename($directories[$i]);
						
						$full_path_to_info_album_ini = $full_path_to_files . "/" . $album_directory . "/" . $file_with_info_album;
						
						// load general information about photoalbum
						if (($handle = fopen($full_path_to_info_album_ini, "r")) !== FALSE) {
							$info_album_ini_content = parse_ini_file($full_path_to_info_album_ini);
							$album_name = $info_album_ini_content["album_name"];
							$album_short_description = $info_album_ini_content["album_short_description"];
						}
						
						// load information about first image in photoalbum which will be used as title image
						if (($handle = fopen($full_path_to_info_photos_csv, "r")) !== FALSE) {
							if (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
								$photo_name = $data[0];
								$photo_width = $data[1];
								$photo_height = $data[2];
								$thumb_width = $data[3];
								$thumb_height = $data[4];
								$photo_short_description = $data[5];
								$photo_long_description = $data[6];
							}
							fclose($handle);
						}
				?>
					<div class="image">
						<a href="./album.php?album_directory=<?php echo $album_directory; ?>">
						  <img 
								src="./handler_photo.php?album_directory=<?php echo $album_directory; ?>&photo_name=<?php echo $photo_name; ?>&photo_type=thumb" 
								title="<?php echo $album_short_description; ?>" 
								alt="<?php echo $album_name; ?>" 
								width="<?php echo $thumb_width; ?>"
								height="<?php echo $thumb_height; ?>"
							/>
						</a>
						<div class="desc"><?php echo $album_name ?></div>
					</div>
				<?php
					}
				?>
			</div>

			<!-- This <section> tag is part of discussion form in PHP -->
			<section>
				<table>
					<tr>
						<td>
							<label for="name">Your name</label>
						</td>
						<td>
							<input type="text" id="name" name="name" size="64" maxlength="64" /><br/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="commentary">Commentary</label>
						</td>
						<td>
							<textarea id="commentary" name="commentary" rows="5" size="512" maxlength="512"></textarea><br/>
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							<button name="send" onclick="submit('')" >Send</button>
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td id="error_message">
							&nbsp;
						</td>
					</tr>
				</table>
				
				<?php
					$myfile = fopen($full_path_to_discussion_txt, "r") or die("Unable to open file!");
				?>
					<table id="list_of_comments">
				<?php
					while(!feof($myfile)) {
						$line = fgets($myfile);
						if (!empty($line)) {
							$parts = explode(";", $line);
							
							$parts[0] = str_replace("\"", "", $parts[0]);
							$parts[0] = clean_xss($parts[0]);
					
							$parts[1] = str_replace("\"", "", $parts[1]);
							$parts[1] = clean_xss($parts[1]);
							
							$parts[2] = str_replace("\"", "", $parts[2]);
							$parts[2] = clean_xss($parts[2]);
				?>			
							<tr>
								<td>
									<div class="commentary_name"><?php echo $parts[1] ?></div>
									<div class="commentary_time"><?php echo $parts[0] ?></div>
								</td>
								<td>
									<div class="commentary_post"><?php echo $parts[2] ?></div>
								</td>
							</tr>
				<?php
						}
					}
					fclose($myfile);
				?>
					</table>
			</section>
		</div>
	</body>
</html>

<?php
	} else {
		header("Location: ./unauthorized.php");
	}
?>