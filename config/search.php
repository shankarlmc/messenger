<?php
    session_start();
    include"db-connection.php";
    include'functions.php';

    $current_user = $_SESSION['authenticated_user_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $sql = "SELECT * FROM details WHERE NOT auth_id = '{$current_user}' AND (full_name LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
         include_once "user-result.php";
    }else{
        $output .= '<h4>No user found related to your search term <b>'.convert_string("decrypt", $searchTerm).'</b></h4>';
    }
    echo $output;
?>
