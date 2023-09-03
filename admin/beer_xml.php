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
foreach ($xml->RECIPE->FERMENTABLES->FERMENTABLE as $fermentable) {
   echo $fermentable->NAME;
}
echo '<br>';
foreach ($xml->RECIPE->HOPS->HOP as $hop) {
   echo $hop->NAME;
}
echo '<br>';
foreach ($xml->RECIPE->MISCS->MISC as $misc) {
   echo $misc->NAME;
}
echo '<br>';
foreach ($xml->RECIPE->YEASTS->YEAST as $yeast) {
   echo $yeast->NAME;
}
echo '<br>';
?> 
</table>
</BODY>
</HTML>