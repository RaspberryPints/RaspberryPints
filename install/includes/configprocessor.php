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

require_once __DIR__.'/sql_parse.php';

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

echo "Success!<br>";
flush();

//Validate DB connectivity
echo "Checking DB connectivity...";
flush();
$con=mysqli_connect($servername,"root",$rootpass);

if (mysqli_connect_errno())
  {
  $validerror .= "<br><strong>Cannot connect the the database using the supplied information.</strong>";
  }

  //##TODO## Check if administrator account already exists

echo "Success!<br>";
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
	echo "Success!<br>";
	flush();
	
	echo "Removing configuration files...";
	flush();
	unlink('../../includes/config.php');
	unlink('../../admin/includes/conn.php');
	unlink('../../admin/includes/configp.php');
	echo "Success!<br>";
	flush();
}
	
if ($action == 'install')
{
	
require_once __DIR__.'/config_files.php';
	
	//-----------------Create the main config file-----------------
	echo "Update config files...";
	flush();
	
	file_put_contents('../../includes/config.php', $mainconfigstring);

	echo "Success!<br>";
	flush();
	// -----------------Create the admin files----------------------
	echo "Update admin config files...";
	flush();

	file_put_contents('../../admin/includes/conn.php', $adminconfig1);
	file_put_contents('../../admin/includes/configp.php', $adminconfig2);

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
	echo "Success!<br>";
	flush();

	//-----------------Run The Schema File-------------------------
	echo "Running Database Script...";
	flush();
	$dbms_schema = "../../sql/schema.sql";

		
	$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('Cannot find SQL schema file. ');
	
	$sql_query = remove_remarks($sql_query);
	$sql_query = remove_comments($sql_query);
	$sql_query = split_sql_file($sql_query, ';');


	mysql_connect($servername,'root',$rootpass) or die('error connection');

	$i=1;
	foreach($sql_query as $sql){
	//echo $i++;
	//echo "	";
	//echo $sql;
	mysql_query($sql) or die('error in query');
	}

	echo "Success!<br>";
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
	echo "Success!<br>";
	flush();
	//-----------------Load the sample data if requested-----------

		if(!empty($_POST['sampledata'])) 
		{
			echo "Adding sample data...";
			flush();
			
			$dbms_schema = "../../sql/test_data.sql";

		
			$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('Cannot find SQL schema file. ');
			
			$sql_query = remove_remarks($sql_query);
			$sql_query = remove_comments($sql_query);
			$sql_query = split_sql_file($sql_query, ';');


			mysql_connect($servername,'root',$rootpass) or die('error connection');

			$i=1;
			foreach($sql_query as $sql){
			//echo $i++;
			//echo "	";
			mysql_query($sql) or die('error in query');
			}

			
			echo "Success!<br>";
			flush();
		}
}


if ($action != 'remove')
{
	##TODO## Add better error handling before showing the Success message
	echo '<br /><br /><br /><h3> Congratulations! Your Raspberry Pints has been setup successfully.<br />';
	echo 'Tap List - <a href="http://' . $_SERVER['HTTP_HOST'] . '/index.php">http://' . $_SERVER['HTTP_HOST'] . '/index.php</a><br />';
	echo 'Administration - <a href="http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php">http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php</a><br />';
}

?>
</body>
</html>