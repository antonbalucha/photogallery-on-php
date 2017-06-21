<!DOCTYPE html>
<html>
	<head>
		<meta name="description" content="Unauthorized" />
		<meta name="keywords" content="Unauthorized" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8">
		
		<title>Unauthorized access</title>
		
		<style>
			.widget {
				height: 300px;
				position: relative;
				border: 0px solid #CCC;
			}
			
			.message {
				padding: 10px;
				border: 1px solid #CCC;
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				font-family: Calibri, "Times New Roman", Georgia, Serif;
				font-size: 16px;
			}
			
			.login_widget td {
				padding: 10px;
			}

			#password {
				width: 300px;
				height: 20px;
				border: 1px solid #CCC;
			}
		</style>
	</head>

	<body>
		
		<div class="widget">
			<div class="message">
				You are not allowed to access this page. Please <a href="./index.php">enter</a> valid credentials. 
			</div>
		</div>

		<?php
			// Print Google Analytics script
			$file_google_analytics = "google_analytics.txt";
			$full_path_to_google_analytics = $full_path_to_files . "/" . $file_google_analytics;
			
			if (($file_handler = @fopen($full_path_to_google_analytics, "r")) !== FALSE) {
				echo fread($file_handler, filesize($full_path_to_google_analytics));
				fclose($file_handler);
			}
		?>
		
	</body>
</html>
