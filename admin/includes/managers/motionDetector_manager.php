<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/config_manager.php';
require_once __DIR__.'/../models/motionDetector.php';

class MotionDetectorManager extends Manager{
    
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["name", "type", "pin", "priority"];
    }
    protected function getTableName(){
        return "motionDetectors";
    }
    protected function getDBObject(){
        return new MotionDetector();
    }
}
