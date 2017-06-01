<?php
	require './utils.php';

	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
		
		$sub_path_to_php = "/sub/";
		$sub_path_to_files = "/files/";
		$file_with_discussion = "discussion.txt";
		$file_with_info_gallery = "info_gallery.ini";

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
		
		<link rel="stylesheet" href="../photoswipe/style-discussion.css"></link>
		<link rel="stylesheet" href="../photoswipe/style-gallery.css"></link>
	</head>
	
	<body>
	
		<div class="container">
			<a href="../handler_logout.php" alt="Logout" title="Logout">Logout</a>
		</div>
		
		<div class="container">
			<h1><?php echo $info_gallery_ini_content["gallery_name"] ?></h1>
			<p><?php echo $info_gallery_ini_content["gallery_description"] ?></p>
		</div>
	
		<div class="container">
			<div class="gallery">
				<div class="image">
					<a href="./album-1/album.php">
					  <img src="./handler_photo.php?album_name=album-1&photo_name=indian-1.jpg&photo_type=thumb" title="American Indians 1" alt="American Indians 1">
					</a>
					<div class="desc">American Indians 1</div>
				</div>
				
				<div class="image">
					<a href="./album-2/album.php">
					  <img src="./handler_photo.php?album_name=album-2&photo_name=indian-2.jpg&photo_type=thumb" title="American Indians 2" alt="American Indians 2">
					</a>
					<div class="desc">American Indians 2</div>
				</div>
				
				<div class="image">
					<a href="./album-3/album.php">
					  <img src="./handler_photo.php?album_name=album-3&photo_name=indian-3.jpg&photo_type=thumb" title="American Indians 3" alt="American Indians 3">
					</a>
					<div class="desc">American Indians 3</div>
				</div>
			</div>
			
			<!-- This <section> tag is part of discussion form in PHP -->
			<section>
			
				<form action="./handler_discussion.php" method="post">
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
								<input type="submit" name="submit" value="Send" />
							</td>
					</table>					
				</form>
				
				<?php
					$myfile = fopen($full_path_to_discussion_txt, "r") or die("Unable to open file!");
					echo "<table>";
					while(!feof($myfile)) {
						$line = fgets($myfile);
						if (!empty($line)) {
							
							echo "<tr>";
							
								$parts = explode(";", $line);
								
								echo "<td>";
									$parts[1] = str_replace("\"", "", $parts[1]);
									$parts[1] = clean_xss($parts[1]);
									echo "<div class=\"commentary_name\">" . $parts[1] . "</div>";
																								
									$parts[0] = str_replace("\"", "", $parts[0]);
									$parts[0] = clean_xss($parts[0]);
									echo "<div class=\"commentary_time\">" . $parts[0] . "</div>";
								echo "</td>";
								
								echo "<td>";
									$parts[2] = str_replace("\"", "", $parts[2]);
									$parts[2] = clean_xss($parts[2]);
									echo "<div class=\"commentary_post\">" . $parts[2] . "</div>";
								echo "</td>";

							echo "</tr>";
						}
					}
					echo "</table>";
										
					fclose($myfile);
				?>
			</section>
		</div>
		
	</body>
</html>

<?php
	} else {
		header("Location: ./unauthorized.php");
	}
?>
