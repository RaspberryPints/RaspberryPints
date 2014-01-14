 <?php
 $host="localhost"; // Host name
$username="TapList45"; // Mysql username
$password=""; // Mysql password
$db_name="TapList45"; // Database name
$tbl_name="Users";


//Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect to server");
mysql_select_db("$db_name")or die("cannot select DB");

?>