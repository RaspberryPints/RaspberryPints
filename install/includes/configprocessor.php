<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Installation Processor</title>

<script>
window.onpageshow = function(evt) {
    // If persisted then it is in the page cache, force a reload of the page.
    if (evt.persisted) {
        document.body.style.display = "none";
        location.reload();
    }
};
</script>

</head>
<body>
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require_once __DIR__.'/sql_parse.php';

//Process and load form data
$servername = $_POST["servername"];
$rootuser = $_POST["rootuser"];
$rootpass = $_POST["rootpass"];
$databasename = $_POST["database"];
$dbuser = $rootuser;//$_POST["dbuser"];
$dbpass1 = $rootpass;//$_POST["dbpass1"];
$dbpass2 = $rootpass;//$_POST["dbpass2"];
$adminuser = $_POST["adminuser"];
$adminpass1 = $_POST["adminpass1"];
$adminpass2 = $_POST["adminpass2"];
$action = $_POST["selectaction"];
$adminnamefirst = $_POST["adminnamefirst"];
$adminnamelast = $_POST["adminnamelast"];
$adminemail = $_POST["adminemail"];

//Create the MD5 hash value for the admin password
$adminhash = md5($adminpass1);

//-----------------Do some validation---------
$validerror ='';
//Validate DB password
echo "Validating Entries...";
flush();

