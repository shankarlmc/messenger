<?php 
include"config/db-connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    $output = json_encode(
            array(
                'type' => 'error',
                'text' => 'Request must come from Ajax'
    ));

    die($output);
}

//check $_POST vars are set, exit if any missing
if (!isset($_POST["sender"]) && !isset($_POST["receiver"])) {
    $output = json_encode(array('type' => 'error', 'text' => 'Sender and receiver is not specified!'));
    die($output);
}

//Sanitize input data using PHP filter_var().
$message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);
$link = filter_var(trim($_POST["link"]), FILTER_SANITIZE_STRING);
$sender = filter_var(trim($_POST["sender"]), FILTER_SANITIZE_STRING);
$receiver = filter_var(trim($_POST["receiver"]), FILTER_SANITIZE_STRING);

$sql = "INSERT INTO `messages`(`sent_by`, `sent_to`, `message`, `link`, `sticker`, `media`) VALUES('$sender','$receiver','$message','$link','','')";
//$sentMail = true;
if(mysqli_query($conn,$sql)){
	$output = json_encode(array('type' => 'message', 'text' => 'message send successfully'));
    die($output);
}else{
	$output = json_encode(array('type' => 'error', 'text' => 'could not send message'.$sql));
    die($output);
}

}
 ?>