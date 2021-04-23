<?php 
if( !include_once("dataConnector.php") ) 
{
	$message = 'There was some error loading the connection utilities, please contact the web admin.';
}
$conn=DBOpen();

$sqlcontest="SELECT * FROM ft8off_date WHERE contest_date BETWEEN DATE_SUB(DATE(NOW()),INTERVAL 8 DAY) AND DATE(NOW()) ORDER BY contest_date DESC";
$contetdateresult=$conn->query($sqlcontest);
$r=1;
if ($contetdateresult->num_rows>0)
{
    $rowcontest=$contetdateresult->fetch_assoc();
    $contestdate=$rowcontest['contest_date'];
    $conteststart_time=$rowcontest['start_time'];
    $contestenddate=$rowcontest['contest_end_date'];
    $contest_end_time=$rowcontest['end_time'];
}
$date= date_create(($contestdate));
date_add($date,date_interval_create_from_date_string("7 days"));
$conteststart=$contestdate." ".$conteststart_time;
$contestend=$contestenddate." ".$contest_end_time;

$timetostart=strtotime($conteststart)-strtotime(now);
$timetostarthr=floor(($timetostart % 86400)/3600);
$timetostartmin=floor(($timetostart % 3600)/60);
$timetostartsec=($timetostart % 60);

$timerem=strtotime($contestend)-strtotime(now);
$timeremmin=floor(($timerem % 3600)/60);
$timeremsec=($timerem % 60);
echo "<div class=\"row\">
<div class=\"top\">
";
if($contestdate==date('Y-m-d') && $timerem>0)
{
    echo "<h1>FT8OFF FOR ".$contestdate."</h1>
    ";

    if($timetostart>0)
    {
        echo "<h2>Our Battle begins in: ".$timetostarthr.":".str_pad($timetostartmin,2,'0',STR_PAD_LEFT).":".str_pad($timetostartsec,2,'0',STR_PAD_LEFT)."</h2>";
    }
    else if ($timetostart<0 && $timerem>0)
    {
        echo "TIME REMAINING: ".str_pad($timeremmin,2,'0',STR_PAD_LEFT).":".str_pad($timeremsec,2,'0',STR_PAD_LEFT);
/*
        $sqlscore="SELECT station_callsign, COUNT(*) AS QSOs, SUM(is_dx) AS DX, SUM(is_event) AS eventcall, SUM(is_qrp) AS qrpflag, SUM(qso_score) AS qsoscore FROM ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."') GROUP BY station_callsign ORDER BY qsoscore DESC";
        $result=$conn->query($sqlscore);
 
        if($result->num_rows>0)
        {
            echo "<table><tr><th>Rank</th><th>Player</th><th>QSOs</th><th>DX</th><th>SE</th><th>QRP</th><th></th><th>Score</th></tr>
            ";
            while($row=$result->fetch_assoc())
        {
            echo "<tr><td>". $r++ ."</td><td>".$row['station_callsign']."</td><td>".$row['QSOs']."</td><td>".$row['DX']."</td><td>".$row['eventcall']."</td><td>".$row['qrpflag']."</td><td></td><td>".$row['qsoscore']."</td></tr>
            ";
        }
            echo "</table>";
        }
    */  }
}
else
{
    echo "<h2>Scores for ".$contestdate."</h2>
     ";
}
echo "</div>
<div class=\"column1\" style=\"border-right-style:solid;border-width:2px;margin-right:10px;\">
";
    $sqlscore="SELECT station_callsign, COUNT(*) AS QSOs, SUM(is_dx) AS DX, SUM(is_event) AS eventcall, SUM(is_qrp) AS qrpflag, SUM(qso_score) AS qsoscore FROM ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."') GROUP BY station_callsign ORDER BY qsoscore DESC";
    $result=$conn->query($sqlscore);
    if($result->num_rows>0)
    {
        echo "<table><tr><th>Rank</th><th>Player</th><th>QSOs</th><th>DX</th><th>SE</th><th>QRP</th><th></th><th>Score</th></tr>
        ";
        while($row=$result->fetch_assoc())
    {
        echo "<tr><td>" . $r++ . "</td><td>".$row['station_callsign']."</td><td>".$row['QSOs']."</td><td>".$row['DX']."</td><td>".$row['eventcall']."</td><td>".$row['qrpflag']."</td><td></td><td>".$row['qsoscore']."</td></tr>
        ";
    }
    }
    
  
    echo "</table>

    </div>
    ";
