<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints-Login</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/login.css" rel="stylesheet" type="text/css" />
<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
<!-- Theme End -->

</head>
<body>
	<div id="logincontainer">
		<div id="loginbox">
			<div id="loginheader">
				<a href="../" style="text-decoration:none;"><h1><font color="#2DABD5">RaspberryPints Login</h1></font></a>
			</div>
			<div id="innerlogin">
				<form name="login" action="includes/checklogin.php" method="POST">
					<p>Enter your username:</p>
					<input type="text" class="logininput" autofocus="autofocus" name="myusername" placeholder="Login Name" />
					<p>Enter your password:</p>
					<input type="password" class="logininput"  name="mypassword" placeholder="Password"/>
					<?php
						if(isset($_GET['wrong']))echo '<span class="bigtxt red">(Wrong Username Or Password)</span>';
					?>
					<input type="submit" class="loginbtn" value="Log In" /><br />
					<img src="img/lock.png" height="50" width="50">
					<p><a href="reset_account.php" title="Forgoteen Password?">Forgotten Password?</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
