<?php
class BeerManager{

	function getAllBeers(){
		$sql="SELECT * FROM beers";
		$qry = mysql_query($sql);
		
		$beers = array();
		while($b = mysql_fetch_array($qry)){
			$beer = array(
				"id" => $b['id'],
				"name" => $b['name'],
				"og" => $b['ogEst'],
				"fg" => $b['fgEst'],
				"srm" => $b['srmEst'],
				"ibu" => $b['ibuEst']
			);
			$beers[$b['id']] = $beer;
		}
		
		return $beers;
	}
}