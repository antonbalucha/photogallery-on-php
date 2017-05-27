<?php
	$photogallery_name = "photogallery-on-php";
	$album_name = "album-3";

    session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="description" content="Album of American Indians" />
		<meta name="keywords" content="Album, American Indians" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8">
		
		<title>American Indians 3</title>
		<link rel="stylesheet prefetch" href="../photoswipe/4.1.1/photoswipe.min.css"></link>
		<link rel="stylesheet prefetch" href="../photoswipe/4.1.1/default-skin/default-skin.min.css"></link>
		<link rel="stylesheet" href="../photoswipe/style.css"></link>
		
		<!-- This style is for PHP discussion form. -->
		<style>
			.container {
				position: relative;
				font-family: Calibri, sans-serif, serif;
			}
			
			section {
				padding-left: 10px;
				border: 0px solid #CCC;
				height: 100%;
				margin-bottom: 10px;
			}
			
			#name {
				width: 300px;
			}
			
			#commentary {
				width: 298px;
			}
			
			.commentary_time {
				font-family: Calibri, sans-serif, serif;
				font-size: 9px;
			}
			
			.commentary_name {
				font-family: Calibri, sans-serif, serif;
				font-weight: bold;
				margin-top: 10px;
			}
			
			.commentary_post {
				font-family: Calibri, sans-serif, serif;
				margin-right: 10px;
				margin-left: 10px;
			}
		</style>
	</head>

	<body>
	
		<div class="container">
			
			<section>
				<div class="my-gallery" itemscope itemtype="american-indians-1">
					<?php print_figure("american-indians-1", "indian-1.jpg", "1200x1600", "American Indian 1", "American Indian 1"); ?>
					<?php print_figure("american-indians-2", "indian-2.jpg", "1180x787", "American Indian 2", "American Indian 2"); ?>
					<?php print_figure("american-indians-3", "indian-3.jpg", "793x1024", "American Indian 3", "American Indian 3"); ?>
					<?php print_figure("american-indians-4", "indian-4.jpg", "736x953", "American Indian 4", "American Indian 4"); ?>
					<?php print_figure("american-indians-5", "indian-5.jpg", "742x960", "American Indian 5", "American Indian 5"); ?>
					<?php print_figure("american-indians-6", "indian-6.jpg", "494x640", "American Indian 6", "American Indian 6"); ?>
					<?php print_figure("american-indians-7", "indian-7.jpg", "409x576", "American Indian 7", "American Indian 7"); ?>
					<?php print_figure("american-indians-8", "indian-8.jpg", "650x873", "American Indian 8", "American Indian 8"); ?>
				</div>
			</section>
			
			<!-- This <section> tag is part of discussion form in PHP and can be deleted when you are interested only on photogallery -->
			<section>
			
				<form action="discussion.php" method="post">
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
					$sub_path_to_php = "/sub/" . $photogallery_name . "/" . $album_name;
					$sub_path_to_files = "/files/" . $photogallery_name . "/" . $album_name;
					
					// identify real path on server to the discussion.txt file
					$full_path_to_php = realpath(dirname(__FILE__));
					$full_path_to_files = str_replace($sub_path_to_php, $sub_path_to_files, $full_path_to_php);
					$full_path_to_discussion_txt = $full_path_to_files . "/discussion.txt";
				
					$myfile = fopen($full_path_to_discussion_txt, "r") or die("Unable to open file!");
					echo "<table>";
					while(!feof($myfile)) {
						$line = fgets($myfile);
						if (!empty($line)) {
							
							echo "<tr>";
							
								$parts = explode(";", $line);
								
								echo "<td>";
									$parts[1] = str_replace("\"", "", $parts[1]);
									$parts[1] = cleanXss($parts[1]);
									echo "<div class=\"commentary_name\">" . $parts[1] . "</div>";
																								
									$parts[0] = str_replace("\"", "", $parts[0]);
									$parts[0] = cleanXss($parts[0]);
									echo "<div class=\"commentary_time\">" . $parts[0] . "</div>";
								echo "</td>";
								
								echo "<td>";
									$parts[2] = str_replace("\"", "", $parts[2]);
									$parts[2] = cleanXss($parts[2]);
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
		
		<script src='../photoswipe/4.1.1/photoswipe.min.js'></script>
		<script src='../photoswipe/4.1.1/photoswipe-ui-default.min.js'></script>
		<script src="../photoswipe/index.js"></script>

	</body>
</html>

<?php
	} else {
		header("Location: ./../unauthorized.php");
	}
	
	function cleanXss($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function print_figure($item_type, $photo_name, $photo_size, $alt, $description) {
		echo "<figure itemprop=\"associatedMedia\" itemscope itemtype=\"$item_type\">";
		echo "<a href=\"./photo.php?photo_name=$photo_name&photo_type=photo\" itemprop=\"contentUrl\" data-size=\"$photo_size\">";
		echo "<img src=\"./photo.php?photo_name=$photo_name&photo_type=thumb\" itemprop=\"thumbnail\" alt=\"$alt\" />";
		echo "</a>";
		echo "<figcaption itemprop=\"caption description\">$description</figcaption>";
		echo "</figure>";
	}
?>
