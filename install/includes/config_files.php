<?php
/***************************************************************************
* Config files for V1.0.3.395
****************************************************************************/
	
	//Main config files - /includes/config.php
        $mainconfigstring = "<?php \n";
        $mainconfigstring .= 'require_once (dirname(__FILE__) . "/db.php");' . "\n";
	$mainconfigstring .= '$host="' . "{$servername}" . '"; // Host name' . "\n";
	$mainconfigstring .= '$username="' . "{$dbuser}" . '"; // Mysql username' . "\n";
	$mainconfigstring .= '$password="' . "${dbpass1}" . '"; // Mysql password' . "\n";
	$mainconfigstring .= '$db_name="raspberrypints"; // Database name' . "\n";
        $mainconfigstring .= '//Connect to the database' . "\n";
        $mainconfigstring .= '$db = new MysqliDb ($host, $username, $password, $db_name);' . "\n";
	$mainconfigstring .= '$rpintsversion="1.0.3.395";' . "\n";
	$mainconfigstring .= "?>";
?>