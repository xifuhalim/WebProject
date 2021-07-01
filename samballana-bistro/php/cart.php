<?php
session_start();
include_once("dbconnect.php");
if (!isset($_COOKIE['email'])) {
    echo "<script>loadCookies()</script>";
    echo "<script> window.location.replace('../php/mainpage.php')</script>";
} else {
    $email = $_COOKIE["email"];
    if (isset($_GET['button'])) {
        $op = $_GET["button"];
        if ($op == "addcart") {
            $prid = $_GET['prid'];
            $sqlupdatecart = "UPDATE tbl_carts , tbl_products SET tbl_carts.qty = tbl_carts.qty +1 , tbl_products.prqty = tbl_products.prqty -1 WHERE tbl_carts.prid = '$prid' AND tbl_products.prid = '$prid'";
            if ($conn->exec($sqlupdatecart)) {
                echo "<script>alert('Success')</script>";
                echo "<script> window.location.replace('cart.php')</script>";
            } else {
                echo "<script>alert('Failed add')</script>";
                echo "<script> window.location.replace('cart.php')</script>";
            }
        }
        if ($op == "removecart") {
            $prid = $_GET['prid'];
            $qty = $_GET['qty'];
            if ($qty == 1) {
                echo "<script>alert('Failed.')</script>";
                echo "<script> window.location.replace('cart.php')</script>";
            } else {
                $sqlupdatecart = "UPDATE tbl_carts, tbl_products SET tbl_carts.qty = tbl_carts.qty -1, tbl_products.prqty = tbl_products.prqty +1  WHERE tbl_carts.prid = '$prid' AND tbl_products.prid = '$prid' ";
                if ($conn->exec($sqlupdatecart)) {
                    echo "<script>alert('Success')</script>";
                    echo "<script> window.location.replace('cart.php')</script>";
                } else {
                    echo "<script>alert('Failed')</script>";
                    echo "<script> window.location.replace('cart.php')</script>";
                }
            }
        }
        if ($op == "delete") {
            $prid = $_GET['prid'];
            $qty = $_GET['qty'];
            //$sqldelete ="UPDATE tbl_carts, tbl_products SET tbl_carts.qty = tbl_carts.qty - tbl_carts.qty , tbl_products.prqty = tbl_products.prqty + tbl_carts.qty  WHERE tbl_carts.prid = '$prid' AND tbl_products.prid = '$prid' ";
            $sqldelete = "UPDATE tbl_products, tbl_carts SET tbl_products.prqty = tbl_products.prqty + tbl_carts.qty WHERE tbl_products.prid = '$prid' AND tbl_carts.prid = '$prid' ; DELETE FROM tbl_carts WHERE email='$email' AND prid = '$prid'";
            $stmt = $conn->prepare($sqldelete);
            if ($stmt->execute()) {
                echo "<script> alert('Delete Success')</script>";
                echo "<script>window.location.replace('cart.php')</script>";
            } else {
                echo "<script> alert('Delete Failed')</script>";
            }
        }
        
        if ($op == "Pay") {
            $name = $_GET["name"];
            $mobile = $_GET["phone"];
            $pickup = $_GET['pickup'];
            $amount = $_GET['price'];

            $api_key = 'b47704d6-dd30-4143-a4b1-27eb88e8f906';
            $collection_id = 'dzx30a9g';
            $host = 'https://billplz-staging.herokuapp.com/api/v3/bills';

            $data = array(
                'collection_id' => $collection_id,
                'email' => $email,
                'mobile' => $mobile,
                'name' => $name,
                'amount' => $amount * 100, // RM20
                'description' => 'Payment for order',
                'callback_url' => "https://samballana.xifuhalim.com/index.php",
                'redirect_url' => "https://samballana.xifuhalim.com/php/paymentupdate.php?userid=$email&mobile=$mobile&amount=$amount"
            );
            $process = curl_init($host);
            curl_setopt($process, CURLOPT_HEADER, 0);
            curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));

            $return = curl_exec($process);
            curl_close($process);

            $bill = json_decode($return, true);

            //echo "<pre>".print_r($bill, true)."</pre>";
            header("Location: {$bill['url']}");

        }
    }
    //$sqladdtocart = "INSERT INTO tbl_carts (email, prid, qty) VALUES ('$email','$prodid','1'); UPDATE tbl_products SET prqty = prqty -1 WHERE prid = '$prodid'";
    //$sqlupdatepr = "UPDATE tbl_carts, tbl_products SET tbl_carts.qty = tbl_carts.qty +1, tbl_products.prqty = tbl_products.prqty-1  WHERE tbl_carts.prid = tbl_products.prid AND email = '$email'";
    $sqlloadcart = "SELECT * FROM tbl_carts INNER JOIN tbl_products ON tbl_carts.prid = tbl_products.prid WHERE tbl_carts.email = '$email'";
    $stmt = $conn->prepare($sqlloadcart);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/mainpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src='../js/myscript.js'></script>
