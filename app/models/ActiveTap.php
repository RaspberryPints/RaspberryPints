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


    public function BUGU(){
        $bugu = 0;
        if( $this->ogAct > 1 ){
            $bugu = number_format((($this->ibuAct)/(($this->ogAct-1)*1000)), 2, '.', '');
        }        
        return number_format($bugu, 2, '.', ''); 
    }

    public function Calories(){

        $calfromalc = (1881.22 * ($this->fgAct * ($this->ogAct - $this->fgAct)))/(1.775 - $this->ogAct);
        $calfromcarbs = 3550.0 * $this->fgAct * ((0.1808 * $this->ogAct) + (0.8192 * $this->fgAct) - 1.0004);
        if ( ($this->ogAct == 1) && ($this->fgAct == 1 ) ) {
            $calfromalc = 0;
            $calfromcarbs = 0;
        }
        return number_format($calfromalc + $calfromcarbs) ;
    }

    public function ABV(){
        return ($this->ogAct - $this->fgAct) * 131;
    }

    public function PercentRemaining(){
        return $this->remainAmount / $this->startLiter * 100;
    } 
}