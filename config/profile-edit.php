<?php
    session_start();

    include"db-connection.php";
    include"functions.php";
    $current_user = $_SESSION['authenticated_user_id'];
    $output = '';
    if(isset($_FILES["myFiles"])){
      foreach ($_FILES["myFiles"]["tmp_name"] as $key => $value) {
        $thumb_file_name__ = bin2hex(random_bytes(10));
        $target_path_ = $_FILES["myFiles"]["tmp_name"][$key];
        $extension = pathinfo($_FILES["myFiles"]["name"][$key], PATHINFO_EXTENSION);
        $thumb_file_name__ = $thumb_file_name__.".".$extension;
        if (in_array($extension, ['JPG', 'jpg', 'jpeg', 'JPEG','PNG','png'])) {
            make_thumb($target_path_,"../assets/images/avtar/".$thumb_file_name__, 300);
        }
        $thumb_file_name__ = "/assets/images/avtar/".$thumb_file_name__;
        if (!in_array($extension, ['JPG', 'jpg', 'jpeg', 'JPEG','PNG','png'])) {
            $thumb_file_name__ = '';
            $output .= json_encode(array('type' => 'error', 'text' => 'could not change the profile pic'));
        }
      }
    }else{
      $thumb_file_name__ = '';
      $output .= json_encode(array('type' => 'error', 'text' => 'could not change the profile pic'));
    }

    if(!empty($thumb_file_name__)){
        $sql = mysqli_query($conn, "UPDATE `details` SET `profile_pic`='$thumb_file_name__' WHERE `auth_id` = '{$current_user}'") or die();
        $output .= json_encode(array('type' => 'success', 'text' => 'profile pic updated successfully'));
    }else{
      $output .= json_encode(array('type' => 'error', 'text' => 'could not change the profile pic'));
    }

    echo $output;
?>
