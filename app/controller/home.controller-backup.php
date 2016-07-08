<?php
include 'session_settings.php';

// FETCH ZOMATO API KEY
$fetch_api_key_sql = "SELECT value FROM configuration WHERE type = 'zomato_api_key'";
$get_results = $GLOBALS['_db']->prepare($fetch_api_key_sql);
$get_results->execute(array());
$fetch_api_key_result = $get_results->fetch(PDO::FETCH_ASSOC);
$zomato_api_key = $fetch_api_key_result['value'];

// CURL REQUEST FUNCTION
function curl_get_contents($url, $request_headers)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

// ZOMATO CITY ID FOR VANCOUVER
$city_id = 256;

// SETS SEARCH REQUEST OPTIONS
$data = array(
	'entity_id' => $city_id,
	'entity_type' => 'city',
	'order' => 'asc'
	);
$postString = http_build_query($data, '', '&');

// SETS DEFAULT ZOMATO HEADERS, INCLUDING API KEY
$zomato_request_headers = array();
$zomato_request_headers[] = 'Accept: application/json';
$zomato_request_headers[] = 'user-key: ' . $zomato_api_key;
$zomato_request_url = "https://developers.zomato.com/api/v2.1/search?" . $postString;

// EXECUTES THE CURL REQUEST
$result = curl_get_contents($zomato_request_url, $zomato_request_headers);
$result_array = json_decode($result,TRUE);

$total_results = $result_array['results_found'];

// FOR LOOP TO REQUEST ALL RESTAURANTS
for ($start = 0; $start < $total_results; $start = $start + 20) {
	echo $start . '<br />';
/*
	// SETS SEARCH REQUEST OPTIONS
	$data = array(
		'entity_id' => $city_id,
		'start' => $start,
		'entity_type' => 'city',
		'order' => 'asc'
		);
	$postString = http_build_query($data, '', '&');

	// SETS DEFAULT ZOMATO HEADERS, INCLUDING API KEY
	$zomato_request_headers = array();
	$zomato_request_headers[] = 'Accept: application/json';
	$zomato_request_headers[] = 'user-key: ' . $zomato_api_key;
	$zomato_request_url = "https://developers.zomato.com/api/v2.1/search?" . $postString;

	// EXECUTES THE CURL REQUEST
	$result = curl_get_contents($zomato_request_url, $zomato_request_headers);

	$restaurants_parse_list = $result_array['restaurants'];

	for ($i = 0; $i < count($restaurants_parse_list); $i++) {
		$id = $restaurants_parse_list[$i]['restaurant']['id'];
		$name = $restaurants_parse_list[$i]['restaurant']['name'];
		$url = $restaurants_parse_list[$i]['restaurant']['url'];
		$address = $restaurants_parse_list[$i]['restaurant']['location']['address'];
		$locality = $restaurants_parse_list[$i]['restaurant']['location']['locality'];
		$city = $restaurants_parse_list[$i]['restaurant']['location']['city'];
		$city_id = $restaurants_parse_list[$i]['restaurant']['location']['city_id'];
		$latitude = $restaurants_parse_list[$i]['restaurant']['location']['latitude'];
		$longitude = $restaurants_parse_list[$i]['restaurant']['location']['longitude'];
		$zipcode = $restaurants_parse_list[$i]['restaurant']['location']['zipcode'];
		$country_id = $restaurants_parse_list[$i]['restaurant']['location']['country_id'];
		$cuisines = $restaurants_parse_list[$i]['restaurant']['cuisines'];
		$average_cost_for_two = $restaurants_parse_list[$i]['restaurant']['average_cost_for_two'];
		$price_range = $restaurants_parse_list[$i]['restaurant']['price_range'];
		$currency = $restaurants_parse_list[$i]['restaurant']['currency'];
		$thumb = $restaurants_parse_list[$i]['restaurant']['thumb'];
		$aggregate_rating = $restaurants_parse_list[$i]['restaurant']['user_rating']['aggregate_rating'];
		$votes = $restaurants_parse_list[$i]['restaurant']['user_rating']['votes'];
		$photos_url = $restaurants_parse_list[$i]['restaurant']['photos_url'];
		$menu_url = $restaurants_parse_list[$i]['restaurant']['menu_url'];
		$featured_image = $restaurants_parse_list[$i]['restaurant']['featured_image'];
		$has_online_delivery = $restaurants_parse_list[$i]['restaurant']['has_online_delivery'];
		$is_delivering_now = $restaurants_parse_list[$i]['restaurant']['is_delivering_now'];

		// CURRENTLY DOES NOT UPDATE IF THERE IS A DUPLICATE
		$add_sql = "INSERT INTO restaurants_zomato (id, name, url, address, locality, city, city_id, latitude, 
			longitude, zipcode, country_id, cuisines, average_cost_for_two, price_range, currency, thumb, aggregate_rating,
			votes, photos_url, menu_url, featured_image, has_online_delivery, is_delivering_now) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE last_update = now()";
		$result = $GLOBALS['_db']->prepare($add_sql);
		$result->execute(array($id, mysql_escape_string($name), $url, mysql_escape_string($address), 
			mysql_escape_string($locality), mysql_escape_string($city), $city_id, $latitude, 
			$longitude, $zipcode, $country_id, mysql_escape_string($cuisines), $average_cost_for_two, 
			$price_range, $currency, $thumb, $aggregate_rating, $votes, $photos_url, $menu_url, 
			$featured_image, $has_online_delivery, $is_delivering_now));
		echo $name . '<br />';
	}
*/
}
//print_r($result_array);

echo '<br />';
/*
$get_array = array();
parse_str($result, $get_array);

echo json_encode($result, JSON_PRETTY_PRINT);
*/
$templateFields = array('zomato_api_key' => $zomato_api_key, 'total_results' => $total_results);

displayTemplate('home', $templateFields);
//displayTemplate('footer');