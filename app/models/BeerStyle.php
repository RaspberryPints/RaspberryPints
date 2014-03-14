<?php

class BeerStyle extends Eloquent 
{

	protected $fillable = array(
		'name', 
		'catNum',
		'category',
		'ogMin',
		'ogMax',
		'fgMin',
		'fgMax',
		'srmMin',
		'srmMax',
		'ibuMin',
		'ibuMax'
	);
    protected $guarded = array('id');

	protected $table = 'beerStyles';
	
}