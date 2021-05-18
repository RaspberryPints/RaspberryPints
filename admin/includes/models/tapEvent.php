<?php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/hop.php';

class TapEvent
{
    private $_id;
    private $_type;
    private $_typeDesc;
    private $_tapId;
    private $_kegId;
    private $_beerId;
    private $_beerBatchId;
    private $_amount;
    private $_amountUnit;
    private $_beerBatchAmount;
    private $_beerBatchAmountUnit;
    private $_newAmount;
    private $_newAmountUnit;
    private $_userId;
    private $_userName;
    private $_tapNumber;
    private $_kegName;
    private $_beerName;
    private $_beerStyle;
    private $_tapRgba;
    private $_createdDate;
    private $_modifiedDate; 
        
    public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }
    
    public function get_type(){ return $this->_type; }
    public function set_type($_type){ $this->_type = $_type; }
    public function get_typeDesc(){ return $this->_typeDesc; }
    public function set_typeDesc($_typeDesc){ $this->_typeDesc = $_typeDesc; }
    
    public function get_tapId(){ return $this->_tapId; }
    public function set_tapId($_tapId){ $this->_tapId = $_tapId; }
    
    public function get_kegId(){ return $this->_kegId; }
    public function set_kegId($_kegId){ $this->_kegId = $_kegId; } 
    
    public function get_beerId(){ return $this->_beerId; }
    public function set_beerId($_beerId){ $this->_beerId = $_beerId; } 
    
    public function get_beerBatchId(){ return $this->_beerBatchId; }
    public function set_beerBatchId($_beerBatchId){ $this->_beerBatchId = $_beerBatchId; }     
    
    public function get_amount(){ return $this->_amount; }
    public function set_amount($_amount){ $this->_amount = $_amount; }
    public function get_beerBatchAmount(){ return $this->_beerBatchAmount; }
    public function set_beerBatchAmount($_beerBatchAmount){ $this->_beerBatchAmount = $_beerBatchAmount; }
    public function get_newAmount(){ return $this->_newAmount; }
    public function set_newAmount($_newAmount){ $this->_newAmount = $_newAmount; }
    
    public function get_amountUnit(){ return $this->_amountUnit; }
    public function set_amountUnit($_amountUnit){ $this->_amountUnit = $_amountUnit; }
    public function get_beerBatchAmountUnit(){ return $this->_beerBatchAmountUnit; }
    public function set_beerBatchAmountUnit($_beerBatchAmountUnit){ $this->_beerBatchAmountUnit = $_beerBatchAmountUnit; }
    public function get_newAmountUnit(){ return $this->_newAmountUnit; }
    public function set_newAmountUnit($_newAmountUnit){ $this->_newAmountUnit = $_newAmountUnit; }
    
    public function get_userId(){ return $this->_userId; }
    public function set_userId($_userId){ $this->_userId = $_userId; } 
    
    public function get_createdDate(){ return $this->_createdDate; }
    public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
    
    public function get_modifiedDate(){ return $this->_modifiedDate; }
    public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }
    
    //view only fields
    public function get_userName(){ return $this->_userName; }
    public function set_userName($_userName){ $this->_userName = $_userName; }
    public function get_tapNumber(){ return $this->_tapNumber; }
    public function set_tapNumber($_tapNumber){ $this->_tapNumber = $_tapNumber; }
    public function get_kegName(){ return $this->_kegName; }
    public function set_kegName($_kegName){ $this->_kegName = $_kegName; }
    public function get_beerName(){ return $this->_beerName; }
    public function set_beerName($_beerName){ $this->_beerName = $_beerName; }
    public function get_beerStyle(){ return $this->_beerStyle; }
    public function set_beerStyle($_beerStyle){ $this->_beerStyle = $_beerStyle; }
    public function get_tapRgba(){ return $this->_tapRgba; }
    public function set_tapRgba($_tapRgba){ $this->_tapRgba = $_tapRgba; }
    
    public function setFromArray($postArr)
    {
        if( isset($postArr['id']) )
            $this->set_id($postArr['id']);
        else
            $this->set_id(null);
            
        if( isset($postArr['type']) )
            $this->set_type($postArr['type']);
        else
            $this->set_type(null);
        if( isset($postArr['typeDesc']) )
            $this->set_typeDesc($postArr['typeDesc']);
        else
            $this->set_typeDesc(null);
        
        if( isset($postArr['tapId']) )
            $this->set_tapId($postArr['tapId']);
        else
            $this->set_tapId(null);
        
        if( isset($postArr['kegId']) )
            $this->set_kegId($postArr['kegId']);
        else
            $this->set_kegId(null);
        
        if( isset($postArr['beerId']) )
            $this->set_beerId($postArr['beerId']);
        else
            $this->set_beerId(null);            
            
        if( isset($postArr['amount']) )
            $this->set_amount($postArr['amount']);
        else
            $this->set_amount(null);         
            
        if( isset($postArr['beerBatchAmount']) )
            $this->set_beerBatchAmount($postArr['beerBatchAmount']);
        else
            $this->set_beerBatchAmount(null);
            
        if( isset($postArr['newAmount']) )
            $this->set_newAmount($postArr['newAmount']);
        else
            $this->set_newAmount(null);
            
        if( isset($postArr['amountUnit']) )
            $this->set_amountUnit($postArr['amountUnit']);
        else
            $this->set_amountUnit(null);
            
        if( isset($postArr['beerBatchAmountUnit']) )
            $this->set_beerBatchAmountUnit($postArr['beerBatchAmountUnit']);
        else
            $this->set_beerBatchAmountUnit(null);
            
        if( isset($postArr['newAmountUnit']) )
            $this->set_newAmountUnit($postArr['newAmountUnit']);
        else
            $this->set_newAmountUnit(null);
            
        if( isset($postArr['userId']) )
            $this->set_userId($postArr['userId']);
        else
            $this->set_userId(null);  
        
        if( isset($postArr['createdDate']) )
            $this->set_createdDate($postArr['createdDate']);
        else
            $this->set_createdDate(null);
            
        if( isset($postArr['modifiedDate']) )
            $this->set_modifiedDate($postArr['modifiedDate']);
        else
            $this->set_modifiedDate(null);
        
        //view only fields
        if( isset($postArr['userName']) )
            $this->set_userName($postArr['userName']);
        else
            $this->set_userName(null);
        if( isset($postArr['tapNumber']) )
            $this->set_tapNumber($postArr['tapNumber']);
        else
            $this->set_tapNumber(null);
        if( isset($postArr['kegName']) )
            $this->set_kegName($postArr['kegName']);
        else
            $this->set_kegName(null);
        if( isset($postArr['beerName']) )
            $this->set_beerName($postArr['beerName']);
        else
            $this->set_beerName(null);
        if( isset($postArr['beerStyle']) )
            $this->set_beerStyle($postArr['beerStyle']);
        else
            $this->set_beerStyle(null);	
        if( isset($postArr['tapRgba']) )
            $this->set_tapRgba($postArr['tapRgba']);
        else
            $this->set_tapRgba(null);	
    }
    
    function toJson(){
        return "{" .
            "id: "     . $this->get_id()     . ", " .
            "type: "   . $this->get_type()   . ", " .
            "tapId: "  . $this->get_tapId()  . ", " .
            "kegId: "  . $this->get_kegId()  . ", " .
            "beerId: " . $this->get_beerId() . ", " .
            "beerBatchId: " . $this->get_beerBatchId() . ", " .
            "amount: " . $this->get_amount() . ", " .
            "amountUnit: " . $this->get_amountUnit() . ", " .
            "userId: " . $this->get_userId() . " " .
            "}";
    }
}