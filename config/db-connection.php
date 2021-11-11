<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "messenger";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	$output__ = json_encode(
        array(
            'type' => 'error',
            'text' => 'Connection failed:'. mysqli_connect_error(). '!'
	));
    die($output__);
}else{
	$output__ = json_encode(
        array(
            'type' => 'success',
            'text' => 'successfully connected!'
	));
}
?>
