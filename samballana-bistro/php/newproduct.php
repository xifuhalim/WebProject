<?php
include_once("dbconnect.php");


if (isset($_POST['button'])) {
    $prname = $_POST['prname'];
    $prtype = $_POST['prtype'];
    $prprice = $_POST['prprice'];
    $prqty = $_POST['prqty'];
    $picture = uniqid() . '.png';

    if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
        $sqlinsertprod =  "INSERT INTO tbl_products(prname, prtype, prprice, prqty,picture) VALUES('$prname','$prtype','$prprice','$prqty','$picture')";
        if ($conn->exec($sqlinsertprod)) {
            uploadImage($picture);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('../php/mainpage.php')</script>";
        } else {
            echo "<script>alert('Failed')</script>";
            return;
        }
    } else {
        echo "<script>alert('Image not available')</script>";
        return;
    }
}

function uploadImage($picture)
{
    $target_dir = "../images/";
    $target_file = $target_dir . $picture;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}

?>

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/mainpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src='../js/myscript.js'></script>
    </style>
</head>

<body>
    <div class="header">
        <a href="mainpage.php" class="logo">Samballana Bistro</a>
        </div>
    </div>
    <br><br><center><h2>Add Item</h2></center>

    <div class="container">
        <form action="../php/newproduct.php" method="post" enctype="multipart/form-data">
            <div class="row" align="center">
                <img class="imgselection" src="images.png"><br>
                <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload" accept="image/*"><br>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="fprname">Product Name</label>
                </div>
                <div class="col-75">
                    <input type="text" id="fprname" name="prname" placeholder="Product name..">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="prtype">Product Type</label>
                </div>
                <div class="col-75">
                    <select id="idprtype" name="prtype">
                        <option value="electronic">Electronics</option>
                        <option value="beverage">Beverage</option>
                        <option value="canned">Canned Food</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lprice">Price</label>
                </div>
                <div class="col-75">
                    <input type="text" id="idprice" name="prprice" placeholder="Price (RM).." >
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lqty">Quantity</label>
                </div>
                <div class="col-75">
                    <input type="text" id="idqty" name="prqty" placeholder="Quantity..">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                </div>
                <div class="col-75">
                    <input type="submit" name="button" value="Submit">
                </div>
            </div>
        </form>
    </div>
    <link rel="stylesheet" href="../css/index.css">
<div class="fab-container">
		<div class="fab fab-icon-holder">
			<i class="fa fa-plus"></i>
		</div>

		<ul class="fab-options">
        <li>
  <span class="fab-label">Admin Panel </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='adminpanel.php';" class="fa fa-home"></i>
				</div>
                <li>
			<li>      
            <span class="fab-label">Logout </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='../index.php?status=logout.php';" class="fa fa-sign-out-alt"></i>
				</div>
                <li>
			<li>
</body>

</html>