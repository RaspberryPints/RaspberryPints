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

	public static function GetByName($configName)
    {
 		return Option::where('configName', $configName)->first(); 		
    }
	

	public static function AllAsFlatten(){
		$options = Option::all();
		return Option::FlattenArray($options);
	}

	public static function FlattenArray($options){
		foreach ($options as $option) {
			$result[$option->configName] = $option->configValue;
		}
		return $result;
	}
}