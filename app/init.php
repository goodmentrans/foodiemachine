<?php

// Set up include path to search our lib, controller, and view folders
$_appPath = realpath(dirname(__FILE__));

set_include_path($_appPath . PATH_SEPARATOR . 
				 $_appPath . '/lib' . PATH_SEPARATOR . 
				 $_appPath . '/controller' . PATH_SEPARATOR .
				 get_include_path());

require_once('common.inc.php');

// Load up our configuration files
$_config = initConfig();

// Set up DB connection
$_db = initDB();

$_serverpath = $GLOBALS['_config']['serverpath'];