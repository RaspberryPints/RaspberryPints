<?php 
require_once __DIR__.'/../header.php';
require_once __DIR__.'/managers/brewery_manager.php';
require_once __DIR__.'/managers/fermentable_manager.php';
require_once __DIR__.'/managers/hop_manager.php';
require_once __DIR__.'/managers/yeast_manager.php';
require_once __DIR__.'/managers/beerFermentable_manager.php';
require_once __DIR__.'/managers/beerHop_manager.php';
require_once __DIR__.'/managers/beerYeast_manager.php';
require_once __DIR__.'/managers/beerStyle_manager.php';
$beerManger = new BeerManager();
$breweryManager = new BreweryManager();
$error=false; 
global $mysqli;

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
	while ($xml && ($recipe = $xml->RECIPE[$ii++]))
	{
		$styleId = '';
		$catNum = $recipe->STYLE->CATEGORY . $recipe->STYLE->LETTER;
		$styleName = $recipe->STYLE->NAME;

		$beerStyleManager = new BeerStyleManager();
		$beerStyle = $beerStyleManager->GetByNameOrCatNum($styleName, $catNum);
		if(!$beerStyle){
		    $beerStyle = new BeerStyle();
		    $beerStyle->set_category($recipe->STYLE->CATEGORY);
		    $beerStyle->set_catNum($_catNum)($catNum);
		    $beerStyle->set_name($styleName);
		    $beerStyle->set_($styleName);
		    $beerStyle->set_ogMin($recipe->STYLE->OG_MIN);
		    $beerStyle->set_ogMax($recipe->STYLE->OG_MAX);
		    $beerStyle->set_fgMin($recipe->STYLE->FG_MIN);
		    $beerStyle->set_fgMax($recipe->STYLE->FG_MAX);
		    $beerStyle->set_abvMin($recipe->STYLE->ABV_MIN);
		    $beerStyle->set_abvMax($recipe->STYLE->ABV_MAX);
		    $beerStyle->set_ibuMin($recipe->STYLE->IBU_MIN);
		    $beerStyle->set_ibuMax($recipe->STYLE->IBU_MAX);
		    $beerStyle->set_srmMin($recipe->STYLE->COLOR_MIN);
		    $beerStyle->set_srmMax($recipe->STYLE->COLOR_MAX);
		    $beerStyle->set_beerStyleList($recipe->STYLE->STYLE_GUIDE);
		    
		    $beerStyleManager->Save($beerStyle);
		}
		$brewery = null;
		if($recipe->BREWERY && $recipe->BREWERY != ''){
		  $brewery = $breweryManager->GetOrAdd($recipe->BREWERY, '');
		}
		
		$beer = new Beer();
		$beer->set_name($recipe->NAME);
		if($beerStyle)$beer->set_beerStyleId($beerStyle->get_id());
		$beer->set_abv(preg_replace("/[^0-9|.]/", "", $recipe->ABV));
		$beer->set_og(preg_replace("/[^0-9|.]/", "", $recipe->OG));
		$beer->set_fg(preg_replace("/[^0-9|.]/", "", $recipe->FG));
		$beer->set_srm(preg_replace("/[^0-9|.]/", "", ($recipe->SRM?$recipe->SRM:$recipe->EST_COLOR)));
		$beer->set_ibu(preg_replace("/[^0-9|.]/", "", $recipe->IBU));
		$beer->set_notes($recipe->NOTES);
		if(!$beer->get_notes() || $beer->get_notes() == '')$beer->set_notes($recipe->TASTE_NOTES);
		$beer->set_untID($recipe->UNTAPPEDID);
		$beer->set_rating(preg_replace("/[^0-9|.]/", "", $recipe->RATING));
		if($brewery)$beer->set_breweryId($brewery->get_id());
			  
		  if (!$beerManger->save($beer))
		  {
			echo "Error - file not uploaded: Beer not saved. <br>";
			$error = true;
		  }
		  else
		  {
            $beerId = $mysqli->insert_id;
            if(!$beerId){
            	echo "Error - file not uploaded: Beer not found after insert. <br>";
            	$error = true;
            }
            $fermManager = new FermentableManager();
            $hopManager = new HopManager();
            $yeastManager = new YeastManager();
            $beerFermManager = new BeerFermentableManager();
            $beerHopManager = new BeerHopManager();
            $beerYeastManager = new BeerYeastManager();
            
            foreach ($recipe->FERMENTABLES->FERMENTABLE as $fermentable) 
            {
              $dbFerm = $fermManager->GetByName($fermentable->NAME);
              if(!$dbFerm){
                  $dbFerm = new Fermentable();
                  $dbFerm->set_name($fermentable->NAME);
                  $dbFerm->set_srm($fermentable->COLOR);
                  $dbFerm->set_notes($fermentable->NOTES);
                  $dbFerm->set_type($fermentable->TYPE);
                 
                  $fermManager->Save($dbFerm);
              }
              
              $beerFerm = new BeerFermentable();
              $beerFerm->set_beerID($beerId);
              $beerFerm->set_fermentable($dbFerm);
              $beerFerm->set_amount($fermentable->DISPLAY_AMOUNT);
              $beerFermManager->Save($beerFerm);			  
            }
	
            $hops[] = $hop->NAME;
            foreach ($recipe->HOPS->HOP as $hop)
            {
              $dbHop = $hopManager->GetByName($hop->NAME);
              if(!$dbHop){
                  $dbHop = new Hop();
                  $dbHop->set_name($hop->NAME);
                  $dbHop->set_alpha($hop->ALPHA);
                  $dbHop->set_beta($hop->BETA);
                  $dbHop->set_notes($hop->NOTES);
                  
                  $hopManager->Save($dbHop);
              }
              
              $beerHop = new BeerHop();
              $beerHop->set_beerID($beerId);
              $beerHop->set_hop($dbHop);
              $beerHop->set_amount($hop->DISPLAY_AMOUNT);
              $beerHop->set_time($hop->DISPLAY_TIME);
              $beerHopManager->Save($beerHop);
            }
            
            foreach ($recipe->YEASTS->YEAST as $yeast)
            {
              $dbYeast = $yeastManager->GetByName($yeast->NAME);
              if(!$dbYeast){
                  $dbYeast = new Yeast();
                  $dbYeast->set_name($yeast->NAME);
                  $dbYeast->set_format($yeast->FORM);
                  $dbYeast->set_notes($yeast->NOTES.' - Best For:'.$yeast->BEST_FOR);
                  $dbYeast->set_minAttenuation(preg_replace("/[^0-9|.]/", "", $yeast->ATTENUATION));
                  $dbYeast->set_maxAttenuation(preg_replace("/[^0-9|.]/", "", $yeast->ATTENUATION));
                  $dbYeast->set_flocculation(preg_replace("/[^0-9|.]/", "", $yeast->FLOCCULATION));
                  $dbYeast->set_minTemp(preg_replace("/[^0-9|.]/", "", $yeast->MIN_TEMPERATURE));
                  $dbYeast->set_maxTemp(preg_replace("/[^0-9|.]/", "", $yeast->MAX_TEMPERATURE));
                  
                  $yeastManager->Save($dbYeast);
              }
              $beerYeast = new BeerYeast();
              $beerYeast->set_beerID($beerId);
              $beerYeast->set_yeast($dbYeast);
              $beerYeast->set_amount($yeast->DISPLAY_AMOUNT);
              $beerYeastManager->Save($beerYeast);
            }
		  }
		
    }
	if($error){
		echo '<a href="../beer_form_xml.php">Return to Upload Page</a><br />';
	}else{
		echo "<script>location.href='../beer_list.php';</script>";
	}
}

?> 
