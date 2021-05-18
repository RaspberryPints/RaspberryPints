<?php 
require_once __DIR__.'/../header.php';
require_once __DIR__.'/managers/beerStyle_manager.php';
$error=false; 
const MAX_SRM = 40.0;
//global $mysqli;

if(!isset($_FILES['uploaded']) || !isset($_FILES['uploaded']['size']) || !isset($_FILES['uploaded']['type']))
{
	echo "File not uploaded<br>";
	$error = true;
}
// //This is our size condition 
// if (!$error && $_FILES['uploaded']['size']> 10000) 
// { 
//   echo "Your file is too large.<br>"; 
//   $error = true; 
// } 

//This is our limit file type condition 
if (!$error && $_FILES['uploaded']['type']!="text/xml") 
{ 
  echo "Invalid file type ".$_FILES['uploaded']['type']."<br>"; 
  $error = true; 
} 

//Here we check that $ok was not set to 0 by an error 
if ($error) 
{ 
  echo "Sorry your file was not uploaded<br>"; 
} 

//If everything is ok we try to upload it 
else 
{ 
	$error = false;
    $xml=simplexml_load_file($_FILES['uploaded']['tmp_name']);
	if(!$xml){
		echo "Invalid XML<br>";
		$error = true;
	}
	$ii = 0;
	while ($xml && ($style = $xml->BEERSTYLE[$ii++]))
	{
		//$styleId = '';
		$catNum = $style->CATEGORY . ($style->LETTER?$style->LETTER:$style->STYLE_LETTER);
		$styleName = $style->NAME;

		$beerStyleManager = new BeerStyleManager();
		$beerStyle = $beerStyleManager->GetByNameOrCatNumInList($styleName, $catNum, $style->STYLE_GUIDE);
		if(!$beerStyle && $styleName != '' && $catNum != ''){
		    $beerStyle = new BeerStyle();
		    $beerStyle->set_category($style->CATEGORY);
		    $beerStyle->set_catNum($catNum);
		    $beerStyle->set_name($styleName);
		    $beerStyle->set_beerStyleList($style->STYLE_GUIDE);
		    $beerStyle->set_ogMin($style->OG_MIN);
		    $beerStyle->set_ogMinUnit(UnitsOfMeasure::GravitySG);
		    $beerStyle->set_ogMax($style->OG_MAX);
		    $beerStyle->set_ogMaxUnit(UnitsOfMeasure::GravitySG);
		    $beerStyle->set_fgMin($style->FG_MIN);
		    $beerStyle->set_fgMinUnit(UnitsOfMeasure::GravitySG);
		    $beerStyle->set_fgMax($style->FG_MAX);
		    $beerStyle->set_fgMaxUnit(UnitsOfMeasure::GravitySG);
		    $beerStyle->set_abvMin($style->ABV_MIN);
		    $beerStyle->set_abvMax($style->ABV_MAX);
		    $beerStyle->set_ibuMin($style->IBU_MIN);
		    $beerStyle->set_ibuMax($style->IBU_MAX);
		    $beerStyle->set_srmMin($style->COLOR_MIN);
		    $beerStyle->set_srmMax($style->COLOR_MAX);
		    
		    $beerStyleManager->Save($beerStyle);
		}		
    }
	if($error){
		echo '<a href="../beer_style_form_xml.php">Return to Upload Page</a><br />';
	}else{
		echo "<script>location.href='../beer_style_list.php';</script>";
	}
}

?> 
