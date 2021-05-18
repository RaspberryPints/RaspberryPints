<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/tap_manager.php';
require_once __DIR__.'/fermentable_manager.php';
require_once __DIR__.'/hop_manager.php';
require_once __DIR__.'/yeast_manager.php';
require_once __DIR__.'/accolade_manager.php';
require_once __DIR__.'/../models/beer.php';

class BeerManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["name", "untID", "beerStyleId", "breweryId", "notes", "abv", "og", "ogUnit", "fg", "fgUnit", "srm", "ibu", "rating", "active", "containerId"];
	}
	protected function getTableName(){
		return "beers";
	}
	protected function getDBObject(){
		return new Beer();
	}	
	protected function getActiveColumnName(){
		return "active";
	}	
	function Inactivate($id){
		$tapManager = new TapManager();
		$tap = $tapManager->GetByBeerId($id);
		
		if( $tap ){		
			$_SESSION['errorMessage'] = "Beer is associated with an active tap and could not be deleted.";
			return;
		}
		parent::Inactivate($id);
	}

	protected function getOrderByClause(){
		return "ORDER BY name";
	}

  function GetFermentables($id){
	$manager = new FermentableManager();
	return $manager->GetDistinctForBeer($id);
  }

  function GetHops($id){
	$manager = new HopManager();
	return $manager->GetDistinctForBeer($id);
  }

  function GetYeasts($id){
	$manager = new yeastManager();
	return $manager->GetDistinctForBeer($id);
  }
  
  private static function cmpBeer($a, $b) {
      return strcmp($a->get_displayName(), $b->get_displayName());
  }
  function GetAllWithBatches(){
      $beerList = $this->GetAll();
      
      $beerBatchList = (new BeerBatchManager())->GetAll();
      if( count($beerBatchList) > 0){
          $beerList = array_merge($beerList, $beerBatchList );
          uasort($beerList, array('BeerManager','cmpBeer'));
      }
      return $beerList;
  }
  
  function GetAllActiveWithBatches(){
      $beerList = $this->GetAllActive();
      
      $beerBatchList = (new BeerBatchManager())->GetAllActiveWithRemaining();
      if( count($beerBatchList) > 0){
          $beerList = array_merge($beerList, $beerBatchList );
          uasort($beerList, array('BeerManager','cmpBeer'));
      }
      return $beerList;
  }
  function GetAllActiveWithLastBatchId(){
      if($this->getActiveColumnName()){
          $sql="SELECT *, (select COALESCE(max(batchNumber),0) from ".(new BeerBatchManager())->getViewName()." where beerid = b.id) AS lastBatchNumber FROM ".$this->getViewName()." b WHERE ".$this->getActiveColumnName()." = 1 ".$this->getOrderByClause();
          return $this->executeQueryWithResults($sql);
      }
      return $this->GetAll();
  }
  
}
