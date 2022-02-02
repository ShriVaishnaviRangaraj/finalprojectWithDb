<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname="garbage_locator";

$con=mysqli_connect($servername,$username,$password,$dbname);              

if ($con->connect_error) {
  //echo "DB Connection Failed" ;
  die("Connection failed: " . $con->connect_error);
}
//echo "Connected successfully";
 
?>