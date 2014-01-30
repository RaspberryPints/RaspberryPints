	<?php
	$installed=0;
	if (!file_exists("../includes/config22.php")) {
		$installed=1;
	} else {
		$installed=0;
	}
	?> 

<html>
	<script>
		//http://jsfiddle.net/rpP4K/
		function checkPasswordMatch() {
			var password = $("#txtNewPassword").val();
			var confirmPassword = $("#txtConfirmPassword").val();

			if (password != confirmPassword)
				$("#divCheckPasswordMatch").html("Passwords do not match!");
			else
				$("#divCheckPasswordMatch").html("Passwords match.");
		}
		function checkAdminPasswordMatch() {
			var password = $("#txtCheckAdminPassword").val();
			var confirmPassword = $("#txtConfirmAdminPassword").val();

			if (password != confirmPassword)
				$("#divCheckAdminPasswordMatch").html("Passwords do not match!");
			else
				$("#divCheckAdminPasswordMatch").html("Passwords match.");
		}

		$(document).ready(function () {
		   $("#txtConfirmPassword").keyup(checkPasswordMatch);
		   $("#txtConfirmAdminPassword").keyup(checkAdminPasswordMatch);
		});
	</script>



	<head>
    <title>RaspberryPints Installation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Set location of Cascading Style Sheets and script files -->
    <link rel="stylesheet" type="text/css" href="styles.css" />
	<link rel="shortcut icon" href="../img/pint.ico" />

	<script type="text/javascript" src="includes/jquery-2.1.0.min.js"></script>	
	<script src="includes/jquery.validate.js"></script>
    
  </head>
  <body>

   
  <h1>Welcome to Raspberry Pints!</h1>
  
     <form action="includes/configprocessor.php" method="post">

	<?php
		if (file_exists("../includes/config.php")) {
		echo 'We noticed that you already have installed RPints. Please select an option from the menu below';
		echo '<br><select name="selectaction">';
			//Check versions
			require_once '../includes/config.php';
			db();
			$sql = 'SELECT * FROM config where configname = "Version"';
			$qry = mysql_query($sql);	
			$dbversion = mysql_result($qry,0,2);
		
			if ($dbversion != $rpintsversion) {
				echo '<option value="upgrade">Upgrade</option>';
			}
		echo '<option value="remove">Clear Data</option>';
		echo '</select>';
		} else {
		//echo '<option value="install" selected>Install</option>';
		echo '<input type="hidden" name="selectaction" value="install">';
	}
	?> 
	<h3>Step<span class="tapcircle">1</span></h3>
In order to get started, we'll need a little information from you. When you installed mySQL, you were asked for a "root" password.
You'll need to enter that here for us to configure RPints for you. You should leave the Database Server name as the default, unless
you are certain you need to change it.
	<table>
			<tr>
				<td>
					<label for="textfield"><strong>Database Server: (required)</strong></label> 
				</td>
				<td>
					<input minlength="2" required class="inputbox" value="localhost" type="text" name="servername" required>				
				</td>
			</tr>
			<tr>
				<td>
					<label for="textfield"><strong>Root Password: (required)</strong></label> 
				</td>
				<td>
					<input class="inputbox" required type="password" name="rootpass">			
				</td>
			</tr>
		</table>
		<br />				
		<br />
	<br>
	<h3>Step<span class="tapcircle">2</span></h3>
		Now it's time to create the database user for Raspberry Pints to use. The default is "beers" and you can keep the default if you would like.
		This database account is just used by the software to access the database. This is not your administration account.
		<table>
			<tr>
				<td>
					<label for="textfield"><strong>Database Username:</strong> 
				</td>
				<td>
					</label> <input class="inputbox" value="beers" name="dbuser">				
				</td>
			</tr>
			<tr>
				<td>
					<label for="textfield"><strong>Database Password:</strong></label>
				</td>
				<td>
					<input class="inputbox" id="txtNewPassword" type="password" name="dbpass1">		
				</td>
			</tr>			<tr>
				<td>
					<label for="textfield"><strong>Confirm Password:</strong></label>
				</td>
				<td>
					<input class="inputbox" id="txtConfirmPassword" type="password" name="dbpass2" onChange="checkPasswordMatch()";>
				</td>
				<td>
					<div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
				</td>
			</tr>
		</table>
		<br />
		<br />
	<h3>Step<span class="tapcircle">3</span></h3>
				And at last, we'll need to create a management account. this account is used for adding / removing beers, etc.
		<table>
			<tr>
				<td>
					<label for="textfield"><strong>RPints Username:</strong> 
				</td>
				<td>
					</label> <input class="inputbox" value="admin" name="adminuser">				
				</td>
			</tr>
			<tr>
				<td>
					<label for="textfield"><strong>Email Address:</strong> 
				</td>
				<td>
					</label> <input class="inputbox" name="adminemail">				
				</td>
			</tr>
			<tr>
				<td>
					<label for="textfield"><strong>Your Name:</strong> 
				</td>
				<td>
					</label> <input class="inputbox" name="adminname">				
				</td>
			</tr>
			<tr>
				<td>
					<label for="textfield"><strong>Admin Password:</strong></label>
				</td>
				<td>
					<input class="inputbox" id="txtCheckAdminPassword" type="password" name="adminpass1">		
				</td>
			</tr>			<tr>
				<td>
					<label for="textfield"><strong>Confirm Password:</strong></label>
				</td>
				<td>
					<input class="inputbox" id="txtConfirmAdminPassword" type="password" name="adminpass2" onChange="checkAdminPasswordMatch()";>
				</td>
				<td>
					<div class="registrationFormAlert" id="divCheckAdminPasswordMatch"></div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		If you would like to load sample data, please check the box below. This will allow you to see what the system does without having to
		type in all your beers. It's not that difficult to add your beers, so the default is not to load.
		<br />
		<br />
		<input type="checkbox" name="sampledata" value="Yes"><strong>Load sample data?</strong>
		<br />
		<br />
		<br />
		<input class="btn" type="submit" value="Setup!">

	</form>
  </body>
</html>
