<?php



$sql="SELECT configValue FROM config WHERE configName ='".ConfigNames::AdminThemeColor."'";
			$result=mysql_query($sql);
			$stylesheet=mysql_fetch_array($result);
?>