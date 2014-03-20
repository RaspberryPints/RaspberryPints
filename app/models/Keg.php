<?php

class Keg extends Eloquent 
{
	protected $fillable = array(
		'label',
		'kegTypeId',
		'make',
		'model',
		'serial',
		'stampedOwner',
		'stampedLoc',
		'notes',
		'kegStatusCode',
		'weight',
		'active'
	);


    protected $guarded = array(
    	'id'
    );


	public function KegType()
    {
        return $this->hasOne("KegType", "id", "kegTypeId");
    }
/*    
    public function KegStatus()
    {
        return $this->hasOne("KegStatus", "code", "kegStatusCode");
    }
*/
    public static function GetAllActive(){
    	return Keg::where('active', 1)->orderBy('label')->get();
    }
}