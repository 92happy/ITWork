<?php
	$mysqli = new mysqli("localhost","root","xyz789","itwork");
	if (!$mysqli){
		printf("Message:",mysql_connect_error());
		exit;
		} 
	$mysqli->query("SET NAMES 'utf8'");