<?php

function db(){
	$link = mysql_connect("localhost", "root", "");
	mysql_select_db("kegerface");
}


?>
