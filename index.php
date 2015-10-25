<?php

    function returnMaps($origin, $dest) {
		$origin = str_replace(" ","+",$origin);
		$dest = str_replace(" ","+",$dest);
        $routes = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=".$origin."&destination=".$dest."&key=AIzaSyDPIf8XDKguqBgJo5VzM8eurWmMmOvWxB0&alternatives=true");
		$json=json_decode($routes, true);
		$steps = array();
		//VAR_DUMP($json);
		$routes = array();
		$i = 0;
		foreach($json["routes"] as $route) {
			$steps[$i] = array();
			foreach($route["legs"][0]["steps"] as $step){
					$lat = $step["end_location"]["lat"];
					$long = $step["end_location"]["lng"];
					array_push($steps[$i],array($lat, $long));
			}
			$i++;
		}
		//var_dump($steps);
		
		
		getCrimeRate(calculatePoly($steps, 0.01), $json);
    }
    echo returnMaps("Manchester University", "Salford University");
	
	function calculateTheta($x1, $y1, $x2, $y2){
		$tanTheta = ($y2-$y1)/($x2-$x1);
		$theta = rad2deg(atan($tanTheta));
		return $theta;
	}
	
	function plotPoints($x1,$y1, $x2, $y2 ,$d){
		$theta = calculateTheta($x1, $y1, $x2, $y2)+45;
		return array(
			array($d*cos($theta)+$x1, $d*sin($theta)+$y1),
			array(-$d*sin($theta)+$x1, -$d*cos($theta)+$y1),
			array(-$d*cos($theta)+$x1, -$d*sin($theta)+$y1),
			array($d*sin($theta)+$x1, $d*cos($theta)+ $y1),
		);	
	}
	
	function calculatePoly($steps, $distance) {
		$out = array();
		
		foreach ($steps AS $stepsRoute) {
		
			$arr = array();
			for($i=0; $i < count($stepsRoute)-1; $i++) {
				array_push($arr, plotPoints($stepsRoute[$i][0],$stepsRoute[$i][1],$stepsRoute[$i+1][0],$stepsRoute[$i+1][1], $distance));
			}
		
			$new = array();
			foreach ($arr AS $ar) {
				foreach ($ar AS $point) {
					$new[] = $point;
				}
			}
			
			array_push($out, $new);
			
		}
		
		//var_dump($out);
		
		return $out;
	}


	function getCrimeRate($routes = array(), $json)
	{

		$count_routes = count($routes);
		$rates = 0;
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
			if ($crime_rate_compare > $TheRoutes) {
				$crime_rate_compare = $TheRoutes;;
				$TheLowestCrimeRateArray = $array_number_set;
			}
			$array_number_set++;
		}

		var_dump($json['routes'][$TheLowestCrimeRateArray]);
	}
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
?>