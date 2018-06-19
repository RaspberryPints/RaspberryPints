<?php 
require_once __DIR__.'/../header.php';
require_once __DIR__.'/managers/brewery_manager.php';
$beerManger = new BeerManager();
$breweryManager = new BreweryManager();
$error=false; 
global $mysqli;

if(!isset($_FILES['uploaded']) || !isset($_FILES['uploaded']['size']) || !isset($_FILES['uploaded']['type']))
{
	echo "File not uploaded<br>";
	$error = true;
}
//This is our size condition 
if (!$error && $_FILES['uploaded']['size']> 10000) 
{ 
  echo "Your file is too large.<br>"; 
  $error = true; 
} 

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
		$sql = "SELECT id from beerStyles where name='" . $recipe->STYLE->NAME . "' and catNum='" . $catNum . "';";
		$qry = $mysqli->query($sql);
		if( $qry && $i = $qry->fetch_array() ) $styleId = $i[0];
		if ($styleId == '')
		{
		  $sql = "SELECT id from beerStyles where name='" . $styleName . "';";
		  $qry = $mysqli->query($sql);
		  if( $qry && $i = $qry->fetch_array() ) $styleId = $i[0];
		}
		if ($styleId == '')
		{
		  $sql = "SELECT id from beerStyles where catNum='" . $catNum . "';";
		  $qry = $mysqli->query($sql);
		  if( $qry && $i = $qry->fetch_array() ) $styleId = $i[0];
		}
		
		$brewery = $breweryManager->GetByName($recipe->BREWERY);
	
		if ($styleId == '')
		{
		  echo "Error - file not uploaded: Beer Style '" . $catNum . " - " . $styleName . "' not found. <br>";
		  $error = true;
		}
		else
		{
			$beer = new Beer();
			$beer->set_name($recipe->NAME);
			$beer->set_beerStyleId($styleId);
			$beer->set_abv($recipe->ABV);
			$beer->set_og($recipe->OG);
			$beer->set_fg($recipe->FG);
			$beer->set_srm($recipe->SRM);
			$beer->set_ibu($recipe->IBU);
			$beer->set_notes($recipe->NOTES);
			$beer->set_untID($recipe->UNTAPPEDID);
			$beer->set_rating($recipe->RATING);
			if($brewery)$beer->set_breweryId($brewery->get_id());
			  
		  if (!$beerManger->save($beer))
		  {
			echo "Error - file not uploaded: Beer not saved. <br>";
			$error = true;
		  }
		  else
		  {
			$qry = $mysqli->query('select LAST_INSERT_ID()');
			if( $qry && $i = $qry->fetch_array() ){		
				$beerId = $i[0];
			}else{
		  		echo "Error - file not uploaded: Beer not found after insert. <br>";
				$error = true;
		  	}
			$fermentables = array();
			$amounts = array();
			foreach ($recipe->FERMENTABLES->FERMENTABLE as $fermentable) 
			{
			  $fermentables[] = $fermentable->NAME;
			  $amounts[] = $fermentable->AMOUNT;
			}
	
			arsort($fermentables, SORT_NUMERIC);
	
			foreach ($fermentables as $fermentable) 
			{
			  $sql = "";
			  $sql = "INSERT INTO fermentables(name, beerId, createdDate, modifiedDate) " .
				  "VALUES('$fermentable', $beerId, NOW(), NOW());" ;
			   //echo $sql ; exit;
			  $qry = $mysqli->query($sql);
			}
	
			$hops = array();
			foreach ($recipe->HOPS->HOP as $hop) 
			{
			  $hops[] = $hop->NAME;
			}	
			$hops = array_unique($hops);
			foreach($hops as $hop)
			{
			  $sql = "";
			  $sql = "INSERT INTO hops(name, beerId, createdDate, modifiedDate) " .
				  "VALUES('$hop', $beerId, NOW(), NOW());" ;
			   //echo $sql ; exit;
			  $qry = $mysqli->query($sql);
			}
	
			$yeasts = array();
			foreach ($recipe->YEASTS->YEAST as $yeast) 
			{
			  $yeasts[] = $yeast->NAME;
			}	
			$yeasts = array_unique($yeasts);
			foreach($yeasts as $yeast)
			{
			  $sql = "";
			  $sql = "INSERT INTO yeasts(name, beerId, createdDate, modifiedDate) " .
				  "VALUES( '$yeast', $beerId, NOW(), NOW());" ;
			   //echo $sql ; exit;
			  $qry = $mysqli->query($sql);
			}
		  }
		}
    }
	if($error){
		echo 'Return to <a href="../beer_form_xml.php">Try Again</a><br />';
	}else{
		echo "<script>location.href='../beer_list.php';</script>";
	}
}

?> 