if ($dbpass1 != $dbpass2){
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
$mysqli = new mysqli($servername,$rootuser,$rootpass);

$error = false;
if (mysqli_connect_errno()){
    $validerror .= "<br><strong>Cannot connect the the database using the supplied information.</strong>";
	$error = true;
}else{
    echo "Success Connecting to Database!<br>";
}
flush();

//Validate that the config directories are writable
echo "Checking config folder permissions...";
flush();
if (!is_writable(dirname('../../includes/functions.php')))
{
    $validerror .= "<br><strong>Cannot write the configuration files. Please check the /includes/ folder permissions. See the RPints Installation page on www.raspberrypints.com.</strong>";
    $error = true;
}

if (!is_writable(dirname('../../admin/includes/checklogin.php')))
{
    $validerror .= "<br><strong>Cannot write the configuration files. Please check the /admin/includes/ folder permissions. See the RPints Installation page on www.raspberrypints.com.</strong>";
    $error = true;
}
if(!$error)echo "Success!<br>";
flush();

//Display errors and die
if ($validerror !=''){
	echo "<html><body>";
	echo $validerror;
	echo "<br /><br />Please press the back button on your browser to fix these errors";
	echo "</body></html>";
	die();
}

$validerror = '';
if ($action == 'backup' || $action == 'remove' || $action == 'restore')
{
    echo "backing RaspberryPints...";
    flush();
    
    $sql_query = '';
    $sql = "USE `" . $databasename . "`;";
    $mysqli->query($sql);
    
    $tables = array();
    $sql = "SELECT tab.table_name, tab.table_type, GROUP_CONCAT(referenced_table_name) AS referenced_table_name
            FROM INFORMATION_SCHEMA.TABLES tab
                LEFT JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE col
                    ON (tab.table_schema = col.table_schema and tab.table_name = col.table_name)
            WHERE tab.table_schema = '".$databasename."'
            GROUP BY tab.table_schema, tab.table_name
            ORDER BY tab.table_type, referenced_table_name";
    $qry = $mysqli->query($sql);
    while($qry && $i = $qry->fetch_array()){
        $tables[] = $i;
    }
    if(count($tables) > 0)
    {
        $completed = array();
        $return = '';
        $return.= "SET FOREIGN_KEY_CHECKS=0;\n";
        for($j = count($tables)-1; $j >= 0; $j--)
        {
            $table = $tables[$j][0];
            $type = ($tables[$j][1]!='VIEW'?'TABLE':'VIEW');
            $return.= 'DROP '.$type.' IF EXISTS '.$table.';'."\n";
        }
        do{
            $skipped = array();
            foreach($tables as $tableInfo){
                $table = $tableInfo[0];
                $type = ($tableInfo[1]!='VIEW'?'TABLE':'VIEW');
                $dependancies = explode(",", $tableInfo[2]);
                if(in_array($table, $completed))continue;
                $skip = false;
                foreach ($dependancies as $depTable){
                    if(empty($depTable))continue;
                    if(!in_array($depTable, $completed)){
                        $skip = true;
                        break;
                    }
                }
                if($skip){
                    $skipped[] = $tableInfo;
                    continue;
                }
                $qry = $mysqli->query('SHOW CREATE '.$type.' '.$table);
                $types = array();
                if($qry && $row = $qry->fetch_array(MYSQLI_NUM)){
                    //0 = name
                    //1 = create statement
                    $return.= $row[1].";\n\n";
                    $types = explode(",", preg_replace("/\d+,\d+/","", $row[1]));
                }
                if($type != 'VIEW' && $table != 'log' && $table != 'templog')
                {
                    $qry = $mysqli->query('SELECT * FROM '.$table);
                    while($qry && $row = $qry->fetch_array(MYSQLI_NUM))
                    {
                        $return.= 'INSERT INTO '.$table.' VALUES(';
                        $values = '';
                        for($j = 0; $j < count($row); $j++){
                            $value = $row[$j];
                            if($values != '') $values.=',';
                            $value = $mysqli->escape_string($value);
                            $isInt = strpos(strtolower($types[$j]), "int(") || strpos(strtolower($types[$j]), "decimal(") || strpos(strtolower($types[$j]), "float") || strpos(strtolower($types[$j]), "double");
                            $isDate = strpos(strtolower($types[$j]), "date") || strpos(strtolower($types[$j]), "timestamp");
                            $value = ($value == '' && ($isInt || $isDate)?"NULL":"'$value'");
                            $values.=$value;
                        }
                        $return.= $values.");\n";
                    }
                }
                $return.="\n\n\n";
                
                $completed[] = $table;
            }
            $tables = $skipped;
        }while(false && count($tables) > 0);
        
        $return.= "SET FOREIGN_KEY_CHECKS=1;\n";
        //save file
        $dirName = (isset($_POST["dirBackup"])?$_POST["dirBackup"]:null);
        if(empty($dirName)){
            $dirName = '../../sql/backups';
        }
        if(!file_exists($dirName))mkdir($dirName);
        $handle = fopen($dirName.'/db-'.$databasename.'-backup'.($action != 'backup'?'-before-'.$action:'').'-'.date('Y-m-d His').'.sql','w+');
        fwrite($handle,$return);
        fclose($handle);
    }
    echo "Success!<br>";
    flush();
    
    if($action == 'backup'){
        $_SESSION['successMessage'] = "Successfully Backed Up RaspberryPints";
        echo "<script>window.location = '".$_SERVER['HTTP_REFERER']."'</script>";
    }else{
        $validerror = '';
    }
}

// CLEAR INSTALLATION DATA ROUTINES
if ($action == 'remove')
{
	echo "Deleting " . $databasename . " database...";
	flush();
	//$mysqli = new mysqli($servername,$rootuser,$rootpass);
	// Check connection

	if (mysqli_connect_errno())
	{
	    $validerror .= "<br><strong>Failed to connect to MySQL: " . $mysqli->connect_error() . "</strong>";
		exit();
	}

	$sql = "DROP database " . $databasename . ";";
	$mysqli->query($sql);
	if($mysqli->error != ""){
	    $validerror .= "<br><strong>Cannot DROP existing Database[".$databasename."]: " . $mysqli->error . "</strong>";
	}else{
	   echo "Success!<br>";
	}
	flush();
	
	$error = false;
	echo "Removing configuration files...";
	flush();
	try {
    	if (file_exists('../../includes/config.php'))      unlink('../../includes/config.php');
    	if (file_exists('../../admin/includes/conn.php'))  unlink('../../admin/includes/conn.php');
    	//if (file_exists('../../includes/configp.php'))   unlink('../../admin/includes/configp.php');
	} catch (Exception $e) {
		$validerror .= "<br><strong>Caught exception: " .  $e->getMessage() . "</strong>";
		$error = true;
	}
	
	//unlink('../../includes/config.php');
	//unlink('../../admin/includes/conn.php');
	//unlink('../../admin/includes/configp.php');

	if(!$error)echo "Success!<br>";
	flush();
}
	
if ($action == 'install')
{
	
    require_once __DIR__.'/config_files.php';
	
	//-----------------Create the main config file-----------------
	echo "Update config files...";
	flush();
	
	/** @var mixed $mainconfigstring **/
	/** @var mixed $adminconfig1 **/
	file_put_contents('../../includes/config.php', $mainconfigstring);

	echo "Success!<br>";
	flush();
	// -----------------Create the admin files----------------------
	echo "Update admin config files...";
	flush();

	file_put_contents('../../admin/includes/conn.php', $adminconfig1);
	//file_put_contents('../../admin/includes/configp.php', $adminconfig2);
	
	echo "Success!<br>";
	flush();

	//-----------------Create RPints Database----------------------
	echo "Creating RPints database...";
	flush();

	$error = false;
	$sql = "DROP DATABASE `" . $databasename . "`;";
	/** @var mixed $result **/
	$result = $mysqli->query($sql);
	// ignore errors
	
	$sql = "CREATE DATABASE `" . $databasename . "` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
	$result = $mysqli->query($sql);
	if($mysqli->error != ""){
	    $validerror .= "<br><strong>Cannot Create new Database[".$databasename."]: " . $mysqli->error . "</strong>";
	    $error = true;
	}
	$sql = "USE `" . $databasename . "`;";
	$result = $mysqli->query($sql);
	if($mysqli->error != ""){
	    $validerror .= "<br><strong>Cannot USE Database[".$databasename."]: " . $mysqli->error . "</strong>";
	    $error = true;
	}
	if(!$error){
	    $error = false;
	    echo "Success!<br>";
	    flush();
    
    	//-----------------Create RPints User--------------------------
    	echo "Creating RPints database user...";
    	flush();
    
    	$sql = "GRANT ALL ON *.* TO '" . $dbuser . "'@'" . $servername . "' IDENTIFIED BY '" . $dbpass1 . "' WITH GRANT OPTION;";
    	$result = $mysqli->query($sql);
    	if($mysqli->error != ""){
    	    $validerror .= "<br><strong>Cannot Create User[".$dbuser."]: " . $mysqli->error . "</strong>";
    	    $error = true;
    	}else{
    	   echo "Success!<br>";
    	}
    	flush();
    	
    	if ($validerror !=''){
    	    echo "<html><body>";
    	    echo $validerror;
    	    echo "<br /><br />Please press the back button on your browser to fix these errors";
    	    echo "</body></html>";
    	    die();
    	}
    	$validerror = '';
    	//-----------------Run The Schema File-------------------------
    	echo "Running Database Script...";
    	flush();
    	$dbms_schema = "../../sql/schema.sql";
    
    		
    	$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('Cannot find SQL schema file. ');
    	
    	$sql_query = remove_remarks($sql_query);
    	$sql_query = remove_comments($sql_query);
    	$sql_query = split_sql_file($sql_query, ';');
        
    	$i=1;
    	foreach($sql_query as $sql){
    		if(rtrim($sql) == "") continue;
    		//echo "	";
    		//echo $sql;
    		//echo "<br>";
    		$mysqli->query($sql) or die('error in query '.$i.'['.substr($sql,0,80).'] ['.$mysqli->error.']');
    		//echo "<br>";
    		$i++;
    	}
    
    	echo "Success!<br>";
    	flush();
    
    	//-----------------Add the admin user to the Users DB----------
    	echo "Adding new admin user...";
    	flush();
    
    	$currentdate = Date('Y-m-d H:i:s');
    	$sql = "DELETE FROM users WHERE username = '" . $adminuser . ";";
    	$result = $mysqli->query($sql);
    	$sql  = "INSERT INTO users (username, password, nameFirst, nameLast, email, active, isAdmin, createdDate, modifiedDate) ";
    	$sql .= "VALUES ('" . $adminuser . "','" . $adminhash . "','" . $adminnamefirst . "','" . $adminnamelast . "','" . $adminemail . "', 1, 1,'" . $currentdate . "','" . $currentdate . "');";
    	$result = $mysqli->query($sql);
    	if($mysqli->error != ""){
    	    $validerror .= "<br><strong>Cannot Create User[".$dbuser."]: " . $mysqli->error . "</strong>";
    	    $error = true;
    	}else{
    	    echo "Success!<br>";
    	}
    	flush();
	}
	if ($validerror !=''){
	    echo "<html><body>";
	    echo $validerror;
	    echo "<br /><br />Please press the back button on your browser to fix these errors";
	    echo "</body></html>";
	    die();
	}
    	
	//-----------------Delete the index.html page, if it exists -----------------
	$index = '../../index.html';
	echo "Deleting default Apache index...";
	flush();
	if (file_exists($index)) {
		unlink($index);
		echo "Success! <br>";
	} else {
		echo "Success! File already deleted <br>";
	}
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


		////$mysqli = new mysqli($servername,$rootuser,$rootpass) or die('error connection');

		$i=1;
		foreach($sql_query as $sql){
			if(rtrim($sql) == "") continue;
			//echo "	";
			//echo $sql;
			//echo "<br>";
			$mysqli->query($sql) or die('error in query '.$i.'['.substr($sql,0,80).'] ['.$mysqli->error.']');
			//echo "<br>";
			$i++;
		}

		
		//$mysqli->close();
		echo "Success!<br>";
		flush();
	}
}