</head>

<body>
    <div class="header">
        <a href="#default" class="logo">Samballana Bistro</a>
        <div class="header-right">

        </div>
    </div>
    <center>
       <br> <br> <h2>My Cart</h2>
    </center>
    <?php
    $sumtotal = 0.0;
    echo "<div class='container'>";
    echo "<div class='card-row'>";
    foreach ($rows as $carts) {
        $prid = $carts['prid'];
        $qty = $carts['qty'];
        $total = 0.0;
        $total = $carts['prprice'] * $carts['qty'];
        $imgurl = "../images/" . $carts['picture'];
        echo " <div class='card'>";
        echo "<p align='right'><a href='cart.php?button=delete&prid=$prid' class='fa fa-remove' onclick='return deleteDialog()' style=' color:#ff4242'></a></p>";
        echo "<img src='$imgurl' class='primage'>";
        echo "<h4 align='center' >" . ($carts['prname']) . "</h3>";
        echo "<p align='center'> RM " . number_format($carts['prprice'], 2) . "/unit<br>";
        echo "<table class='center'><tr><td><a href='cart.php?button=removecart&prid=$prid&qty=$qty'><i class='fa fa-minus' ' style='font-size:24px;color:#ff4242'></i></a></td>";
        echo "<td>Qty " . $qty . "</td>";
        echo "<td>&nbsp<a href='cart.php?button=addcart&prid=$prid&qty=$qty'><i class='fa fa-plus' ' style='font-size:24px;color:#ff4242'></i></a></td></tr></table>";
        echo "Total RM " . number_format($total, 2) . "<br>";
        echo "</div>";
        $sumtotal = $total + $sumtotal;
    }
    echo "</div>";
    echo "</div>";
    echo "<div class='container-src'>
    <h3>Total Price: RM " . number_format($sumtotal, 2) . "</h3></div>";
    ?>
    <div class="container">
        <h3>Payment Form</h3>
        <form action="cart.php" method="get">
            <div class="row">
                <div class="col-25">
                    <label for="lblemail">Your Email</label>
                </div>
                <div class="col-75">
                    <input type="text" id="idemail" name="email" value="<?php echo $email ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lblname">Your Name</label>
                </div>
                <div class="col-75">
                    <input type="text" id="idname" name="name" placeholder="Your Name" required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="lphone">Phone Number</label>
                </div>
                <div class="col-75">
                    <input type="text" id="idphone" name="phone" placeholder="Your phone" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="ltime">Pickup Time</label>
                </div>
                <div class="col-75">
                    <input type="time" id="idtime" name="pickup" min="09:00" max="18:00" required>
                </div>
            </div>
            <input type="hidden" id="idprice" name="price" value="<?php echo $sumtotal ?>">
            <div class="row">
                <div class="col-25">
                </div>
                <div class="col-75">
                    <input type="submit" name="button" value="Pay">
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

        <span class="fab-label">Main Page </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='mainpage.php';" class="fa fa-home"></i>
				</div>
                <li>
			<li>                    
            <span class="fab-label">My Purchase </span>
				<div class="fab-icon-holder">
					<i onclick="window.location.href='purchase.php';" class="fa fa-box"></i>
				</div>
                <li>
			<li>      
 <span class="fab-label">Logout </span>
				<div class="fab-icon-holder">
                <i onclick="window.location.href='../index.php?status=logout'" onclick="logout()" class="fa fa-sign-out-alt"></i>
				</div>
            
				</div>
</body>

</html>