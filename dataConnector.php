<?php
define('QRZ_BASE', "https://xmldata.qrz.com/xml/current/?");
function DBOpen()
{
	$host = 'localhost';
	$user = 'kd2fmw';
	$passwd = 'cancel1';
	$database = 'ft8off';
	$port = 3306;
	/* Connection with MySQLi, procedural-style */
	$conn = new mysqli($host, $user, $passwd, $database, $port);
	/* Check if the connection succeeded */
	if ($conn->connect_error)
	{
   		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}

function GetQRXKey()
{
	$qrz_un = "kd2fmw";
	$qrz_pw = "July181983";
	$qrz_url = QRZ_BASE . "username=" . $qrz_un . ";password=" . $qrz_pw;	
	$xml_response = simplexml_load_file($qrz_url);
	return $xml_response->Session->Key;
}
