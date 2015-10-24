<?php

    function returnMaps($origin, $dest) {
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
		
		
		calculatePoly($steps, 0.001);
    }
    echo returnMaps("stockport", "manchester");
	
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
		
		var_dump($out);
		
		return $out;
	}
?>