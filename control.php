<?php
echo "<h1>FT8OFF LAUNCH</h1></br>";
include 'dbconnect.php';

if(isset($_POST['b_wsjt_start']))
{
	$currdate=date('Ymd',time());
	$starttime= date('Gis',time()+60);
	$enddate=date('Ymd',time()+3660);
	$endtime=date('Gis',time()+3660);
	$newcontest="INSERT INTO ft8off_date (contest_num,contest_date,start_time,contest_end_date,end_time) VALUES(default," . $currdate . "," . $starttime . "," . $enddate . "," . $endtime .")";
	$sqlq=$conn->prepare($newcontest);
	$sqlq->execute();
	header('Location: index.php');
}

echo "<form method='post'>
<input type='submit' value='BEGIN COUNTDOWN' name='b_wsjt_start' />
</form>";

//include "footer.php"

?>
