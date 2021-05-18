<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
session_start();
require 'conn.php';
if (isset($_POST['email'])) {
    require_once 'functions.php';
    
    // Get values from form
    $email = encode($_POST['email']);
    
    // update data in mysql database
    $sql = "SELECT username FROM users WHERE email='$email'";
    /** @var mixed $mysqli **/
    $result = $mysqli->query($sql);
    $username = $result->fetch_row();
    ?>
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
				<h1>
					<a href="../" style="text-decoration: none;"> <font color="#00CCFF">Your
							Username Is</font>
					</a>
				</h1>
			</div>
			<div id="innerlogin">
					<?php
    // if successfully updated.
    if ($result) {
        echo '<font color="#00CCFF"><h2>' . $username[0] . '</h2></font>';
    } else {
        echo "ERROR";
    }
    ?>
					<br /> <a href="../index.php" style="text-decoration: none;"><font
					color="grey">Go Back To Login</font></a>
			</div>
		</div>
	</div>
</body>
<?php
} else {
    ?>
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
				<h1>
					<a href="../" style="text-decoration: none;"> <font color="#00CCFF">Forgot
							Username </font></a>
				</h1>
			</div>
			<div id="innerlogin">
				<form name="user" action="" method="post">
					<p>Enter your Email:</p>
					<input type="text" class="logininput" autofocus="autofocus"
						name="email" id="email" /> <input type="submit" class="loginbtn"
						value="Submit" name="submit" /><br />
				</form>
				<a href="../index.php" style="text-decoration: none;"><font
					color="grey">Go Back To Login</font></a>
			</div>
		</div>
	</div>
	<?php
}
?>
</body>
</html>
