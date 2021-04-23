<!DOCTYPE html>
<head>
<title>FT8OFF</title>
<link href='/style/Site.css' rel='stylesheet' type='text/css' />
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
<body>
<?php include 'header.php';?>
    
    <div id=body>
        <section class="main-content clear-fix">
            <div id="div_score">
            <?php include_once 'verifytable.php';?>

                </div>
                <script type='text/javascript'>
      var table = $('#div_score');
     // refresh every 5 seconds
     var refresher = setInterval(function(){
       table.load("verifytable.php");
     }, 10000);
     </script>
         </section>
    </div>
</body>
<?php

    include 'footer.php';
?>
