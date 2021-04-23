<?php  ?>
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

<?php
include 'body.php'; 
include 'footer.php';
?>
