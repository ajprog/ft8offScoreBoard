<?php 
include 'dbconnect.php';
echo "<h1>Today's QSO Count</h1>";
//echo "Time Remaining ".time()."</br>";
    $sqlscore="Select station_callsign,count(*) as QSOs from ft8log where qso_date=curdate() group by station_callsign order by QSOs desc";
    $result=$conn->query($sqlscore);
    
    if($result->num_rows>0)
    {echo "<table><tr><th>Callsign</th><th>Total QSO's</th></tr>";
        while($row=$result->fetch_assoc())
        {
            echo "<tr><td>".$row['station_callsign']."</td><td>".$row['QSOs']."</td></tr>
            ";
        }
  
    echo "</table>";  
} else
    {
        echo "<h1>GET READY!</h1>";
    }
?>