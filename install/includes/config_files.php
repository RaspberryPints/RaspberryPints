<?php
/***************************************************************************
* Config files for V2.0.4.0
****************************************************************************/
	
	//Main config files - /includes/config.php
	$mainconfigstring = "<?php \n";
	$mainconfigstring .= "  function db() {\n";
	$mainconfigstring .= "		return new mysqli('" . $servername . "', '" . $dbuser . "', '" . $dbpass1 . "', '".$databasename."');\n";
	$mainconfigstring .= "	}\n";
	$mainconfigstring .= '    $rpintsversion="2.0.4.0";' . "\n";
	$mainconfigstring .= "?>";
	
	//Admin config file - /admin/conn.php
	$adminconfig1 = "<?php \n";
	$adminconfig1 .= '   $host="' . "{$servername}" . '"; // Host name' . "\n";
	$adminconfig1 .= '   $username="' . "{$dbuser}" . '"; // Mysql username' . "\n";
	$adminconfig1 .= '   $password="' . "${dbpass1}" . '"; // Mysql password' . "\n";
	$adminconfig1 .= '   $db_name="'.$databasename.'"; // Database name' . "\n";
	$adminconfig1 .= '   $tbl_name="users";' . "\n";
    $adminconfig1 .= '   //show/hide SQL statements in errors' . "\n";
    $adminconfig1 .= '   //$showSqlState = true;' . "\n";
	$adminconfig1 .= '   //Connect to server and select databse.' . "\n";
	$adminconfig1 .= '   $mysqli = new mysqli("$host", "$username", "$password", "$db_name")or die("cannot connect to server");' . "\n";
	$adminconfig1 .= '?>';
	
	//Admin config file - /admin/configp.php
	//$adminconfig2 = "<?php\n";
	//$adminconfig2 .= '  $dbhost="' . "{$servername}" . '";' . "\n";
	//$adminconfig2 .= '	$dbname ="'.$databasename.'";' . "\n";
	//$adminconfig2 .= '  $dbuser="' . "{$dbuser}" . '";' . "\n";
	//$adminconfig2 .= '  $dbpass="' . "${dbpass1}" . '";' . "\n";
	//$adminconfig2 .= '	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);' . "\n";
	//$adminconfig2 .= '	$stmt = $conn->prepare(' . "'SELECT * FROM config WHERE showOnPanel = 1')" . ";\n";
	//$adminconfig2 .= '	$stmt->execute();' . "\n";
	//$adminconfig2 .= '	$result = $stmt->fetchAll();' . "\n";
	//$adminconfig2 .= '?//>';
?>