if ($action == 'upgrade')
{
    echo "Upgrading RaspberryPints...";
    flush();
    
    $dbms_schema = "../../sql/update.sql";
        
    $sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('Cannot find SQL update file. ');
    
    $sql_query = remove_remarks($sql_query);
    $sql_query = remove_comments($sql_query);
    $sql_query = split_sql_file($sql_query, ';');
    
    $sql = "USE `" . $databasename . "`;";
    $result = $mysqli->query($sql);
    
    $i=1;
    foreach($sql_query as $sql){
        if(rtrim($sql) == "") continue;
        //echo "	";
        //echo $sql;
        //echo "<br>";
        $mysqli->query($sql) or die('error in query '.$i.'['.substr($sql,0,80).'] ['.$mysqli->error.']');
        while( $mysqli->more_results() && $mysqli->next_result()){
            $rs = $mysqli->use_result();
            if( $rs instanceof \mysqli_result ) {
                $rs->free();
            }
        }
        //echo "<br>";
        $i++;
    }
    
    echo "Success!<br>";
    flush();
    
    require_once '../../admin/includes/managers/config_manager.php';
    saveConfigValue(ConfigNames::UpdateDate, date('Y-m-d H:i:s'), true);
    $_SESSION['successMessage'] = "Successfully Update RaspberryPints";
    
    echo "<script>window.location = '".$_SERVER['HTTP_REFERER']."'</script>";
}

