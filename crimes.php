<?php
$routes = array(array(
	array(53.4519976, -2.6102247000000034),array(53.7571075, -2.699289399999998),array(53.7586291, -2.698829299999943),array(52.4065792, -1.822766300000012)),
	array(array(53.4030199, -2.3287987999999586),array(53.47072360000001, -2.323057400000039),array(51.35367549999999, -0.6009335999999621),array(51.5501711, -0.09451050000006944)));
	//array(array($lat, $lng),array($lat, $lng),array($lat, $lng),array($lat, $lng),array($lat, $lng)));

$count_routes = count($routes);
$rates= 0;
$rate = 0;
$route_rates = array();
for ($i = 0; $i < $count_routes; $i++) {
	$count_points = count($routes[$i]);
	for ($r = 0; $r < $count_points; $r++) {
		$lat = $routes[$i][$r][0];
		$lng = $routes[$i][$r][1];

		$rate = crime_rate($lat, $lng);
		$rates = $rates + $rate;
	}
	array_push($route_rates, $rates);
}
$crime_rate_compare = 100000000;
$array_number_set = 0;
$TheLowestCrimeRateArray = 0;
foreach ($route_rates as $TheRoutes) {
	if($crime_rate_compare > $TheRoutes) {
		$crime_rate_compare = $TheRoutes;;
		$TheLowestCrimeRateArray = $array_number_set;
		echo $TheRoutes . "<br>";
	}
	$array_number_set++;
}
echo $crime_rate_compare . " Of The Array " . $TheLowestCrimeRateArray;


function crime_rate($lat, $lng) {
		$police_decode =	json_decode(file_get_contents("https://data.police.uk/api/crimes-at-location?date=2012-02&lat=" . $lat . "&lng=" . $lng));

		$count_crimes = count($police_decode);
		$value = 0;
		$values = 0;
		for ($i = 0; $i < $count_crimes; $i++) {
			
			$value = $value + iterate_crime_rate($police_decode[$i]->category);
			$values = $value;
		}
 		return $values;
}
	
	function iterate_crime_rate($police_decode)
	{
		$value = 0;
		if ($police_decode === "possession-of-weapons") {
			$value = 9;
		} elseif ($police_decode === "violent-crime") {
			$value = 9;
		} elseif ($police_decode === "theft-from-the-person") {
			$value = 7;
		} elseif ($police_decode === "robbery") {
			$value = 6;
		} elseif ($police_decode === "anti-social-behaviour") {
			$value = 5;
		} elseif ($police_decode === "public-order ") {
			$value = 4;
		} elseif ($police_decode === "vehicle-crime") {
			$value = 4;
		} elseif ($police_decode === "burglary") {
			$value = 3;
		} elseif ($police_decode === "criminal-damage-arson") {
			$value = 2;
		} elseif ($police_decode === "drugs") {
			$value = 2;
		} elseif ($police_decode === "bicycle-theft ") {
			$value = 2;
		} elseif ($police_decode === "other-theft") {
			$value = 1;
		} elseif ($police_decode === "shoplifting") {
			$value = 1;
		} elseif($police_decode === "other-crime") {
			$value = 1;
		}

			return $value;
	}

	function details($police_decode) {
		$police_decode =	json_decode(file_get_contents("https://data.police.uk/api/crimes-at-location?date=2012-02&lat=52.629729&lng=-1.131592"));

		$count_crimes = count($police_decode);

		for ($i = 0; $i < $count_crimes; $i++) {

		}
	}
?>