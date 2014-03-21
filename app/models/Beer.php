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
		'active',
		'untID'
	);
    protected $guarded = array(
    	'id'
    );

	public function BeerStyle()
    {
        return $this->hasOne("BeerStyle", "id", "beerStyleId");
    }

    public static function GetAllActive(){
    	return Beer::where('active', 1)->orderBy('name')->get();
    }
}