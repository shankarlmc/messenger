<?php
    session_start();

    include"db-connection.php";
    include"functions.php";

    if(isset($_FILES["myFiles"])){
      foreach ($_FILES["myFiles"]["tmp_name"] as $key => $value) {
        $thumb_file_name__ = $_FILES["myFiles"]["name"][$key];
        $file_name__ = "/assets/images/messages/". $_FILES["myFiles"]["name"][$key];
        $target_path_ = "../assets/images/messages/" . basename($_FILES["myFiles"]["name"][$key]);
        // check extensions
        $extension = pathinfo($_FILES["myFiles"]["name"][$key], PATHINFO_EXTENSION);
        //first move file to destination
        move_uploaded_file($value, $target_path_);

        if (in_array($extension, ['JPG', 'jpg', 'jpeg', 'JPEG','PNG','png'])) {
          //select which image you want to crop
          //you can also set the temp location of file as target path
            make_thumb($target_path_,"../assets/images/messages/thumb_".$thumb_file_name__, 300);
        }
      }
    }else{
      $thumb_file_name__ = '';
    }

    $current_user = $_SESSION['authenticated_user_id'];
    $receiver = mysqli_real_escape_string($conn, $_POST['__receiver__user']);

    $message = $_POST['message'];

    $regex = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    if(preg_match($regex, $message, $url)) {
    	$create__url = '<a href="'.$url[0].'" target="_blank" style="color:yellow">goto link</a>';
    	$modefied__text = str_replace($url[0], $create__url, $message);
      $message = mysqli_real_escape_string($conn, $modefied__text);
    }
    else {
      $message = mysqli_real_escape_string($conn, $message);
      $message = htmlspecialchars($message);
    }
    $message = convert_string("encrypt", $message);

    if(!empty($message)){
        $sql = mysqli_query($conn, "INSERT INTO messages (`sent_by`, `sent_to`, `message`, `media`)
                                    VALUES ('{$current_user}', '{$receiver}', '{$message}', '{$thumb_file_name__}')") or die();

    }


?>
