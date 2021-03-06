<?php
	require './utils.php';

    session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
		
		$sub_path_to_php = "/sub/";
		$sub_path_to_files = "/files/";
		$file_with_discussion = "discussion.txt";
		$file_with_info_album = "info_album.ini";
		$file_with_info_photos = "info_photos.csv";

		// clean album name
		$album_directory = clean_xss($_GET["album_directory"]);
		$album_directory = clean_basename($album_directory);
		
		if ($album_directory == "") {
			header("Location: ./unauthorized.php");
		} else {
			// identify real path on server to the used files		
			$full_path_to_php = realpath(dirname(__FILE__));
			$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
			
			$full_path_to_discussion_txt = $full_path_to_files . "/" . $album_directory . "/" . $file_with_discussion;
			$full_path_to_info_album_ini = $full_path_to_files . "/" . $album_directory . "/" . $file_with_info_album;
			$full_path_to_info_photos_csv = $full_path_to_files . "/" . $album_directory . "/" . $file_with_info_photos;
			
			$info_album_ini_content = parse_ini_file($full_path_to_info_album_ini);	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="description" content="<?php echo $info_album_ini_content["album_short_description"] ?>" />
		<meta name="keywords" content="<?php echo $info_album_ini_content["album_keywords"] ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8">
		
		<title><?php echo $info_album_ini_content["album_name"] ?></title>
		<script src="./photogallery-on-php/discussion.js"></script>
		
		<link rel="stylesheet prefetch" href="./photoswipe/4.1.1/photoswipe.min.css"></link>
		<link rel="stylesheet prefetch" href="./photoswipe/4.1.1/default-skin/default-skin.min.css"></link>
		
		<link rel="stylesheet" href="./photoswipe/style-photoswipe.css"></link>
		<link rel="stylesheet" href="./photogallery-on-php/style-discussion.css"></link>
	</head>

	<body>
	
		<div class="container">
			<a href="./galleries.php" alt="Back" title="Back">Back</a>
			<a href="./handler_logout.php" alt="Logout" title="Logout">Logout</a>
		</div>

		<div class="container">
			<h1><?php echo $info_album_ini_content["album_name"] ?></h1>
			<p><?php echo $info_album_ini_content["album_description"] ?></p>
		</div>
	
		<div class="container">
			<section>
				<div class="my-gallery" itemscope itemtype="photoalbum">
					<?php					
						if (($file_handler = fopen($full_path_to_info_photos_csv, "r")) !== FALSE) {
							while (($data = fgetcsv($file_handler, 0, ";")) !== FALSE) {
								$photo_name = $data[0];
								$photo_width = $data[1];
								$photo_height = $data[2];
								$thumb_width = $data[3];
								$thumb_height = $data[4];
								$alt = $data[5];
								$description = $data[6];
					?>
						<figure itemprop="associatedMedia" itemscope itemtype="photoalbum">
							<a href="./handler_photo.php?album_directory=<?php echo $album_directory; ?>&photo_name=<?php echo $photo_name; ?>&photo_type=photo" itemprop="contentUrl" data-size="<?php echo ($photo_width . "x" . $photo_height); ?>">
								<img src="./handler_photo.php?album_directory=<?php echo $album_directory; ?>&photo_name=<?php echo $photo_name; ?>&photo_type=thumb" itemprop="thumbnail" alt="<?php echo $alt; ?>" title="<?php echo $description; ?>" width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" />
							</a>
							<figcaption itemprop="caption description"><?php echo $description; ?></figcaption>
						</figure>								
					<?php			
							}
							fclose($file_handler);
						}
					?>
				</div>
			</section>
			
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
							<button name="send" onclick="submit('<?php echo $album_directory ?>')" >Send</button>
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

				<table id="list_of_comments">
					<?php
						$file = file($full_path_to_discussion_txt);
						$reversed_file = array_reverse($file);
						
						foreach ($reversed_file as $line) {
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
						fclose($file);
					?>
				</table>
			</section>
		</div>
		
		<!-- Root element of PhotoSwipe. Must have class pswp. -->
		<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

			<!-- Background of PhotoSwipe. 
				 It's a separate element, as animating opacity is faster than rgba(). -->
			<div class="pswp__bg"></div>

			<!-- Slides wrapper with overflow:hidden. -->
			<div class="pswp__scroll-wrap">

				<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
				<!-- don't modify these 3 pswp__item elements, data is added later on. -->
				<div class="pswp__container">
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
				</div>

				<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
				<div class="pswp__ui pswp__ui--hidden">

					<div class="pswp__top-bar">

						<!--  Controls are self-explanatory. Order can be changed. -->

						<div class="pswp__counter"></div>

						<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

						<button class="pswp__button pswp__button--share" title="Share"></button>

						<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

						<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

						<!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
						<!-- element will get class pswp__preloader--active when preloader is running -->
						<div class="pswp__preloader">
							<div class="pswp__preloader__icn">
							  <div class="pswp__preloader__cut">
								<div class="pswp__preloader__donut"></div>
							  </div>
							</div>
						</div>
					</div>

					<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
						<div class="pswp__share-tooltip"></div> 
					</div>

					<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
					</button>

					<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
					</button>

					<div class="pswp__caption">
						<div class="pswp__caption__center"></div>
					</div>

				  </div>

				</div>

		</div>
		
		<script src='./photoswipe/4.1.1/photoswipe.min.js'></script>
		<script src='./photoswipe/4.1.1/photoswipe-ui-default.min.js'></script>
		<script src="./photoswipe/index.js"></script>

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

<?php
		}
	} else {
		header("Location: ./unauthorized.php");
	}
?>