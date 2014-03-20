<?php

class KegType extends Eloquent 
{

	protected $fillable = array(
		'name', 
		'maxLiters'		
	);
    protected $guarded = array('id');

	protected $table = 'kegTypes';
	
}