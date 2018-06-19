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

	function Save($brewery){
		// download the image so we have it locally
		if ($brewery->get_imageUrl() && filter_var($brewery->get_imageUrl(), FILTER_VALIDATE_URL) ) {
			$imagepath =  "../data/images/".uniqid("brewery-").".png";
			copy($brewery->get_imageUrl(), $imagepath);
			if( file_exists($imagepath) ) $brewery->set_imageUrl($imagepath);
		}
		return parent::Save($brewery);
	}
}
