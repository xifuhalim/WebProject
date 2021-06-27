<?php
session_start();
include_once("dbconnect.php");

if ($_SESSION["session_id"]) {
    $username = $_SESSION["email"];
    $name = $_SESSION["name"];
    $school = $_SESSION["school"];
    $phone = $_SESSION["phone"];
    $datereg = $_SESSION["datereg"];
    if (isset($_POST['submit'])) {
        $nname = $_POST["name"];
        $nphone = $_POST["phone"];
        $nschool = $_POST["school"];
        $current = sha1($_POST["oldpassword"]);
        $pass = $_SESSION["pass"];
        if ($current == $pass) {
            if (isset($_POST["newpassworda"]) || isset($_POST["newpasswordb"])) {
                $npassa = $_POST["newpassworda"];
                $npassb = $_POST["newpasswordb"];
                if (!(empty($npassa) || empty($npassb))) {
                    if ($npassa == $npassb) {
                        $newpass = sha1($npassa);
                        $sqlupdate = "UPDATE tbl_user SET phone='$nphone',name='$nname',school='$nschool',password= '$newpass' WHERE email = '$username'";
                    }
                } else {
                    $sqlupdate = "UPDATE tbl_user SET phone='$nphone',name='$nname',school='$nschool' WHERE email = '$username'";
                }
            }
            if (isset($_FILES['fileToUpload']['name'])) {

                uploadImage($username);
            }

            $conn->exec($sqlupdate);
            echo "<script>alert('Update successful')</script>";
            echo "<script>window.location.replace('../php/login.php')</script>";
        } else {
            echo "<script> alert('Current password do not match')</script>";
        }
    }
} else {
    echo "<script> alert('Session not available. Please login')</script>";
    echo "<script> window.location.replace('../php/login.php')</script>";
}

function uploadImage($email)
{
    $target_dir = "../images/profile/";
    $target_file = $target_dir . $email . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Main Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/depositori.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="header">
        <h1>Depository for Exam Questions</h1>
        <p>Application for JPN Kedah.</p>

    </div>
    <div class="topnavbar" id="myTopnav">
        <a href="depository.php">Depository</a>
        <a href="mydepository.php">My Depository</a>
        <a href="profile.php">My Profile</a>
        <a href="contactus.php">Contact Us</a>
        <a href="../php/login.php" onclick="logout()" class="right">Logout</a>
        <a href="javascript:void(0);" class="icon" onclick="mytopnavFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    <div class="main">
        <center>
            <div class="container">

                <form name="updateprofileForm" action="profile.php" onsubmit="return validateUpdForm()" method="post" enctype="multipart/form-data">
                    <div class="row-single">
                        <img class="imgselection" class="circular--portrait" src="../images/profile/<?php echo $username ?>.png ?" ><br>
                        <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload" accept="image/*"><br>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="idname" name="name" placeholder="Your name.." value="<?php echo $name; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Email</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="idemail" name="email" placeholder="Your email.." value="<?php echo $username; ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lphone">Phone</label>
                        </div>
                        <div class="col-75">
                            <input type="tel" id="idphone" name="phone" placeholder="Your phone number.." value="<?php echo $phone; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="school">School</label>
                        </div>
                        <div class="col-75">
                            <?php echo "<select name='school' id='idschool' value=$school required>
                            <option value=''>Please select your school</option>
                            <option value='SK Alor Setar'" . ($school == 'SK Alor Setar' ? ' selected' : '') . ">SK Alor Setar</option>
                            <option value='SK Batu Hampar'" . ($school == 'SK Batu Hampar' ? ' selected' : '') . ">SK Batu Hampar</option>
                            <option value='SK Titi Gajah'" . ($school == 'SK Titi Gajah' ? ' selected' : '') . ">SK Titi Gajah</option>
                            <option value='SK Taman Aman'" . ($school == 'SK Taman Aman' ? ' selected' : '') . ">SK Taman Aman</option>
                            <option value='SK (Felda) Bukit Tangga'" . ($school == 'SK (Felda) Bukit Tangga' ? ' selected' : '') . ">SK (Felda) Bukit Tangga</option>
                        </select>"
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lpassword">Current Password</label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="idpassa" name="oldpassword" placeholder="Current password.." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lpassword">New Password</label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="idpassb" name="newpassworda" placeholder="Enter new password to update">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lpassword">New Password</label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="idpassc" name="newpasswordb" placeholder="Re-enter new password to update">
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" name="submit" value="Submit">
                    </div>
            </div>

            </form>
        </center>
    </div>


    </div>

    <div class="bottomnavbar">
        <a href="../index.html">Home</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
    </div>
</body>

</html>