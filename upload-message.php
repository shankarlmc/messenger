<?php 
include"config/db-connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//check if its an ajax request, exit if not
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

    //exit script outputting json data
    $output = json_encode(
            array(
                'type' => 'error',
                'text' => 'Request must come from Ajax'
    ));

    die($output);
}

//check $_POST vars are set, exit if any missing
if (!isset($_POST["sticker"]) && !isset($_POST["sender"]) && !isset($_POST["receiver"])) {
    $output = json_encode(array('type' => 'error', 'text' => 'Input fields are empty!'));
    die($output);
}

//Sanitize input data using PHP filter_var().
$sticker = htmlspecialchars($_POST["sticker"]);
$sender = filter_var(trim($_POST["sender"]), FILTER_SANITIZE_EMAIL);
$receiver = filter_var(trim($_POST["receiver"]), FILTER_SANITIZE_STRING);

// //additional php validation
// if (strlen($username) < 4) { // If length is less than 4 it will throw an HTTP error.
//     $output = json_encode(array('type' => 'error', 'text' => 'Name is too short!'));
//     die($output);
// }
// if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) { //email validation
//     $output = json_encode(array('type' => 'error', 'text' => 'Please enter a valid email!'));
//     die($output);
// }
// if (strlen($message) < 5) { //check emtpy message
//     $output = json_encode(array('type' => 'error', 'text' => 'Too short message!'));
//     die($output);
// }
$sql = "INSERT INTO `messages`(`sent_by`, `sent_to`, `message`, `link`, `sticker`, `media`) VALUES('$sender','$receiver','','','$sticker','')";
//$sentMail = true;
if(mysqli_query($conn,$sql)){
	$output = json_encode(array('type' => 'message', 'text' => 'message send successfully'));
    die($output);
}else{
	$output = json_encode(array('type' => 'error', 'text' => 'could not send message'.$sql));
    die($output);
}
// if (!$sentMail) {
//     $output = json_encode(array('type' => 'error', 'text' => 'Could not send mail! Please contact administrator.'));
//     die($output);
// } else {
//     $output = json_encode(array('type' => 'message', 'text' => 'Hi ' . $username . ' Thank you for your email'));
//     die($output);
// }
}
 ?>