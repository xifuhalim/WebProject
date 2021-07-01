<?php

include_once("../php/dbconnect.php");
if (isset($_POST['submit'])) {
    if (!(isset($_POST["name"]) || isset($_POST["email"]) || isset($_POST["phone"]) || isset($_POST["passworda"]) || isset($_POST["passwordb"]))) {
        echo "<script> alert('Please fill in all required information')</script>";
        echo "<script> window.location.replace('../php/register.php')</script>";
    } else {
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $passa = $_POST["passworda"];
            $passb = $_POST["passwordb"];
            $shapass = sha1($passa);
            $otp = rand(1000, 9999);
            $sqlregister = "INSERT INTO tbl_user(email,phone,name,password,otp) VALUES('$email','$phone','$name','$shapass','$otp')";
            try {
                $conn->exec($sqlregister);
                uploadImage($email);
                echo "<script>alert('Registration successful')</script>";
                echo "<script>window.location.replace('../php/login.php')</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Registration failed')</script>";
                echo "<script>window.location.replace('../php/register.php')</script>";
            }
        } else {
            echo "<script>alert('No image selected')</script>";
            echo "<script>window.location.replace('../php/register.php')</script>";
        }
    }
}
function uploadImage($email)
{
    $target_dir = "../images/profile/";
    $target_file = $target_dir . $email . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}
?>


<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../css/newproduct.css">
    <link rel="stylesheet" href="../css/index.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="validator.js"></script>

     
   </head>
<body>
<div id="header">
         <div id="logo">
            <h3><span>Samballana Bistro</span></h3>
         </div>
      </div>
  <div class="container">
    <div class="title">Register</div>
    <div class="content">
    <form name="registerForm" action="../php/register.php" onsubmit="return validateRegForm()" method="post" enctype="multipart/form-data">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Name</span>
            <input type="text" class="form-control" id="idname" name="name" placeholder="Enter your name" required>
                </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" class="form-control" id="idemail" name="email" placeholder="Enter your email" required>
            </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" class="form-control" id="idphone" name="phone" placeholder="Enter your phone number" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" class="form-control" id="idpass" name="passworda" placeholder="Enter your password" required>
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" class="form-control" id="idpassb" name="passwordb" placeholder="Re-enter your password" required>
            </div>

            <div class="input-box">
            <span class="details"> Your Photo </span>
            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" placeholder="Upload your photo" required>
  
            </div>
            </div>
        <div class="button">
        
          <input type="submit" name="submit" value="Register">
          
         
          
        </div>
      </form>
      
    </div>
    
  </div>
  </div>
  
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="fab-container">
		<div class="fab fab-icon-holder">
			<i class="fa fa-plus"></i>
		</div>

		<ul class="fab-options">
    <li>
				<span class="fab-label">Home </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='../index.php';" class="fa fa-home"></i>
					</div>
               <li>
			<li>
      <span class="fab-label">Login </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='login.php';" class="fa fa-sign-in"></i>
					</div>
</body>
</html>
