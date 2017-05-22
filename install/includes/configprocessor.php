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
$adminname = $_POST["adminname"];
$adminemail = $_POST["adminemail"];

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
$con=mysql_connect($servername,"root",$rootpass);

echo "Success!<br>";
flush();

//Validate that the config directories are writable
echo "Checking config folder permissions...";
flush();
if (!is_writable(dirname('../../includes/functions.php')))
{
$validerror .= "<br><strong>Cannot write the configuration files. Please check the /includes/ folder permissions. See the RPints Installation page on www.raspberrypints.com.</strong>";
}

if (!is_writable(dirname('../../admin/includes/checklogin.php')))
{
$validerror .= "<br><strong>Cannot write the configuration files. Please check the /admin/includes/ folder permissions. See the RPints Installation page on www.raspberrypints.com.</strong>";
}
echo "Success!<br>";
flush();

//##TODO## Check if administrator account already exists



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
	$con=mysql_connect($servername,"root",$rootpass);
	// Check connection

	$sql = "DROP database raspberrypints;";
	$result = mysql_query($con,$sql);
	mysql_close($con);
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


	mysql_connect($servername,'root',$rootpass) or die('error in connection');

	$i=1;
	foreach($sql_query as $sql){
	//echo $i++;
	//echo "	";
	//echo $sql;
	//echo "<br>";
	mysql_query($sql) or die('error in query');
	}

	echo "Success!<br>";
	flush();

	//-----------------Create RPints User--------------------------
	echo "Creating RPints database user...";
	flush();
	$con=mysql_connect($servername,"root",$rootpass) or die('error in connection');
	// Check connection

	$sql = "GRANT ALL ON *.* TO '" . $dbuser . "' IDENTIFIED BY '" . $dbpass1 . "' WITH GRANT OPTION;";
	// $result = mysql_query($con,$sql);
	mysql_query($sql);
	# mysql_close($con);
	echo "Success!<br>";
	flush();


	//-----------------Add the admin user to the Users DB----------
	echo "Adding new admin user...";
	flush();
	$con=mysql_connect($servername,"root",$rootpass,"raspberrypints") or die('error in connection');
	// Check connection

	$currentdate = Date('Y-m-d H:i:s');
	$sql = "INSERT INTO users (username, password, name, email, createdDate, modifiedDate) VALUES ('" . $adminuser . "','" . $adminhash . "','" . $adminname . "','" . $adminemail . "','" . $currentdate . "','" . $currentdate . "');";
	//$result = mysql_query($con,$sql);
	mysql_query($sql);
	# mysql_close($con);
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

			$con=mysql_connect($servername,'root',$rootpass) or die('error connection');

			$i=1;
			foreach($sql_query as $sql){
			//echo $i++;
			//echo "	";
			print("SQL: " + $sql);
			mysql_query($sql) or die("Error in SQL: " + $sql);
			}

			echo "Success!<br>";
			flush();
		}
}


if ($action != 'remove')
{
	##TODO## Add better error handling before showing the Success message
	echo '<br /><br /><br /><h3> Congratulations! Your Raspberry Pints has been setup successfully.<br />';
	echo 'Click for - <a href="../../index.php">Tap List</a><br />';
	echo 'Click for - <a href="../../admin/index.php">Administration </a><br />';
}

?>
</body>
</html>
