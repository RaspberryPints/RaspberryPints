<?php

class Beer extends Eloquent 
{
	protected $fillable = array(
		'name',
		'beerStyleId',
		'notes',
		'ogEst',
		'fgEst',
		'srmEst',
		'ibuEst',
		'active'
	);
    protected $guarded = array(
    	'id'
    );

	public function BeerStyle()
    {
        return $this->hasOne("BeerStyle", "id", "beerStyleId");
    }
}