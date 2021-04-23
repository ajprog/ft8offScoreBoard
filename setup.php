<?php  ?>
<!DOCTYPE html>
<head>
<title>FT8OFF</title>
<link href="/style/Site.css" rel="stylesheet" type="text/css" />
<link href='/img/ft8off.png' rel='shortcut icon' type='image/x-icon' />
<meta name="viewport" content="width=device-width" />
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


<script>
    $(document).ready(function(){
    		$("#div_timer").load("timer.php");
        setInterval(function() {
            $("#div_timer").load("timer.php");
        }, 1000);
    });
</script>
</head>
<?php include "header.php"; ?>
<body>

<div id="body">
    <section class="content-wrapper main-content clear-fix">
        
            <h1>Setup your software for FT8OFF</h1>
            <p>
            This setup guide is not an install manual for your FT8 software. </br>These instructions are for sending your logged QSOs to the FT8OFF Scoreboard.</br>
            In order to properly send your logged QSOs to the scoreboard, there is a software setting that is required.</br></br>
            Watch the setup video <a href="https://youtu.be/LICe34DjZuo" target="_blank" rel="noreferrer noopener">here</a>. </br></br>
            Jump to your software <a href="#wsjt-setup">WSJT-X</a> or <a href="#jtdx-setup">JTDX</a>.
               <div id="wsjt-setup">
                    <h2>WSJT-X Setup</h2>
                    <h4>
                        WSJT-X is the preferred software for use with the FT8OFF. 
                    </h4>
                            <h3>Open Settings</h3>
                                <img src="/img/wsjtx-menu.png">
                                <h3>Select Reporting Tab</h3>
                            <div class="container">
                            <div class="image">
                                <img src="/img/wsjtx-report.png">
                                </div>
                                <div class="text">
                                <p>In the "Secondary" UDP Server area:</p>
                                <p>Set the Server name or IP Address 3.22.55.64</p>
                                <p>Make sure the Server port is set to 2238</p>
                                <p>Click the checkbox to "Enable logged contact ADIF broadcast"</p>
                                </div></div>
                                <h3>Click "OK" to commit the settings</h3>
                                <h3>Make an FT8 contact and log the QSO</h3>
                                <h3>Check on the <a href=verify.php>"Packet Check"</a> page to see if your QSO was sent in</h3>
                                <p> If your QSO does not appear in either last 10 list, double check the settings page.</br>
                                If your settings are correct, and if after 3 successful FT8 QSOs you are sill not appearing on the last 10 list,</br>
                                post in the ft8off room on the TOADs discord requesting further assistance.
                                </p>
                </div>
                <div id="jtdx-setup">
                    <h2>JTDX Setup</h2>
                    <p>
                    Using JTDX for the FT8OFF requires the use of a local listener program. This program runs on Windows 10 64 bit only.</br>
                    The program is available at this <a href="/filestore/jtdx-monitor.zip"> link</a>.</br>
                    After downloading the .zip file, extract the contents and you can now run jtdx-monitor.exe.</br>
                    This program must be started and left running for JTDX to send your QSOs to the scoreboard.
                    </p>
                    <h3>Open Settings</h3>
                                <img src="/img/jtdx-menu.png">
                                <h3>Select Reporting Tab</h3>
                            <div class="container">
                                <div class="image">
                                <img src="/img/jtdx-report.png">
                            </div>
                                <div class="text">
                                <p>In the Send logged QSO ADIF data area:</p>
                                <p>Set the 2nd UDP server to 127.0.0.1</p>
                                <p>Make sure the UDP port is set to 2239</p>
                                <p>Click the checkbox to "Enable sending to secondary UDP server"</p>
                                </div>
                            </div>
                                <h3>Click "OK" to commit the settings</h3>
                                <h3>Run the jtdx-monitor program you downloaded</h3>
                                <div class="container">
                                    <div class="image">
                                <img src="/img/jtdx-monitor.png">
                            </div>
                                <div id="text">
                                <p>This program will require the following:</p>
                                <p>Type the station's callsign and press "Enter/Return"</p>
                                <p>Type the 4 or 6 digit maidenhead gridsquare for the current staion location and press "Enter/Return"</p>
                                <p>If the operator of the station is different from the station's callsign, enter the operator's call and press "Enter/Return"</p>
                                <p>You will see the information you entered written back to you. If it is incorrect you need to restart the program. Press ctrl+c
                                    to close the program and then reopen it to reset the data.</p>
                                </div>
                            </div>
                                <h3>Make an FT8 contact and log the QSO</h3>
                                <h3>Check on the <a href=verify.php>"Packet Check"</a> page to see if your QSO was sent in</h3>
                                <h3>Press ctrl+c to close jtdx-monitor when you are done</h3>
                                <p> If your QSO does not appear in either last 10 list, double check the settings page.</br>
                                If your settings are correct, and if after 3 successful FT8 QSOs you are sill not appearing on the last 10 list,</br>
                                post in the ft8off room on the TOADs discord requesting further assistance.
                                </p>
                </div>

            </section>
</div>
</body>
<?php


include "footer.php";
?>
