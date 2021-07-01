<?php
session_start();
if (isset($_GET["status"])) {
   if (($_GET["status"] == "logout")) {
       session_unset();
       session_destroy();
       echo "<script> alert('Session Cleared')</script>";
   }
}
   ?>

<!DOCTYPE html>
<html>
   <head>
      <title>Samballana Bistro</title>
	  
      <link rel="stylesheet" href="css/index.css" type="text/css">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <style>
img {
    max-width: 100%;
}
</style>
   </head>
   <body>
   
   
      <div id="header">
         <div id="logo">
            <h3><span>Samballana Bistro</span></h3>
         </div>
      </div>
	  <div id="container">
     
   <div id="content-container">
      <h1>Samballana Bistro</h1>
      <p>Rasai keenakan masakan barat dengan ramuan rahsia teristimewa yang pasti memberikan anda kenikmatan rasa yang luar biasa hanya di Samballana Bistro.</p>
   </div>
   <div id="bg-container" class="hidden-mobile">
   <img src="images/logos.png" width="70%" height="auto" class="center">
   </div>

</div>	  
<div class="content">

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="fab-container">
		<div class="fab fab-icon-holder">
			<i class="fa fa-plus"></i>
		</div>

		<ul class="fab-options">

               <li>
				<span class="fab-label">Admin</span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='php/adminlogin.php';" class="fa fa-user"></i>
					</div>
               <li>
               <li>
				<span class="fab-label">Register </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='php/register.php';" class="fa fa-user-plus"></i>
					</div>
               <li>
         <li>
				<span class="fab-label">Login </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='php/login.php';" class="fa fa-sign-in"></i>
					</div>
             

               
   </body>
</html>