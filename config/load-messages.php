<?php
    session_start();
    if(isset($_SESSION['authenticated_user_id'])){
        include"db-connection.php";
        include"functions.php";

        $sender = $_SESSION['authenticated_user_id'];
        $receiver = mysqli_real_escape_string($conn, $_POST['receiver']);

        $type = mysqli_real_escape_string($conn, $_POST['msg_type']);

        if($type === 'unread'){
          $status = 0;
        } else {
          $status = 1;
        }


        $output = "";
        $sql = "SELECT `sent_by`,`sent_to`,`message`,`sticker`,`media`, `time`,`full_name`,`profile_pic` FROM messages LEFT JOIN details ON details.auth_id = messages.sent_by
                WHERE status = '$status' AND ((sent_by = '{$sender}' AND sent_to = '{$receiver}')
                OR (sent_by = '{$receiver}' AND sent_to = '{$sender}')) ORDER BY msg_id asc";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['sent_by'] === $sender){
                    $output .= '
                    <li class="msg-list replies">
                       <div class="media">
                          <div class="media-body">
                             <div class="contact-name">
                                <ul class="msg-box">
                                   <li class="msg-setting-main">
                                      <h5>'.convert_string("decrypt", $row['message']).'</h5>
                                   </li>
                                   ';
                                   if($row['media'] != ''){
                                     $extension = pathinfo($row['media'], PATHINFO_EXTENSION);
                                     if (in_array($extension, ['JPG', 'jpg', 'jpeg', 'JPEG','PNG','png'])) {
                                       $output .= '
                                       <li class="msg-setting-main">
                                          <ul class="auto-gallery">
                                             <li class="bg-size" >
                                              <img class="bg-img" style="width:100%;height:auto" src="http://localhost/messenger/assets/images/messages/thumb_'.$row["media"].'" alt="Avatar"  onclick="previewImage(this.src)"/></li>
                                          </ul>
                                       </li>
                                       ';
                                     }if (in_array($extension, ['gif'])) {
                                       $output .= '
                                       <li class="msg-setting-main">
                                          <ul class="auto-gallery">
                                             <li class="bg-size">
                                              <img style="width:100%;height:auto" class="bg-img" src="http://localhost/messenger/assets/images/messages/'.$row["media"].'" alt="Avatar" onclick="previewImage(this.src)"/>
                                             </li>
                                          </ul>
                                       </li>
                                       ';
                                     }
                                     if (in_array($extension, ['PDF', 'pdf', 'docx', 'DOCX','xlsx','eupb','zip'])) {
                                       $output .= '
                                       <li class="msg-setting-main">
                                         <div class="document"><i class="fa fa-file font-primary"></i>
                                           <div class="details">
                                             <h5>'.convert_string("decrypt", $row['message']).'</h5>
                                           </div>
                                           <div class="icon-btns"><a class="icon-btn btn-outline-light" style="color:white" href="http://localhost/messenger/assets/images/messages/'.$row["media"].'" target="_blank"><b>&#8595;</b></a></div>
                                         </div>
                                        </li>
                                       ';
                                     }
                                   }
                                  $output .= '
                                </ul>
                                <h6>'.date_format(date_create($row["time"]), "h : i a").'</h6>
                             </div>
                          </div>
                       </div>

                    </li>

                    ';
                }else{
                    $output .= '
                    <li class="msg-list sent">
                       <div class="media">
                          <div class="profile mr-4">
                            <img class="rounded-circle bg-img" width="40px" height="40px" src="http://localhost/messenger'.$row['profile_pic'].'"" alt="Avatar"/>
                          </div>
                          <div class="media-body">
                             <div class="contact-name">
                                <h5>'.convert_string("decrypt", $row['full_name']).'</h5>
                                <h6>'.date_format(date_create($row["time"]), "h : i a").'</h6>
                                <ul class="msg-box">
                                   <li class="msg-setting-main">
                                      <h5>'.convert_string("decrypt", $row['message']).'</h5>
                                   </li>
                                   ';
                                   if($row['media'] != ''){
                                     $extension = pathinfo($row['media'], PATHINFO_EXTENSION);
                                     if (in_array($extension, ['JPG', 'jpg', 'jpeg', 'JPEG','PNG','png'])) {
                                       $output .= '
                                       <li class="msg-setting-main">
                                          <ul class="auto-gallery">
                                             <li class="bg-size" >
                                             <img class="bg-img" style="width:100%;height:auto" src="http://localhost/messenger/assets/images/messages/thumb_'.$row["media"].'" onclick="previewImage(this.src)" alt="Avatar"/></li>
                                          </ul>
                                       </li>
                                       ';
                                     }if (in_array($extension, ['gif'])) {
                                       $output .= '
                                       <li class="msg-setting-main">
                                          <ul class="auto-gallery">
                                             <li class="bg-size">
                                              <img style="width:100%;height:auto" class="bg-img" src="http://localhost/messenger/assets/images/messages/'.$row["media"].'" alt="Avatar" onclick="previewImage(this.src)"/>
                                             </li>
                                          </ul>
                                       </li>
                                       ';
                                     }if (in_array($extension, ['PDF', 'pdf', 'docx', 'DOCX','xlsx','eupb','zip'])) {
                                       $output .= '
                                       <li class="msg-setting-main">
                                         <div class="document"><i class="fa fa-file font-primary"></i>
                                           <div class="details">
                                             <h5>'.convert_string("decrypt", $row['message']).'</h5>
                                           </div>
                                           <div class="icon-btns"><a class="icon-btn btn-outline-light" style="color:white" href="http://localhost/messenger/assets/images/messages/'.$row["media"].'" target="_blank"><b>&#8595;</b></a></div>
                                         </div>
                                        </li>
                                       ';
                                     }
                                   }
                                  $output .= '
                                </ul>
                             </div>
                          </div>
                       </div>
                    </li>
                    ';
                }
            }
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }

?>
