<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require 'includes/config.php';

// get value of id that sent from address bar
$beerid=$_GET['beerid'];

// Retrieve data from database
$sql="SELECT * FROM $tbl_name WHERE beerid='$beerid'";
$result=mysql_query($sql);

$rows=mysql_fetch_array($result);
?>

<head>
<title>Beer List</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<table align="center">
<tr>
<form name="form1" method="post" action="push_update.php">
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center"><strong>Update Your Beers Information</strong> </td>
</tr>
<tr>
<td align="center">&nbsp;</td></tr>
<tr><td align="center"><strong>Tap Number</strong></td></tr>
<tr><td align="center"><input class="smallbox" name="tapnumber" type="text" id="tapnumber" value="<? echo $rows['tapnumber']; ?>"></td></tr>
<tr><td align="center"><strong>Name</strong></td></tr>
<tr><td align="center"><input class="mediumbox" name="name" type="text" id="name" value="<? echo $rows['name']; ?>"></td></tr>
<tr><td align="center"><strong>Style</strong></td></tr>
<tr><td align="center"><input class="mediumbox" name="style" type="text" id="style" value="<? echo $rows['style']; ?>"></td></tr>
<tr><td align="center"><strong>Notes</strong></td></tr>
<tr><td align="center"><textarea class="inputbox" name="notes" rows="5" cols="50"><? echo $rows['notes']; ?></textarea></td></tr>
<tr><td align="center"><strong>OG</strong></td> </tr>
<tr><td align="center"><input class="smallbox" name="og" type="text" id="og" value="<? echo $rows['og']; ?>"</td></tr>
<tr><td align="center"><strong>FG</strong></td></tr>
<tr><td align="center"><input class="smallbox" name="fg" type="text" id="fg" value="<? echo $rows['fg']; ?>"</td></tr>
<tr><td align="center"><strong>SRM</strong></td></tr>
<tr><td align="center"><input class="smallbox" name="srm" type="text" id="srm" value="<? echo $rows['srm']; ?>"></td></tr>
<tr><td align="center"><strong>IBU's</strong></td></tr>
<tr><td align="center"><input class="smallbox" name="ibu" type="text" id="ibu" value="<? echo $rows['ibu']; ?>"></td></tr>
<tr><td align="center"><strong>Active (1-Yes 2-No)</strong></td></tr>
<tr><td align="center"><input class="smallbox" name="active" type="text" id="active" value="<? echo $rows['active']; ?>" size="3"></td></tr>
<tr><td>
<input name="beerid" type="hidden" id="beerid" value="<? echo $rows['beerid']; ?>">
</td></tr>
<tr>
<td align="center">
<input type="submit" class="btn" name="Submit" value="Submit"> &nbsp <input type="button" class="btn"  onclick="window.history.back()" value="Go Back">
</td>
<td>&nbsp;</td>
</tr>
</table>
</td>
</form>
</tr>
</table>

<?php
// close connection
mysql_close();
?>