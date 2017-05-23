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
$databasename = $_POST["database"];
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
	echo "Deleting " + $databasename + " database...";
	flush();
	$con=mysql_connect($servername,"root",$rootpass);
	// Check connection

	$sql = "DROP database " . $databasename . ";";
	$result = mysql_query($con,$sql);
	mysql_close($con);
	echo "Success!<br>";
	flush();

	echo "Removing configuration files...";
	flush();
	unlink('../../data/config/config.php');
	unlink('../../data/config/conn.php');
	unlink('../../data/config/configp.php');
	echo "Success!<br>";
	flush();
}

if ($action == 'install')
{

require_once __DIR__.'/config_files.php';

	// make sure the data directories exist
	$ddd = '../../data';
	if (!file_exists($ddd) && !is_dir($ddd)) {
		mkdir($ddd);
	}
	$ddd = '../../data/config';
	if (!file_exists($ddd) && !is_dir($ddd)) {
		mkdir($ddd);
	}
	$ddd = '../../data/images';
	if (!file_exists($ddd) && !is_dir($ddd)) {
		mkdir($ddd);
	}

  // copy in the logos if necessary
	if (!file_exists('../../data/images/logo.png')) {
		 copy('../../img/logo.png', '../../data/images/logo.png');
	}
	if (!file_exists('../../data/images/adminlogo.png')) {
		 copy('../../img/logo.png', '../../data/images/adminlogo.png');
	}
	//-----------------Create the main config file-----------------
	echo "Update config files...";
	flush();

	file_put_contents('../../data/config/config.php', $mainconfigstring);

	echo "Success!<br>";
	flush();
	// -----------------Create the admin files----------------------
	echo "Update admin config files...";
	flush();

	file_put_contents('../../data/config/conn.php', $adminconfig1);
	file_put_contents('../../data/config/configp.php', $adminconfig2);

	echo "Success!<br>";
	flush();

	//-----------------Create DB if it does not exist--------------------------
	echo "Creating Database...";
	flush();
	$con=mysql_connect($servername, "root", $rootpass) or die('error in connection');

	$sql = "CREATE DATABASE " . $databasename;
	// $result = mysql_query($con,$sql);
	mysql_query($sql, $con) or die(mysql_error());
	# mysql_close($con);
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
	mysql_select_db($databasename, $con) or die("Cannot select the database");

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
	mysql_query($sql) or die(mysql_error());
	# mysql_close($con);
	echo "Success!<br>";
	flush();


	//-----------------Add the admin user to the Users DB----------
	echo "Adding new admin user...";
	flush();
	$con=mysql_connect($servername,"root",$rootpass) or die('error in connection');
	mysql_select_db($databasename, $con) or die("Cannot select the database");
	// Check connection

	$currentdate = Date('Y-m-d H:i:s');
	$sql = "INSERT INTO users (username, password, name, email, createdDate, modifiedDate) VALUES ('" . $adminuser . "','" . $adminhash . "','" . $adminname . "','" . $adminemail . "','" . $currentdate . "','" . $currentdate . "');";
	//$result = mysql_query($con,$sql);
	mysql_query($sql) or die(mysql_error());
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
			mysql_select_db($databasename, $con) or die("Cannot select the database");

			$i=1;
			foreach($sql_query as $sql){
			//echo $i++;
			//echo "	";
			print("SQL: " + $sql);
			mysql_query($sql) or die(mysql_error());
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
