<?php
    session_start();
    include_once "db-connection.php";
    include'functions.php';
    $current_user = $_SESSION['authenticated_user_id'];
    $sql = "SELECT * FROM details WHERE NOT auth_id = '{$current_user}' ORDER BY details_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "<h4>No users are available to chat</h4>";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "user-result.php";
    }
    echo $output;
?>