if ($action == 'restore')
{
    echo "restore RaspberryPints...";
    flush();
    
    $dbms_schema = '../../sql/backups/'.$_POST["fileRestore"];
    $sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die("Cannot find SQL update file. ($dbms_schema)");
    
    $sql_query = remove_remarks($sql_query);
    $sql_query = remove_comments($sql_query);
    $sql_query = split_sql_file($sql_query, ';');
    
    $sql = "USE `" . $databasename . "`;";
    $result = $mysqli->query($sql);
    
    $i=1;
    foreach($sql_query as $sql){
        if(rtrim($sql) == "") continue;
        //echo "	";
        echo $sql;
        echo "<br>";
        $mysqli->query($sql) or die('error in query '.$i.'['.substr($sql,0,80).'] ['.$mysqli->error.']');
        //echo "<br>";
        $i++;
    }
    
    echo "Success!<br>";
    flush();
    
    $_SESSION['successMessage'] = "Successfully Restore RaspberryPints";    
    echo "<script>window.location = '".$_SERVER['HTTP_REFERER']."'</script>";
}
$mysqli->close();


if ($action == 'install')
{
	echo '<br /><br /><br /><h3> Congratulations! Your Raspberry Pints has been setup successfully.<br />';
	echo 'Click for - <a href="../../index.php">Tap List</a><br />';
	echo 'Click for - <a href="../../admin/index.php">Administration </a><br />';
}

?>
</body>
</html>