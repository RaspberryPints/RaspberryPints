<?php

class Batch extends Eloquent 
{
	protected $fillable = array(
		'beerId',
		'kegId',
		'ogAct',
		'fgAct',
		'srmAct',
		'ibuAct',
		'startKg',
		'startLiter'
	);
    protected $guarded = array(
    	'id'
    );

	public function Beer()
    {
        return $this->hasOne("Beer", "id", "beerId");
    }

    public function BeerName(){
        return $this->Beer->name;
    }

    public function Keg()
    {
        return $this->hasOne("Keg", "id", "kegId");
    }

    public function Tap()
    {
       return $this->belongsTo("Tap", "id", "batchId");
    }

    public static function GetAllActive(){
        $batches = Batch::where('active', 1)->get();

        $batches = $batches->sortBy(function($batch){
            return $batch->Beer->name;
        });

        return $batches;
    }
}