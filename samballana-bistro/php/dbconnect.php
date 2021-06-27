<?php
$servername = "sdb-f.hosting.stackcp.net";
$username = "samballana-313834a119";
$password = "Halim2021";
$dbname = "samballana-313834a119";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>