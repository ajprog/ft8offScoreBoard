<?php


if( !include_once("dataConnector.php") ) 
{
	$message = 'There was some error loading the connection utilities, please contact the web admin.';
}

function ADIFParser($adif)
{
	$processing = false;
	$new_line = "\r\n";
	$current_adif = strtok($adif, $new_line);
	while($current_adif !== false)
	{	
		if(strlen($current_adif) > 0)
		{
			if($processing)
			{
				$offset = 0;
				$adif_line['raw'] = $current_adif;
				while( preg_match('/\<(?P<name>\w+):(?P<length>\d+)\>/', $current_adif, $matches, PREG_OFFSET_CAPTURE, $offset) )
				{
					$adif_line[strtolower($matches['name'][0])] = substr($current_adif, $matches['length'][1]+1+strlen($matches['length'][0]),$matches['length'][0]);
					$offset = $matches['length'][1]+1+strlen($matches['length'][0])+$matches['length'][0];
				}
			}
			else
			{
				$current_adif = strtolower($current_adif);
				if(strpos($current_adif, "<eoh>") !== false) $processing = true;
			}
		}
		if (strlen($current_adif) >= 5 && substr( $current_adif, -5 ) === "<eor>")
	        {
   		         if(!empty($adif_line)) $parsed_adif[] = $adif_line;
		         $adif_line = array();
        	}
        	$current_adif = strtok($new_line);
	}
	strtok('','');
	return $parsed_adif;
}
	
function DCXXEntity($callsign, $key)
{
	$qrz_url = QRZ_BASE . "s=" . $key . ";callsign=" . $callsign;
	$xml_response = simplexml_load_file($qrz_url);
	if(isset($xml_response->Session->Error))
	{
		$qerror = $xml_response->Session->Error;
		if($qerror == "Session Timeout") $xml_response = simplexml_load_file($qrz_url);
	}
	if(isset($xml_response->Callsign->dxcc))
	{
		//Echo $xml_response->Callsign->dxcc."</br>";
		return $xml_response->Callsign->dxcc;
	}
	else
	{
		//echo "999</br>";
		return 999;
	}
}

function ADIFInsert($parsed_adif, $conn)
{
	$raw_query = $conn->prepare("INSERT INTO ft8adif (rawadif) VALUES(?)");
	$raw_query->bind_param("s", $raw_adif);
	
	$query = $conn->prepare("INSERT IGNORE INTO ft8log (`call`, gridsquare, mode, rst_sent, rst_rcvd, qso_date, time_on, qso_date_off, time_off, band, freq, station_callsign, my_gridsquare, tx_pwr, comments, name, operator_call, propmode, is_dx, is_event, is_qrp, qso_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$query->bind_param("sssiiiiiisdssissssiiii", $call, $gridsquare, $mode, $rst_sent, $rst_rcvd, $qso_date, $time_on, $qso_date_off, $time_off, $band, $freq, $station_callsign, $my_gridsquare, $tx_pwr, $comment, $name, $operator, $propmode, $is_dx, $is_event, $is_qrp, $qso_score);

	foreach($parsed_adif as $adif_line)
	{
		if(!empty($adif_line['raw'])) $raw_adif = $adif_line['raw'];
		else $raw_adif = '';
		if(!empty($adif_line['call'])) $call = $adif_line['call'];
		else $call = '';
		if(!empty($adif_line['gridsquare'])) $gridsquare = $adif_line['gridsquare'];
		else $gridsquare = '';
		if(!empty($adif_line['mode'])) $mode = $adif_line['mode'];
		else $mode = '';
		if(!empty($adif_line['rst_sent'])) $rst_sent = intval($adif_line['rst_sent']);
		else $rst_sent = -99;
		if(!empty($adif_line['rst_rcvd'])) $rst_rcvd = intval($adif_line['rst_rcvd']);
		else $rst_rcvd = -99;
		if(!empty($adif_line['qso_date'])) $qso_date = intval($adif_line['qso_date']);
		else $qso_date = 0;
		if(!empty($adif_line['time_on'])) $time_on = intval($adif_line['time_on']);
		else $time_on = 0;
		if(!empty($adif_line['qso_date_off'])) $qso_date_off = intval($adif_line['qso_date_off']);
		else $qso_date_off = 0;
		if(!empty($adif_line['time_off'])) $time_off = intval($adif_line['time_off']);
		else $time_off = 0;
		if(!empty($adif_line['band'])) $band = $adif_line['band'];
		else $band = '';
		if(!empty($adif_line['freq'])) $freq = floatval($adif_line['freq']);
		else $freq = 0.0;
		if(!empty($adif_line['station_callsign'])) $station_callsign = $adif_line['station_callsign'];
		elseif(!empty($adif_line['operator'])) $station_callsign = $adif_line['operator'];
		else $station_callsign = '';
		if(!empty($adif_line['my_gridsquare'])) $my_gridsquare = $adif_line['my_gridsquare'];
		else $my_gridsquare = '';
		if(!empty($adif_line['tx_pwr'])) $tx_pwr = intval($adif_line['tx_pwr']);
		else $tx_pwr = -1;
		if(!empty($adif_line['comment'])) $comment = $adif_line['comment'];
		else $comment = '';
		if(!empty($adif_line['name'])) $name = $adif_line['name'];
		else $name = '';
		if(!empty($adif_line['operator'])) $operator = $adif_line['operator'];
		elseif(!empty($adif_line['station_callsign'])) $operator = $adif_line['station_callsign'];
		else $operator = '';
		if(!empty($adif_line['propmode'])) $propmode = $adif_line['propmode'];
		else $propmode = '';
		
		$mycall = $operator;

		$key = GetQRXKey();
		$my_dxcode = DCXXEntity($mycall, $key);
		$their_dxcode = DCXXEntity($call, $key);
		//echo $my_dxcode;
		//echo $their_dxcode;
		
		if((intval($my_dxcode) == intval($their_dxcode)) || (intval($my_dxcode)==999) || (intval($their_dxcode)==999)) $is_dx = 0;
		else $is_dx = 1;
		//echo $is_dx."</br>";
		if(0 < $tx_pwr && $tx_pwr <= 20) $is_qrp = 1;
		else $is_qrp = 0;
		
		if(strlen($call) <= 3) $is_event = 1;
		else $is_event = 0;
		
		$qso_score = 1;
		if($is_dx == 1) $qso_score += 2;
		elseif($is_event == 1) $qso_score += 3;
		
		if($is_qrp == 1 && $qso_score > 1) $qso_score += 1;
		
		$query->execute();
		$raw_query->execute();
	}

}
