<?php

class Tap extends Eloquent 
{

	protected $fillable = array(
		'batchId', 
		'pinAddress',
		'pulsesPerLiter'
	);
    protected $guarded = array('id');

	public function Batch()
    {
        return $this->hasOne("Batch", "id", "batchId");
    }
	

    public static function GetAllActive(){
    	return Tap::where('active', 1)->orderBy('tapNumber')->get();
    }
}