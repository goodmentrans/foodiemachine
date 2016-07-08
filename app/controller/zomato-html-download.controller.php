<?php
include 'session_settings.php';

$pagecount = 1;
$finalcount = 3;

$listing_url = "https://www.zomato.com/vancouver/restaurants?page=";
//$listing_url = "http://localhost/test_zomato_listing.html";

while ($pagecount <= $finalcount AND $pagecount <= 1000) {
	$pageurl = $listing_url . $pagecount;

	// LOAD HTTPS HTML FILE USING CURL
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $pageurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$returned_content = curl_exec($ch);
	curl_close($ch);

	$error = substr($returned_content, 2, 5);
	echo $error;

	// LOAD HTTPS HTML FILE USING FILE_GET_CONTENTS
	//$returned_content = file_get_contents($url);

	// echo strlen($returned_content);

	$dom = new DOMDocument();
	@$dom->loadHTML($returned_content);

	$restaurant_list = $dom;
	$xpath = new DOMXPath($restaurant_list);

	$initial_query ="//div[@id='orig-search-list']/div[@class='card search-snippet-card  search-card ']/div/div";
	$nodes = $xpath->query($initial_query);

	foreach ($nodes as $i => $node) {
		//print_r($node);
		$id = $node->getAttribute('data-res_id');
	
		$nodes2 = $xpath->query($initial_query . "[@data-res_id='" . $id ."']/article/div/div/div/div/div/a[@class='result-title hover_feedback zred bold ln24   fontsize0 ']");
	
		$url = $nodes2->item(0)->getAttribute('href');
		$name = $nodes2->item(0)->nodeValue;
		echo $id, " ", $name, " ", $url, "<br />";
	}
	$pagecount++;
}

$templateFields = array();

displayTemplate('home', $templateFields);
//displayTemplate('footer');