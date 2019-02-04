<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/brewery.php';

class BreweryManager extends Manager{
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["name", "imageUrl"];
	}
	protected function getTableName(){
		return "breweries";
	}
	protected function getDBObject(){
		return new Brewery();
	}
	protected function getActiveColumnName(){
		return "active";
	}	
	protected function hasModifiedColumn(){return false;}
	protected function hasCreatedColumn(){return false;}

	function Save(&$brewery, $new=false){
		// download the image so we have it locally
		if ($brewery->get_imageUrl() && filter_var($brewery->get_imageUrl(), FILTER_VALIDATE_URL) ) {
			$imagepath =  __DIR__."../../includes/cache/img/".uniqid("brewery-").".png";
			copy($brewery->get_imageUrl(), $imagepath);
			if( file_exists($imagepath) ) $brewery->set_imageUrl($imagepath);
		}
		return parent::Save($brewery, $new);
	}
	
	function GetOrAdd($name, $url){
	    $brewery = null;
	    if(($brewery = $this->getByName($name))) {
	        return $brewery;
	    }elseif(($brewery = $this->getByURL($url))){
	        return $brewery;
	    }
	        
        $brewery = new Brewery();
        $brewery->set_name($name);
        $brewery->set_imageUrl($url);
        $this->Save($brewery);
        
        $brewery = $this->getByName($name);
    
	    
	    return $brewery;
	}
	function getByName($name){
	    global $mysqli;
	    $sql="SELECT * FROM ".$this->getViewName()." WHERE name = '".$mysqli->escape_string($name)."' ".$this->getOrderByClause();
	    $results = $this->executeQueryWithResults($sql);
	    if( $results && count($results) > 0 ) return array_values($results)[0];
	    return null;	    
	}
	function getByURL($url){
	    global $mysqli;
	    $sql="SELECT * FROM ".$this->getViewName()." WHERE imageUrl = '".$mysqli->escape_string($url)."' ".$this->getOrderByClause();
	    $results = $this->executeQueryWithResults($sql);
	    if( $results && count($results) > 0 ) return array_values($results)[0];
	    return null;	    
	}
}