echo "
<div class=\"column2\" style=\"border-right-style:solid;border-width:2px;margin-right:10px;\">
<h2>Top 3 by Power</h2>
";
$sqlqro="SELECT station_callsign, COUNT(*) AS QSOs, SUM(qso_score) AS qsoscore FROM ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."') AND tx_pwr>100 GROUP BY station_callsign ORDER BY qsoscore DESC LIMIT 3";
$sqlbare="SELECT station_callsign, COUNT(*) AS QSOs, SUM(qso_score) AS qsoscore FROM ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."') AND tx_pwr BETWEEN 21 AND 100 GROUP BY station_callsign ORDER BY qsoscore DESC LIMIT 3";
$sqlqrp="SELECT station_callsign, COUNT(*) AS QSOs, SUM(qso_score) AS qsoscore FROM ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."') AND tx_pwr BETWEEN 1 AND 20 GROUP BY station_callsign ORDER BY qsoscore DESC LIMIT 3";
$sqlnpi="SELECT station_callsign, COUNT(*) AS QSOs, SUM(qso_score) AS qsoscore FROM ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."') AND tx_pwr=\"\" GROUP BY station_callsign ORDER BY qsoscore DESC LIMIT 3";

$qroresult=$conn->query($sqlqro);
$bareresult=$conn->query($sqlbare);
$qrpresult=$conn->query($sqlqrp);
$npiresult=$conn->query($sqlnpi);

echo "
";
if($qroresult->num_rows>0)
{
echo "<h3>Over 100W</h3>
<table>
<tr><th>Player</th><th>QSOs</th><th>Score</th></tr>
";
while($qrorow=$qroresult->fetch_assoc())
    {
        echo "<tr><td>" .$qrorow['station_callsign']."</td><td>".$qrorow['QSOs']."</td><td>".$qrorow['qsoscore']."</td></tr>
        ";
    }
echo "</table>
";
}

if($bareresult->num_rows>0)
{
echo "<h3>Barefoot</h3>
<table>
<tr><th>Player</th><th>QSOs</th><th>Score</th></tr>
";
while($barerow=$bareresult->fetch_assoc())
    {
        echo "<tr><td>" .$barerow['station_callsign']."</td><td>".$barerow['QSOs']."</td><td>".$barerow['qsoscore']."</td></tr>
        ";
    }
echo "</table>
";
}

if($qrpresult->num_rows>0)
{
echo "<h3>Under 20W</h3>
<table>
<tr><th>Player</th><th>QSOs</th><th>Score<t/h></tr>
";
while($qrprow=$qrpresult->fetch_assoc())
    {
        echo "<tr><td>" .$qrprow['station_callsign']."</td><td>".$qrprow['QSOs']."</td><td>".$qrprow['qsoscore']."</td></tr>
        ";
    }
echo "</table>
";
}

if($npiresult->num_rows>0)
{
echo "<h3>No Power Indicator</h3>
<table>
<tr><th>Player</th><th>QSOs</th><th>Score</th></tr>
";
while($npirow=$npiresult->fetch_assoc())
    {
        echo "<tr><td>" .$npirow['station_callsign']."</td><td>".$npirow['QSOs']."</td><td>".$npirow['qsoscore']."</td></tr>
        ";
    }
echo "</table>
";
}
echo "</div>
<div class=\"column3\">
<h2>Stats:</h2>
";
$sqlqsocount="SELECT count(*) as QSOs FROM ft8off.ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."')";
$qsocountresult=$conn->query($sqlqsocount);
if($qsocountresult->num_rows>0)
{
    while( $qsorow=$qsocountresult->fetch_assoc())
    {
        echo "<h3>Total QSOs: ". $qsorow['QSOs']."</h3>";
        echo "<h3>Total Stations: ".--$r."</h3>";
    }
}
echo "<h3>Contacts by Band:</h3>
";
$sqlband="SELECT band,count(band) as QSOs  FROM ft8off.ft8log WHERE TIMESTAMP(qso_date,time_on) BETWEEN TIMESTAMP('".$contestdate."','".$conteststart_time."') AND TIMESTAMP('".$contestenddate."','".$contest_end_time."') GROUP BY band  ORDER BY cast(band AS unsigned)";
$bandresult=$conn->query($sqlband);
if($bandresult->num_rows>0)
{
    echo "<table><tr><th>Band</th><th>QSOs</th></tr>";
    while($bandrow=$bandresult->fetch_assoc())
    {
        echo "<tr><td>".$bandrow['band']."</td><td>".$bandrow['QSOs']."</td></tr>
        ";
    }
}echo "</table></br>
";
echo "</div>
</div>";


?>
