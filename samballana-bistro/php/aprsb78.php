<?php
  $conn = mysqli_connect("sdb-f.hosting.stackcp.net","samballana-313834a119","Halim2021") or die("Unable to connect");
  mysqli_select_db($conn,"samballana-313834a119");

if(isset($_POST['submit'])){

$email = trim($_POST['email']);
$password = trim(sha1($_POST['password']));
if(mysqli_query($conn,"UPDATE tbl_admin SET password='$password' WHERE email='$email'")){

?>
<?php
 echo '<script type="text/javascript"> alert("Password Update Successfully")</script>';
 echo "<script> window.location.replace('../index.php')</script>";
 ?>
 <?php
}else{
echo 'no result';
}
}
?>

<!DOCTYPE html>
<html>
   <head>
   <meta charset="UTF-8">
    <title>Samballana Bistro Login</title>
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
    <div class="title">Admin Password Reset</div>
    <div class="content">
    <form name="forgetForm" action="../php/forget.php" onsubmit="return validateLoginForm()" method="post">
        <div class="user-details">
        <div class="input-box">
            <span class="details">Email</span>
            <input type="text" class="form-control" id="idemail" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-box">
            <span class="details">Password</span>
            <input type="password" class="form-control" id="idpass" name="password" placeholder="Enter your new password" required>
          </div>
                    </div>

                   
        <div class="button">
        
          <input type="submit" name="submit" value="Reset Password">
          
         
          
        </div>
      </form>
    
 

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
   </body>
</html>
