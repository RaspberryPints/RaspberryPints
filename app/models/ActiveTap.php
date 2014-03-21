<?php

class ActiveTap extends Eloquent 
{
	
    protected $guarded = array(
    	'id',
    	'name',
    	'style',
        'notes',
        'ogAct',
        'fgAct',
        'srmAct',
        'ibuAct',
        'startAmount',
        'amountPoured',
        'remainAmount',
        'tapNumber',
        'srmRgb',
		'untID'
    );
    
	protected $table = 'vwGetActiveTaps';


    public static function PickByTapNumber($taps, $tapNumber){
        foreach ($taps as $tap) {
            if( $tap->tapNumber == $tapNumber ){
                return $tap;
            }
        }

        return null;
    }

}