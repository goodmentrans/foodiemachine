<?php

function displayTemplate($templateName, array $fields = array()) {
	if (is_file('app/view/' . $templateName . '.view.php')) {
		extract($fields, EXTR_OVERWRITE);
		require('app/view/' . $templateName . '.view.php');
	} else {
		throw new RuntimeException("Unable to load template $templateName");
	}
}

function initConfig() {
	$config = array();
	
	// Start with the app-wide config file, the layer on local config file (if it exists)
	include('config/app.conf.php');
	
	if (is_file($GLOBALS['_appPath'] . '/config/app-local.conf.php')) {
		$originalConfig = $config;
		include('config/app-local.conf.php');
		
		$config = array_merge($originalConfig, $config);
	}
	
	return $config;
}

function initDB() {
	$db = new PDO('mysql:host=' . $GLOBALS['_config']['db']['host'] . ';port=' . $GLOBALS['_config']['db']['port'] . ';dbname=' . $GLOBALS['_config']['db']['name'] . ';charset=utf8', $GLOBALS['_config']['db']['user'], $GLOBALS['_config']['db']['pass'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	return $db;
}