<?php

class Tap extends Eloquent
{

	protected $fillable = array(
		'batchId',
		'name',
		'pinAddress',
		'pulsesPerLiter'
	);
    protected $guarded = array('id');

	public function Batch()
    {
        return $this->hasOne("Batch", "id", "batchId");
    }
}