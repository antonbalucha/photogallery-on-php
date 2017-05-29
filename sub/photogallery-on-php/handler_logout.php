<?php
	session_start();
	if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] == "logged") {
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(), '', 0, '/');
		session_regenerate_id(true);
		header("Location: ./index.php");
	} else {
		header("Location: ./unauthorized.php");
	}
?>