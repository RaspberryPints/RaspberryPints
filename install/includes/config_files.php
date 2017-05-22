<?php
/***************************************************************************
* Config files for V1.0.0.369
****************************************************************************/

	//Main config files - /includes/config.php
	$mainconfigstring = "<?php \n";
	$mainconfigstring .= "    function db() {\n";
	$mainconfigstring .= '        $link = ';
	$mainconfigstring .= "mysql_connect('" . $servername . "', '" . $dbuser . "', '" . $dbpass1 . "');\n";
	$mainconfigstring .= "        mysql_select_db($databasename);\n";
	$mainconfigstring .= "	}\n";
	$mainconfigstring .= '    $rpintsversion="1.0.0.369";' . "\n";
	$mainconfigstring .= "?>";

	//Admin config file - /admin/conn.php
	$adminconfig1 = "<?php \n";
	$adminconfig1 .= '   $host="' . "{$servername}" . '"; // Host name' . "\n";
	$adminconfig1 .= '   $username="' . "{$dbuser}" . '"; // Mysql username' . "\n";
	$adminconfig1 .= '   $password="' . "${dbpass1}" . '"; // Mysql password' . "\n";
	$adminconfig1 .= '   $db_name="' . "${databasename}" . '"; // Database name' . "\n";
	$adminconfig1 .= '   $tbl_name="users";' . "\n";
	$adminconfig1 .= '   //Connect to server and select databse.' . "\n";
	$adminconfig1 .= '   mysql_connect("$host", "$username", "$password")or die("cannot connect to server");' . "\n";
	$adminconfig1 .= '   mysql_select_db("$db_name")or die("cannot select DB");' . "\n";
	$adminconfig1 .= '?>';

	//Admin config file - /admin/configp.php
	$adminconfig2 = "<?php\n";
	$adminconfig2 .= '  $dbhost="' . "{$servername}" . '";' . "\n";
	$adminconfig2 .= '	$dbname="' . "${databasename}" . '";' . "\n";
	$adminconfig2 .= '  $dbuser="' . "{$dbuser}" . '";' . "\n";
	$adminconfig2 .= '  $dbpass="' . "${dbpass1}" . '";' . "\n";
	$adminconfig2 .= '	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);' . "\n";
	$adminconfig2 .= '	$stmt = $conn->prepare(' . "'SELECT * FROM config WHERE showOnPanel = 1')" . ";\n";
	$adminconfig2 .= '	$stmt->execute();' . "\n";
	$adminconfig2 .= '	$result = $stmt->fetchAll();' . "\n";
	$adminconfig2 .= '?>';
?>
