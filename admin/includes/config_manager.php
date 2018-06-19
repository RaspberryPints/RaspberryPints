<?php

    require_once __DIR__.'/conn.php';
    require_once __DIR__.'/config_names.php';
	$stylesheet = getConfigValue(ConfigNames::AdminThemeColor);

	function getAllConfigs()
	{	
		global $mysqli;
		$config = array();
		$sql = "SELECT * FROM config";
		$qry = $mysqli->query($sql);
		while($c = $qry->fetch_array()){
			$config[$c['configName']] = $c['configValue'];
		}
		return $config;
	}
	function getConfigurableConfigs()
	{	
		global $mysqli;
		$config = array();
		$sql = "SELECT * FROM config WHERE showOnPanel = 1";
		return $mysqli->query($sql);
	}
	function getConfigValue($configName)
	{
		global $mysqli;
		$ret = null;
		$sql="SELECT configValue FROM config WHERE configName ='".$configName."'";
		$qry=$mysqli->query($sql);
		if($c = $qry->fetch_array()){
			$ret = $c['configValue'];
		}	
		return $ret;
	}

	function saveConfigValue($configName, $configValue)
	{
		global $mysqli;
		$sql="UPDATE config set configValue='".$configValue."', modifiedDate = NOW() WHERE configName ='".$configName."'";
		return $mysqli->query($sql);	
	}
?>