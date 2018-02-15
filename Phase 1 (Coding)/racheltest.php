
<?php
session_start();
$servername = "sql12.freemysqlhosting.net";
$username = "sql12218230";
$password = "X2gGvTDMZH";
$dbname = "sql12218230";
$conn = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}

echo $_SESSION['UAC'];

?>