<?php

class Beer extends Eloquent 
{
	protected $fillable = array('id', 'name', 'beerStyleId', 'notes','ogEst','fgEst','srmEst','ibuEst','active');

	public function BeerStyle()
    {
        return $this->hasOne("BeerStyle", "id", "beerStyleId");
    }
}