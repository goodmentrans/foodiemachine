<?php
include 'session_settings.php';

//$url = "https://www.zomato.com/vancouver/restaurants";
$url = "http://localhost/test_zomato_listing.html";

/* LOAD HTTPS HTML FILE USING CURL */
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$returned_content = curl_exec($ch);
curl_close($ch);
//echo "<pre>returned content: <br /><br />" . htmlspecialchars($returned_content) . "</pre><br />";

//$error = substr($returned_content, 2, 5);
//echo $error;

/* LOAD HTTPS HTML FILE USING FILE_GET_CONTENTS */
//$returned_content = file_get_contents($url);

// echo strlen($returned_content);

$dom = new DOMDocument();
@$dom->loadHTML($returned_content);

$restaurant_list = $dom;
//print_r($restaurant_list);
$xpath = new DOMXPath($restaurant_list);
/*
$nodes_id = $xpath->query("//div[@id='orig-search-list']/div[@class='card search-snippet-card  search-card ']/div/div");
foreach ($nodes_id as $i => $node) {
	//echo "<pre>" . htmlspecialchars($node->ownerDocument->saveXML($node)) . "</pre>";
	//print_r($node->getAttribute('data-res_id'));
	//echo "<br /><br />";
}
*/

$nodes = $xpath->query("//div[@id='orig-search-list']/div[@class='card search-snippet-card  search-card ']/div/div/article/div/div/div/div/div/a[@class='result-title hover_feedback zred bold ln24   fontsize0 ']");
foreach ($nodes as $i => $node) {
	//echo "<pre>" . htmlspecialchars($node->ownerDocument->saveXML($node)) . "</pre>";
	print_r($node->nodeValue . "<br />" . $node->getAttribute('href'));
	//print_r($node->parentNode->parentNode->parentNode->parentNode->parentNode->parentNode->parentNode);
	$parent_id = $node->parentNode->parentNode->parentNode->parentNode->parentNode->parentNode->parentNode->getAttribute('data-res_id');
	echo $parent_id;
	//echo "<pre>" . htmlspecialchars($parent->ownerDocument->saveXML($parent)) . "</pre>";
	echo "<br /><br />";
}

/*
foreach ($restaurant_list->childNodes as $node) {
	echo "hello";
	$array[] = $node;
}
print_r($array);
*/
/*
$restaurant_list = $dom->getElementById('orig-search-list')->getElementsByTagName('div');
foreach ($restaurant_list as $node) {
	print_r($node);
	echo "<br /><br />";
	}
*/
//print_r($restaurant_list);

//echo "<pre>restaurant list: <br /><br />" . htmlspecialchars($restaurant_list) . "</pre><br />";

// "card search-snippet-card  search-card "
// "orig-search-list"

//echo "<pre>returned content: <br /><br />" . htmlspecialchars($returned_content) . "</pre><br />";

$templateFields = array();

displayTemplate('home', $templateFields);
//displayTemplate('footer');