<?php
session_start();
require 'conn.php';
?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="../styles/layout.css" rel="stylesheet" type="text/css" />
<link href="../styles/login.css" rel="stylesheet" type="text/css" />
<!-- Theme Start -->
<link href="../styles.css" rel="stylesheet" type="text/css" />
<!-- Theme End -->

</head>
<body>
	<div id="logincontainer">
		<div id="loginbox">
			<div id="loginheader">
		<h1><a href="../" style="text-decoration:none;"><font color="#00CCFF">Password Reset</font></a></h1>
			</div>
			<div id="innerlogin">
				<form name="email_to" action="sendpassword.php" method="post">
				<p>Enter your Email:</p>
					<input type="text" class="logininput" autofocus="autofocus" name="email" id="email" required />
				<p>Enter NEW Password:</p>
					<input type="password" class="logininput" name="password" id="password" required /><br />
					<input type="submit" class="loginbtn" value="Submit" name="submit" /><br />
				</form>
<a href="../index.php" style="text-decoration:none;"><font color="grey">Go Back To Login</font></a> 
			</div>
		</div>
	</div>
</body>
</html>
