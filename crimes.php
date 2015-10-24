<?php
function crime_rate($lat, $lng)
		$police_decode =	json_decode(file_get_contents("https://data.police.uk/api/crimes-at-location?date=2012-02&lat=52.629729&lng=-1.131592"));
	
		$count_crimes = count($police_decode);
		$value = 0;
		for ($i = 0; $i < $count_crimes; $i++) {
			
			$value = $value + iterate_crime_rate($police_decode[$i]->category);
			echo $police_decode[$i]->category . " ";
			echo $value . "<br>";
		}
 		return $value;
}
	
	function iterate_crime_rate($police_decode)
	{
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