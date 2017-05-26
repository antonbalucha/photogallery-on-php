<?php
	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="description" content="Photogalleries of American Indians" />
		<meta name="keywords" content="Photogallery, American Indians" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8">
		
		<title>Photogalleries of American Indians</title>
		<style>
			.gallery {
				width: 100%;
				height: 100%;
				overflow: auto;
				background-color: white;
			}
		
			div.image {
				float: left;
				width: auto;
				height: 260px;
				margin: 5px;
				background-color: white;
				border: 1px solid #CCC;
			}

			div.image:hover {
				border: 1px solid #777;
			}

			div.image img {
				width: auto;
				height: 200px;
			}

			div.desc {
				padding: 15px;
				text-align: center;
				font-family: Calibri, "Times New Roman", Georgia, Serif;
				font-size: 14px;
			}

			* {
				box-sizing: border-box;
			}
		</style>
	</head>
	
	<body style="background-color:#white;">
	
		<div class="gallery">
			<div class="image">
				<a href="./album-1/index.php">
				  <img src="./album-1/photo.php?photo_name=indian-1.jpg&photo_type=thumb" title="American Indians 1" alt="American Indians 1">
				</a>
				<div class="desc">American Indians 1</div>
			</div>
			
			<div class="image">
				<a href="./album-2/index.php">
				  <img src="./album-2/photo.php?photo_name=indian-2.jpg&photo_type=thumb" title="American Indians 2" alt="American Indians 2">
				</a>
				<div class="desc">American Indians 2</div>
			</div>
			
			<div class="image">
				<a href="./album-3/index.php">
				  <img src="./album-3/photo.php?photo_name=indian-3.jpg&photo_type=thumb" title="American Indians 3" alt="American Indians 3">
				</a>
				<div class="desc">American Indians 3</div>
			</div>
		</div>
		
	</body>
</html>

<?php
	} else {
		header("Location: ./unauthorized.php");
	}
?>
