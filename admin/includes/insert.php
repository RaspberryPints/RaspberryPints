<?
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require 'includes/config.php';

$sql="INSERT INTO beers (name, style, notes, og, fg , srm, ibu, active, tapnumber)
VALUES
('$_POST[name]','$_POST[style]','$_POST[notes]','$_POST[og]','$_POST[fg]','$_POST[srm]','$_POST[ibu]','$_POST[active]','$_POST[tapnumber]')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
{

header("location:../add_sucess.php");
}
?>
