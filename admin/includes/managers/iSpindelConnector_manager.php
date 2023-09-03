<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/iSpindelConnector.php';

class iSpindelConnectorManager extends Manager{
    
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["id", "address", "port", "allowedConnections"];
    }
    protected function getTableName(){
        return "iSpindel_Connector";
    }
    protected function getDBObject(){
        return new iSpindelConnector();
    }
}
