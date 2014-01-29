<head></head>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Installation Processor</title>
</head>
<body>
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//Process and load form data
$servername = $_POST["servername"];
$rootpass = $_POST["rootpass"];
$dbuser = $_POST["dbuser"];
$dbpass1 = $_POST["dbpass1"];
$dbpass2 = $_POST["dbpass2"];
$adminuser = $_POST["adminuser"];
$adminpass1 = $_POST["adminpass1"];
$adminpass2 = $_POST["adminpass2"];
$action = $_POST["selectaction"];
$sampledata = $_POST["sampledata"];

//Create the MD5 hash value for the admin password
$adminhash = md5($adminpass1);

//-----------------Do some validation---------
$validerror ='';
//Validate DB password
echo "Validating Entries...";
flush();

if ($dbpass1 != $dbpass2)
	{
		$validerror .= "<br><strong>Your Database passwords do not match.</strong>";
	}

//Validate admin password
if ($adminpass1 != $adminpass2) {
		$validerror .= "<br><strong>Your Administrator account passwords do not match.</strong>";
	}

echo "Done<br>";
flush();

//Validate DB connectivity
echo "Checking DB connectivity...";
flush();
$con=mysqli_connect($servername,"root",$rootpass);

if (mysqli_connect_errno())
  {
  $validerror .= "<br><strong>Cannot connect the the database using the supplied information.</strong>";
  }
//##TODO## Validate that there is no raspberrypints DB (not an upgrade)

echo "Done<br>";
flush();

//Display errors and die
if ($validerror !='') 
	{
		echo "<html><body>";
		echo $validerror;
		echo "<br /><br />Please press the back button on your browser to fix these errors";
		echo "</body></html>";
		die();
	}

if ($action == 'remove')
{
	echo "Deleting raspberrypints database...";
	flush();
	$con=mysqli_connect($servername,"root",$rootpass);
	// Check connection

	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$sql = "DROP database raspberrypints;";
	$result = mysqli_query($con,$sql);
	mysqli_close($con);
	echo "Done<br>";
	flush();
}
	
if ($action == 'install')
{
	
	//##TODO## -----------------Create the main config file-----------------
	echo "Update config files...";
	flush();

	echo "Done<br>";
	flush();
	//##TODO## -----------------Create the admin files----------------------
	echo "Update admin config files...";
	flush();

	echo "Done<br>";
	flush();

	//-----------------Create RPints User--------------------------
	echo "Creating RPints database user...";
	flush();
	$con=mysqli_connect($servername,"root",$rootpass);
	// Check connection

	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$sql = "GRANT ALL ON *.* TO '" . $dbuser . "'@'" . $servername . "' IDENTIFIED BY '" . $dbpass1 . "' WITH GRANT OPTION;";
	$result = mysqli_query($con,$sql);
	mysqli_close($con);
	echo "Done<br>";
	flush();

	//-----------------Run The Schema File-------------------------
	echo "Running Database Script...";
	flush();
	$command = "mysql -uroot -p".$rootpass . " -h " . $servername . " < /var/www/sql/schema.sql";
	$output = shell_exec($command);
	echo "Done<br>";
	flush();

	//-----------------Add the admin user to the Users DB----------
	echo "Adding new admin user...";
	flush();
	$con=mysqli_connect($servername,"root",$rootpass,"raspberrypints");
	// Check connection

	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	$currentdate = Date('Y-m-d H:i:s');
	$sql = "INSERT INTO users (username, password, name, email, createdDate, modifiedDate) VALUES ('" . $adminuser . "','" . $adminhash . "','name','email','" . $currentdate . "','" . $currentdate . "');";

	$result = mysqli_query($con,$sql);
	mysqli_close($con);
	echo "Done<br>";
	flush();
	//-----------------Load the sample data if requested-----------

		if ($sampledata = 'Yes') 
		{
			echo "Adding sample data...";
			flush();
			
			$command = "mysql -uroot -p".$rootpass . " -h " . $servername . " < /var/www/sql/test_data.sql";
			$output = shell_exec($command);
			
			echo "Done<br>";
			flush();
		}
}

/*
if ($key != '' && $color != '') {
    $f = fopen('config.php', 'w') or die("can't open file");
    fwrite($f, '<?php $keyword=' . $key . ';$color=' . $color . ';?>');
    fclose($f);
} else { // write default values or show an error message }

*/

##TODO## On Success - redirect to /index.php

?>
</body>
</html>