<?php 

$hostname = "localhost";
$username = "root";
$password = "";
$db_name  = "tzm_thrift_shop";

$conn = mysqli_connect($hostname, $username, $password, $db_name);

// Memeriksa Hubungan
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>