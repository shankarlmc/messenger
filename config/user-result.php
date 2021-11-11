<?php

include"db-connection.php";

  $session_id = $_SESSION['authenticated_user_id'];

   while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (sent_by = '{$row['auth_id']}' OR sent_to = '{$row['auth_id']}') AND (sent_to = '{$current_user}'
                OR sent_by = '{$current_user}') ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        if(mysqli_num_rows($query2) > 0){
            $result = convert_string("decrypt", $row2['message']);
        }else{
            $result ="Start a conversation.....";
        }
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

        ($current_user == $row2['sent_by']) ? $you = "You: " : $you = "";

        ($row['active_status'] == "Offline") ? $offline = "offline" : $offline = "online";

        if(isset($_COOKIE["active"])){
          $active_user_id = $_COOKIE["active"];
        }else{
          $active_user_id = '';
        }
        ($active_user_id == $row['auth_id']) ? $active__class = "active": $active__class = "";

        $user_filter_query = "SELECT auth_id, is_verified from authentication where sha1(auth_id) = '{$row["auth_id"]}' ";
        $check_connection = mysqli_query($conn, $user_filter_query);
        $users = mysqli_fetch_assoc($check_connection);
        if(mysqli_num_rows($check_connection) > 0){
            $user_verification_status__ = $users['is_verified'];
            if($user_verification_status__ == '0'){
              $output .= '
              <li class="user_id '.$active__class.'" >
                 <a href="javascript:void(0)">
                   <div class="chat-box">
                      <div class="profile '.$offline.'">
                        <img class="rounded-circle bg-img" width="60px" height="60px" src="http://localhost/messenger'.$row['profile_pic'].'" alt="Avatar"/>
                      </div>
                      <div class="details">
                         <h5>'.$row['full_name'].'</h5>
                         <h6>'.$you . $msg.'</h6>
                      </div>
                      <div class="date-status">
                         <h6>'.$row2['date'].'</h6>
                         <button class="btn btn-info text-light btn-sm" value="'.sha1($users['auth_id']).'" onclick="approveUser(this.value)"><i class="fa fa-check"></i></button>
                      </div>
                   </div>
                 </a>
              </li>
            ';
          }else{
            $output .= '
            <li class="user_id '.$active__class.'" >
               <a href="http://localhost/messenger/messenger.php?messages='. $row['auth_id'].'">
                 <div class="chat-box">
                    <div class="profile '.$offline.'">
                      <img class="rounded-circle bg-img" width="60px" height="60px" src="http://localhost/messenger'.$row['profile_pic'].'" alt="Avatar"/>
                    </div>
                    <div class="details">
                       <h5>'.$row['full_name'].'</h5>
                       <h6>'.$you . $msg.'</h6>
                    </div>
                    <div class="date-status">
                       <h6>'.$row2['date'].'</h6>
                       <h6 class="font-success status"> Seen</h6>
                    </div>
                 </div>
               </a>
            </li>
          ';
          }
        }


    }

?>
