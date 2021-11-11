<?php
    session_start();
    if(isset($_SESSION['authenticated_user_id'])){
        include"db-connection.php";

        $sender = $_SESSION['authenticated_user_id'];
        $receiver = mysqli_real_escape_string($conn, $_POST['receiver']);

        $sql = "UPDATE  messages SET status = 1 WHERE (sent_by = '{$sender}' AND sent_to = '{$receiver}')
                OR (sent_by = '{$receiver}' AND sent_to = '{$sender}')";
        $query = mysqli_query($conn, $sql);
        if($query){
          echo "message status updated";
        }

    }else{
        header("location: ../login.php");
    }

?>
