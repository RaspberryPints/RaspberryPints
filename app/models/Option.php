<?php

class Option extends Eloquent 
{
	protected $fillable = array(
		'configName',
		'configValue',
		'displayName',
		'showOnPanel'
	);
    protected $guarded = array('id');

	protected $table = 'config';
	
}