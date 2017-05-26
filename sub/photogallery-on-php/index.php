<?php
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="description" content="Login to the photogallery" />
		<meta name="keywords" content="Login to the photogallery" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8">
		
		<title>Login to the photogallery</title>
		
		<style>
			.login_widget {
				height: 300px;
				position: relative;
				border: 0px solid #CCC;
			}
			
			.login_widget table {
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
		<div class="login_widget">
			<form action="handle_login.php" method="post">
				<table>
					<tr>
						<td>
							<label for="name">Password</label>
						</td>
						<td>
							<input type="password" id="password" name="password" size="64" maxlength="64"></input>
						</td>
						<td>
							<input type="submit" value="Log in"></input>
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							(Password for testing purposes is Test1)
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
				</table>					
			</form>
		</div>
	</body>
</html>
