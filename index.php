<?php

    function returnMaps($origin, $dest) {
        $routes = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=".$origin."&destination=".$dest."&key=AIzaSyDPIf8XDKguqBgJo5VzM8eurWmMmOvWxB0&alternate=true");
		$json=json_decode($routes, true);
		var_dump($json);
		
		foreach($json["routes"][0]["legs"][0]["steps"] as $step){
				$lat = $step["end_location"]["lat"];
				$long = $step["end_location"]["lng"];
				$police_response = file_get_contents("https://data.police.uk/api/crimes-at-location?date=2015-08&lat=".$lat."&lng=".$long);
				$police_decode=json_decode($police_response, true);
				//var_dump($police_decode);
		}
    }
    echo returnMaps("london", "manchester");
	
	function calculateSlope($x1,$x2 $y1, $y2) {
		$m = ($y1-$y2)/($x1-$x2);
		return $m;
	}
	
	function calculateYIntercept($x1, $x2, $y1, $y2){
		return -((calculateSlope($x1,$x2,$y1,$y2)*$x1)-$y1);
	}
	

?>