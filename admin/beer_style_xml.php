<head></head>
<body>
<html>
<table>
<?php
$xml=simplexml_load_file("C:\Users\sloescher\Desktop\wheat.xml");
echo '<tr><td>Name</td><td>' . $xml->RECIPE[0]->NAME . "</td></tr>";
echo '<tr><td>Style</td><td>' . $xml->RECIPE[0]->STYLE[0]->NAME . "</td></tr>";
echo '<tr><td>Style Cat</td><td>' . $xml->RECIPE[0]->STYLE[0]->CATEGORY . "</td></tr>";
echo '<tr><td>Style Num</td><td>' . $xml->RECIPE[0]->STYLE[0]->CATEGORY_NUMBER . "</td></tr>";
echo '<tr><td>Style Letter</td><td>' . $xml->RECIPE[0]->STYLE[0]->STYLE_LETTER . "</td></tr>";
echo '</table>';
?> 
</table>
</BODY>
</HTML>