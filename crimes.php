<?php
	$police_decode =	json_decode(file_get_contents("https://data.police.uk/api/crimes-at-location?date=2012-02&lat=52.629729&lng=-1.131592"));
	
		$count_crimes = count($police_decode);
	
		for ($i = 0; $i < $count_crimes; $i++) {
			
			echo $police_decode[$i]->category . "<br>";
			echo iterate($police_decode);
			
		}
	
	function iterate($police_decode) {
		$value = 0;
			if ($police_decode["catergory"]["url"]==="possession-of-weapons")
				$value = $value + 0.9;
			elseif ($police_decode["catergory"]["url"]==="violent-crime")
				$value = $value  + 0.9;
			elseif($police_decode["catergory"]["url"]==="theft-from-the-person")
				$value = $value  + 0.7;
			elseif($police_decode["catergory"]["url"]==="robbery")
				$value = $value  + 0.6;
			elseif($police_decode["catergory"]["url"]==="anti-social-behaviour ")
				$value = $value  + 0.5;
			elseif($police_decode["catergory"]["url"]==="public-order ")
				$value = $value  + 0.4;
			elseif($police_decode["catergory"]["url"]==="vehicle-crime")
				$value = $value  + 0.4;
			elseif($police_decode["catergory"]["url"]==="burglary")
				$value = $value  + 0.3;
			elseif($police_decode["catergory"]["url"]==="criminal-damage-arson")
				$value = $value  + 0.2;
			elseif($police_decode["catergory"]["url"]==="drugs")
				$value = $value  + 0.2;
			elseif($police_decode["catergory"]["url"]==="bicycle-theft ")
				$value = $value  + 0.2;
			elseif($police_decode["catergory"]["url"]==="other-theft")
				$value = $value  + 0.1;
			elseif($police_decode["catergory"]["url"]==="shoplifting")
				$value = $value  + 0.1;
			elseif($police_decode["catergory"]["url"]==="other-crime")
				$value = $value  + 0.1;
				
			return $value;

	}

	function details($police_decode) {
		$police_decode =	json_decode(file_get_contents("https://data.police.uk/api/crimes-at-location?date=2012-02&lat=52.629729&lng=-1.131592"));

		$count_crimes = count($police_decode);

		for ($i = 0; $i < $count_crimes; $i++) {

		}
	}
?>