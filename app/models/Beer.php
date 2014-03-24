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

    public static function GetAllActive($includeId = null){
    	return Beer::where('active', 1)->orderBy('name')->get();
    }
}