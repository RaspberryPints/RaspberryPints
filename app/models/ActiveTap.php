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
        'srmRgb'
    );
    
	protected $table = 'vwgetactivetaps';

}