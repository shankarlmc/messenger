<?php
    session_start();
    include"db-connection.php";

    $user_id = mysqli_real_escape_string($conn, $_POST['userid']);
    $output = '';
    $sql = "UPDATE `authentication` SET `is_verified`='1' WHERE sha1(auth_id) = '{$user_id}'";

    if(mysqli_query($conn, $sql)){
      $output .= "User is registered";
    }else{
      $output .= "Error Occured while updating";
    }

?>
