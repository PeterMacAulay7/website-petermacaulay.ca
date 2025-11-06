<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="icon" type="" href="PMsignature.png">
  <link rel="stylesheet" href="styles.css">

<style>
    body {
        margin-left: 300px;
        margin-right: 300px;
        background-image: url("/images/clouds.jpg");
        background-size: cover;        /* makes it fill the screen */
        background-repeat: no-repeat;  /* stops tiling */
        background-position: center;   /* centers the image */
    }
</style>

<!--Weather Widget-->
<a class="weatherwidget-io" href="https://forecast7.com/en/45d90n64d37/sackville/" data-label_1="SACKVILLE" data-label_2="WEATHER" data-theme="original" >SACKVILLE WEATHER</a>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
</script>

<!--Clock Widget-->
<iframe scrolling="no" frameborder="no" clocktype="html5" style="overflow:hidden;border:0;margin:0;padding:0;width:240px;height:80px;"src="https://www.clocklink.com/html5embed.php?clock=004&timezone=Canada_Halifax&color=black&size=240&Title=&Message=&Target=&From=2025,1,1,0,0,0&Color=black"></iframe>