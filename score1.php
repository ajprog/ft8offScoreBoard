<?php 
include 'dbconnect.php';

$sqlcontest="SELECT * FROM ft8off_date WHERE contest_date BETWEEN DATE_SUB(DATE(NOW()),INTERVAL 1 WEEK) AND DATE(NOW()) ORDER BY contest_date DESC";
$contetdateresult=$conn->query($sqlcontest);

if ($contetdateresult->num_rows>0)
{
    $rowcontest=$contetdateresult->fetch_assoc();
    $contestdate=$rowcontest['contest_date'];
    $conteststart_time=$rowcontest['start_time'];
    $contest_end_time=$rowcontest['end_time'];
}


$timetostart=time($conteststart_time)-time();
$timetostarthr=floor(($timetostart % 86400)/3600);
$timetostartsmin=floor(($timetostart % 3600)/60);
$timetostartsec=($timetostart % 60);


$timerem=strtotime('2021-01-28 22:15:00')-time();
$timeremmin=floor(($timerem % 3600)/60);
$timeremsec=($timerem % 60);


echo "<h1>Running QSO Count </h1>";
//echo "Time Remaining ".time()."</br>";
    $sqlscore="SELECT station_callsign, COUNT(*) AS QSOs, SUM(is_dx) AS DX, SUM(is_event) AS eventcall, SUM(is_qrp) AS qrpflag, SUM(qso_score) AS qsoscore FROM ft8log WHERE qso_date>=DATE('".$contestdate."') AND time_on BETWEEN TIME('".$conteststart_time."') AND TIME('".$contest_end_time."') GROUP BY station_callsign ORDER BY qsoscore DESC";
    $result=$conn->query($sqlscore);
    
    if($result->num_rows>0)
    {
        echo "<table><tr><th>Player</th><th>QSOs</th><th>DX</th><th>SE</th><th>QRP</th><th></th><th>Score</th></tr>
        ";
        while($row=$result->fetch_assoc())
        {
            echo "<tr><td>".$row['station_callsign']."</td><td>".$row['QSOs']."</td><td>".$row['DX']."</td><td>".$row['eventcall']."</td><td>".$row['qrpflag']."</td><td></td><td>".$row['qsoscore']."</td></tr>
            ";
        }
  
    echo "</table>";  
}
else
{//echo "<h1>GET READY! We start in - ".$min.":".str_pad($sec,2,'0',STR_PAD_LEFT) ."</h1>";
    }
?>