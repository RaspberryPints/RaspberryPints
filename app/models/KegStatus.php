<?php

class KegStatus extends Eloquent 
{
    protected $guarded = array('code', 'name');

	protected $table = 'kegStatuses';	
}