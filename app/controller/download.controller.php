<?php
include 'session_settings.php';

function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

$returned_content = get_data('https://www.zomato.com/vancouver/restaurants');

echo "<pre>" . $returned_content . "</pre>";

$templateFields = array();

displayTemplate('home', $templateFields);
//displayTemplate('footer');