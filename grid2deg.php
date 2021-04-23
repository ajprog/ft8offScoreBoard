<?php
    /**
 	* Converts Grid Square to Latitude and Longitude
 	*/
	function grid2deg($str)
	{
		$char = substr($str, 4, 1);
		$i_char = ord($char);
		
		if($char == ' ' || $char == '' || $i_char < 64 || $i_char > 128) { $str = substr_replace($str, 'mm', 4);}
		else{ substr_replace($str, strtolower(substr($str, 3, 2)), 3, 2);}
		
		substr_replace($str, strtoupper(substr($str, 0, 2)), 0, 2);
		
		$array_str = str_split($str);
		
		$char1 = $array_str[0];
		$char2 = $array_str[1];
		$char3 = $array_str[2];
		$char4 = $array_str[3];
		$char5 = $array_str[4];
		$char6 = $array_str[5];
		
		$nlong = 180 - 20*(ord($char1)-ord('A'));
		$n20d = 2*(ord($char3)-ord('0'));
		$xminlong = 5*(ord($char5)-ord('a')+0.5);
		$dlong = -1*($nlong - $n20d - $xminlong/60.0);
		$nlat = -90+10*(ord($char2)-ord('A')) + ord($char4) - ord('0');
		$xminlat = 2.5*(ord($char6)-ord('a')+0.5);
		$dlat = $nlat + $xminlat/60.0;
		
		return $dlat.", ".$dlong."\n";
	}	
	
   	/**
 	* Calculates the great-circle distance between two points, with
 	* the Haversine formula.
 	* @param float $latitudeFrom Latitude of start point in [deg decimal]
 	* @param float $longitudeFrom Longitude of start point in [deg decimal]
 	* @param float $latitudeTo Latitude of target point in [deg decimal]
 	* @param float $longitudeTo Longitude of target point in [deg decimal]
 	* @param float $earthRadius Mean earth radius in [m]
 	* @return float Distance between points in [m] (same as earthRadius)
 	*/
	function distanceBetweenDegs(
  	$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
  		// convert from degrees to radians
  		$latFrom = deg2rad($latitudeFrom);
  		$lonFrom = deg2rad($longitudeFrom);
  		$latTo = deg2rad($latitudeTo);
  		$lonTo = deg2rad($longitudeTo);
		
  		$latDelta = $latTo - $latFrom;
  		$lonDelta = $lonTo - $lonFrom;
		
  		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    		cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  		return $angle * $earthRadius;
	}
?>
