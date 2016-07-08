<?php

require_once('app/init.php');

try {
	if (isset($_GET['_p'])) {
		$curPage = strtolower(trim($_GET['_p']));
		$curPage = str_replace('/', '-', $curPage);
	} else {
		// Default to the home page
		$curPage = 'home';
	}
	
	// Load the controller
	if (is_file('app/controller/' . $curPage . '.controller.php')) {
		require_once('app/controller/' . $curPage . '.controller.php');
	} else {
		throw new RuntimeException("File not found.", 404);
	}
} catch (Exception $e) {
	
}
