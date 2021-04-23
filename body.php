<body>
 <?php include 'header.php';?>
    <div id=body>
        <section class="content-wrapper main-content clear-fix">
            <div class="float-left">
                <p><img src="img/hqdefault_live.png"></p>
            </div>
            
            <div class="float-right">
                <p><img src='img/WTF_.png' width='336' height='188'></p>
            </div> </section>
                
            <section class='content-wrapper featured clear-fix'> 
                <div id="div_score">
                <?php include_once 'score.php';?>
                </div>
                <script type='text/javascript'>
      var table = $('#div_score');
     // refresh every 5 seconds
     var refresher = setInterval(function(){
       table.load("score.php");
     }, 1000);
     //setTimeout(function() {
     //  clearInterval(refresher);
     //}, 1800000);
</script>
         </section>
    </div>
</body>