<?php
session_start();
header('Content-Type: text/html; charset=ISO-8859-1');
if(!isset($_SESSION['authenticated_user_id']) && !isset($_SESSION['authenticated_user_email']) && !isset($_SESSION['unique_token']) && !isset($_SESSION['user_logged_in_time'])){
    header('location:/messenger/login.php');
    session_destroy();
}
$session_id = $_SESSION['authenticated_user_id'];
include'config/db-connection.php';
include'config/functions.php';

if(isset($_GET['messages'])){
  setcookie('active', $_GET['messages'], time() + (60*60), '/');
}else{
  setcookie('active', '', time() + (60*60), '/');
}
$query_for_name = "SELECT `full_name` from `details` where auth_id = '$session_id'";
$check_query = mysqli_query($conn, $query_for_name);
if(mysqli_num_rows($check_query) > 0){
    while($row = mysqli_fetch_assoc($check_query)){
      $f_name = $row['full_name'];
    }
  }

 ?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Chat | <?php echo $f_name; ?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <link rel="icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
      <link rel="shortcut icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800&amp;display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600&amp;display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen" id="color">
      <link rel="stylesheet" type="text/css" href="assets/css/magnific-popup.css">
   </head>
   <body class="main-page dark">
     <input type="hidden" name="sender" class="sender__" value="<?php echo $_SESSION['authenticated_user_id'] ?>">
      <div class="chitchat-container sidebar-toggle <?php if(isset($_GET['messages'])){echo'mobile-menu';} if(isset($_GET['profile'])){echo'mobile-menu';}?>">
         <aside class="chitchat-left-sidebar left-disp">
            <div class="recent-default dynemic-sidebar active">
               <!-- <div class="recent">
                  <div class="theme-title">
                     <div class="media">
                        <div>
                           <h2>Recent</h2>
                           <h4>Chat from your friends &#128536;</h4>
                        </div>
                        <div class="media-body"><a class="icon-btn btn-outline-light button-effect pull-right mobile-back" href="#"><i class="ti-angle-right"></i></a><a class="icon-btn btn-outline-light button-effect pull-right mainnav" href="#"><i class="ti-layout-grid2"></i></a></div>
                     </div>
                  </div>
                  <div class="recent-slider recent-chat owl-carousel owl-theme">
                     <div class="item">
                        <div class="recent-box">
                           <div class="dot-btn dot-danger grow"></div>
                           <div class="recent-profile">
                              <img class="bg-img" src="assets/images/avtar/1.jpg" alt="Avatar"/>
                              <h6> John deo</h6>
                           </div>
                        </div>
                     </div>

                     <div class="item">
                        <div class="recent-box">
                           <div class="dot-btn dot-warning grow"></div>
                           <div class="recent-profile">
                              <img class="bg-img" src="assets/images/avtar/2.jpg" alt="Avatar"/>
                              <h6> Jpny</h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> -->
               <div class="chat custom-scroll">
                  <ul class="chat-cont-setting">
                     <li>
                        <a class="icon-btn btn-light button-effect mode" href="#" data-tippy-content="Theme Mode" data-intro="Change mode">
                        <i class="fa fa-moon-o"></i>
                        </a>
                     </li>
                     <li>
                        <a class="icon-btn btn-light" href="logout.php" data-tippy-content="LogOut"> <i class="fa fa-power-off">  </i>
                        </a>
                     </li>
                  </ul>
                  <div class="theme-title">
                     <div class="media">
                        <div>
                           <h2>Chat</h2>
                           <h4>Start New Conversation</h4>
                        </div>
                        <div class="media-body text-right">
                          <a class="icon-btn btn-outline-light btn-sm search contact-search" href="#"> <i data-feather="search"></i>
                          </a>
                            <form class="form-inline search-form">
                              <div class="form-group">
                                <input class="form-control-plaintext" type="search" placeholder="Search by name.."/>
                                <div class="icon-close close-search">
                                </div>
                              </div>
                            </form>
                            <a class="icon-btn btn-primary btn-fix chat-cont-toggle outside" href="#">
                              <i data-feather="plus"></i>
                            </a>
                        </div>
                     </div>
                  </div>
                  <div class="theme-tab tab-sm chat-tabs">
                     <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" data-to="chat-content">
                          <a class="nav-link <?php if(isset($_GET['messages'])){echo'active';} ?>"  href="messenger.php" role="tab" aria-controls="chat" aria-selected="true"><i data-feather="message-square"> </i>Chat</a>
                        </li>
                        <li class="nav-item"><a class="nav-link button-effect" id="direct-tab" data-toggle="tab" href="#direct" role="tab" aria-controls="direct" aria-selected="false" data-to="chating">Direct</a>
                        </li>
                        <li class="nav-item" data-to="contact-content">
                          <a class="nav-link <?php if(isset($_GET['profile'])){echo'active';} ?>" href="messenger.php?profile=<?php echo $session_id ?>" role="tab" aria-controls="contact" aria-selected="false"> <i data-feather="users"> </i>Profile</a>
                        </li>
                     </ul>
                     <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                           <div class="theme-tab">
                              <div class="tab-content" id="myTabContent1">
                                 <div class="tab-pane fade show active" id="direct" role="tabpanel" aria-labelledby="direct-tab">
                                    <ul class="chat-main">
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </aside>
         <div class="chitchat-main small-sidebar" id="content">
           <?php
           if(isset($_GET['messages'])){
             $hash_user_id = mysqli_real_escape_string($conn, $_GET['messages']);
             $sql = mysqli_query($conn, "SELECT * FROM details WHERE auth_id = '{$hash_user_id}'");
             if(mysqli_num_rows($sql) > 0){
               $unique_row = mysqli_fetch_assoc($sql);

               ($unique_row['active_status'] == "Offline") ? $offline = "offline" : $offline = "online";
             }else{
                echo "<script>location.href='messenger.php'</script>";
             }

            ?>
            <div class="chat-content tabto active">

              <div class="messages custom-scroll active" id="" chat-details="">
                 <div class="contact-details" style="top:2px">
                    <div class="row">
                       <div class="col-7" >
                          <div class="media left">
                             <div class="media-left mr-3">
                                <a href="messenger.php?profile=<?php echo $hash_user_id ?>">
                                  <div class="profile <?php echo $offline ?>">
                                    <img class="rounded-circular bg-img" width="66" height="66" src="http://localhost/messenger<?php echo $unique_row['profile_pic'] ?>" alt="Avatar"/>

                                  </div>
                                </a>
                             </div>
                             <div class="media-body">
                                <h5><?php echo ucfirst(convert_string("decrypt", $unique_row['auth_name'])) ?></h5>
                                <?php
                                if ($unique_row['active_status'] == 'Offline') {
                                  echo '<div class="badge badge-warning">'.$unique_row['active_status'].'</div>';
                                }else{
                                  echo '<div class="badge badge-success">'.$unique_row['active_status'].'</div>';
                                }
                                 ?>

                             </div>
                             <span class="ml-2 mobile-sidebar font-weight-bold" style="color:#fff"><?php echo ucfirst(convert_string("decrypt", $unique_row['auth_name'])) ?></span>
                             <div class="media-right">
                               <span>
                                 <a class="ml-1 mr-2 icon-btn btn-light button-effect mobile-sidebar font-weight-bold" href="messenger.php">
                                 <i data-feather="chevron-left"></i>
                                </a>
                              </span>

                             </div>
                          </div>
                       </div>
                       <div class="col">
                          <ul class="calls text-right">

                             <li><a class="icon-btn btn-light button-effect" href="#" data-tippy-content="Quick Audio Call" data-toggle="modal" data-target="#audiocall"><i data-feather="phone"></i></a></li>
                             <li><a class="icon-btn btn-light button-effect" href="#" data-tippy-content="Quick Video Call" data-toggle="modal" data-target="#videocall"><i data-feather="video"></i></a></li>
                             <li class="chat-friend-toggle">
                                <a class="icon-btn btn-light bg-transparent button-effect outside" href="#" data-tippy-content="Quick action"><i data-feather="more-vertical"></i></a>
                                <div class="chat-frind-content">
                                   <ul>
                                      <li class="nav-item">
                                         <a class="icon-btn btn-outline-primary button-effect btn-sm" href="messenger.php?profile=<?php echo $hash_user_id ?>" role="tab" aria-controls="contact" aria-selected="false"><i data-feather="user"></i></a>
                                         <h5>Profile</h5>
                                      </li>
                                      <li>
                                         <a class="icon-btn btn-outline-success button-effect btn-sm" href="#"><i data-feather="plus-circle"></i></a>
                                         <h5>Archive</h5>
                                      </li>
                                      <li>
                                         <a class="icon-btn btn-outline-danger button-effect btn-sm" href="#"><i data-feather="trash-2"></i></a>
                                         <h5>Delete</h5>
                                      </li>
                                   </ul>
                                </div>
                             </li>
                          </ul>
                       </div>
                    </div>
                 </div>
                 <div class="contact-chat">
                    <ul class="chatappend">
                    </ul>
                 </div>
              </div>

              <div class="message-input">
                 <form action="#" class="messenger__form" method="POST">
                    <div class="wrap emojis-main">
                       <a class="icon-btn btn-outline-primary button-effect mr-3 toggle-sticker outside" href="#">
                          <svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="2158px" height="2148px" viewbox="0 0 2158 2148" enable-background="new 0 0 2158 2148" xml:space="preserve">
                             <path fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke="#000000" stroke-width="60" stroke-miterlimit="10" d="M699,693                        c0,175.649,0,351.351,0,527c36.996,0,74.004,0,111,0c18.058,0,40.812-2.485,57,1c11.332,0.333,22.668,0.667,34,1                        c7.664,2.148,20.769,14.091,25,20c8.857,12.368,6,41.794,6,62c0,49.329,0,98.672,0,148c175.649,0,351.351,0,527,0                        c0-252.975,0-506.025,0-759C1205.692,693,952.308,693,699,693z"></path>
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M886,799c59.172-0.765,93.431,25.289,111,66c6.416,14.867,14.612,39.858,9,63                        c-2.391,9.857-5.076,20.138-9,29c-15.794,35.671-47.129,53.674-90,63c-20.979,4.563-42.463-4.543-55-10                        c-42.773-18.617-85.652-77.246-59-141c10.637-25.445,31.024-49,56-60c7.999-2.667,16.001-5.333,24-8                        C877.255,799.833,882.716,801.036,886,799z"></path>
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M1258,799c59.172-0.765,93.431,25.289,111,66c6.416,14.867,14.612,39.858,9,63                        c-2.391,9.857-5.076,20.138-9,29c-15.794,35.671-47.129,53.674-90,63c-20.979,4.563-42.463-4.543-55-10                        c-42.773-18.617-85.652-77.246-59-141c10.637-25.445,31.024-49,56-60c7.999-2.667,16.001-5.333,24-8                        C1249.255,799.833,1254.716,801.036,1258,799z"></path>
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M1345,1184c-0.723,18.71-11.658,29.82-20,41c-18.271,24.489-50.129,37.183-83,47                        c-7.333,1-14.667,2-22,3c-12.013,2.798-33.636,5.15-44,3c-11.332-0.333-22.668-0.667-34-1c-15.332-3-30.668-6-46-9                        c-44.066-14.426-80.944-31.937-110-61c-22.348-22.353-38.992-45.628-37-90c0.667,0,1.333,0,2,0c9.163,5.585,24.723,3.168,36,6                        c26.211,6.583,54.736,7.174,82,14c34.068,8.53,71.961,10.531,106,19c9.999,1.333,20.001,2.667,30,4c26.193,6.703,54.673,7.211,82,14                        C1304.894,1178.445,1325.573,1182.959,1345,1184z"></path>
                             <polygon fill-rule="evenodd" clip-rule="evenodd" points="668.333,1248.667 901.667,1482 941.667,1432 922.498,1237.846                         687,1210.667 "></polygon>
                          </svg>
                       </a>
                       <div class="dot-btn dot-primary mr-3"><a class="icon-btn btn-outline-primary button-effect toggle-emoji" href="#"><i data-feather="smile"></i></a></div>

                       <textarea  class="form-control message__area" type="text" placeholder="Write your message..." name="message" autocomplete="off"  rows="1" cols="80"></textarea>
                       <input id="myMedia" type="file" name="media" style="display:none"/>
                       <input type="hidden" class="current_user" name="__receiver__user" value="<?php echo $_GET['messages'] ?>">
                       <a class="icon-btn btn-outline-primary button-effect mr-3 ml-3 file-uploader" href="#"><i data-feather="image"></i><input type="file"></a>
                       <button type="submit" class="icon-btn btn-primary" id="__send__message"><i data-feather="send"></i></button>

                       <div class="emojis-contain">
                          <div class="emojis-sub-contain custom-scroll active">
                             <ul>
                                <li>&#128512;</li>
                                <li>&#128513;</li>
                                <li>&#128514;</li>
                                <li>&#128515;</li>
                                <li>&#128516;</li>
                                <li>&#128517;</li>
                                <li>&#128518;</li>
                                <li>&#128519;</li>
                                <li>&#128520;</li>
                                <li>&#128521;</li>
                                <li>&#128522;</li>
                                <li>&#128523;</li>
                                <li>&#128524;</li>
                                <li>&#128525;</li>
                                <li>&#128526;</li>
                                <li>&#128527;</li>
                                <li>&#128528;</li>
                                <li>&#128529;</li>
                                <li>&#128530;</li>
                                <li>&#128531;</li>
                                <li>&#128532;</li>
                                <li>&#128533;</li>
                                <li>&#128534;</li>
                                <li>&#128535;</li>
                                <li>&#128536;</li>
                                <li>&#128537;</li>
                                <li>&#128538;</li>
                                <li>&#128539;</li>
                                <li>&#128540;</li>
                                <li>&#128541;</li>
                                <li>&#128542;</li>
                                <li>&#128543;</li>
                                <li>&#128544;</li>
                                <li>&#128545;</li>
                                <li>&#128546;</li>
                                <li>&#128547;</li>
                                <li>&#128549;</li>
                                <li>&#128550;</li>
                                <li>&#128551;</li>
                                <li>&#128552;</li>
                                <li>&#128553;</li>
                                <li>&#128554;</li>
                                <li>&#128555;</li>
                                <li>&#128557;</li>
                                <li>&#128558;</li>
                                <li>&#128559;</li>
                                <li>&#128560;</li>
                                <li>&#128561;</li>
                                <li>&#128562;</li>
                                <li>&#128563;</li>
                                <li>&#128564;</li>
                                <li>&#128565;</li>
                                <li>&#128566;</li>
                                <li>&#128567;</li>
                                <li>&#128568;</li>
                                <li>&#128569;</li>
                                <li>&#128570;</li>
                                <li>&#128571;</li>
                                <li>&#128572;</li>
                                <li>&#128573;</li>
                                <li>&#128574;</li>
                                <li>&#128576;                    </li>
                                <li>&#128579;                    </li>
                             </ul>
                          </div>
                       </div>
                       <div class="sticker-contain" sender="<?php echo $session_id ?>" receiver="2">
                          <div class="sticker-sub-contain custom-scroll active" >
                             <ul>
                                <li ><a href="#"><img class="img-fluid" src="assets/images/sticker/1.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/2.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/3.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/3.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/4.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/5.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/6.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/7.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/8.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/9.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/10.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/11.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/12.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/13.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/14.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/15.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/16.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/17.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/18.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/19.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/20.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/21.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/22.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/23.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/24.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/25.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/26.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/27.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/28.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/29.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/30.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/31.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/32.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/33.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/34.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/35.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/36.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/37.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/38.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/39.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/40.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/41.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/42.gif" alt="sticker"/></a></li>
                                <li><a href="#"><img class="img-fluid" src="assets/images/sticker/43.gif" alt="sticker"/></a></li>
                             </ul>
                          </div>
                       </div>

                    </div>
                 </form>
              </div>

            </div>
          <?php } ?>

            <?php
            if(isset($_GET['profile'])){
              $user_profile_id = mysqli_real_escape_string($conn, $_GET['profile']);
              $sql = mysqli_query($conn, "SELECT * FROM details WHERE auth_id = '{$user_profile_id}'");
              if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
                $full_name = $row['full_name'];
                $gender = $row['gender'];
                $mob_num = $row['mobile_num'];
                $birthday = $row['birthday'];
                $address = $row['address'];
                $personality = $row['personality'];
                $profile_pic = $row['profile_pic'];
              }else{
                 header("location: messenger.php");
              }

            ?>
            <!-- start contact details -->
            <div class="contact-content tabto active">
               <div class="contact-sub-content">
                  <a class="icon-btn btn-outline-primary mobile-back mb-3" href="messenger.php"><i class="ti-angle-left"></i></a>
                  <div class="row">
                     <div class="col-sm-5">
                        <div class="user-profile">
                           <div class="user-content">
                              <img class="img-fluid bg-icon" id="current__profile__pic" src="http://localhost/messenger/<?php echo $profile_pic ?>" alt="user-img"/>
                              <h3><?php echo strtoupper( $full_name) ?></h3>
                                <?php if($session_id == $user_profile_id){?>
                              <form class="profile_edit_form__" action="" method="post">
                                <div class="call-status">

                                  <input hidden type="file" name="profile_pic" id="profile_pic" onchange="changeProfile(event)">
                                  <div class="icon-btn btn-outline-danger button-effect btn-sm" id="file-selector"><i data-feather="camera"></i>
                                  </div>
                                </div>
                              </form>
                            <?php } ?>
                           </div>
                        </div>
                        <div class="personal-info-group">
                          <div class="social-info-group custom-scroll active" style="height:100px;overflow-y:scroll">
                            <ul class="document-list">
                              <li><i class="ti-folder font-danger"></i>
                                <h5>Simple_practice_project-zip</h5>
                              </li>
                              <li><i class="ti-write font-success"></i>
                                <h5>Word_Map-jpg</h5>
                              </li>
                              <li><i class="ti-zip font-primary"></i>
                                <h5>Latest_Design_portfolio.pdf</h5>
                              </li>
                            </ul>
                          </div>
                        </div>

                        <div class="media-gallery portfolio-section grid-portfolio">
                          <div class="">
                            <div class="block-content custom-scroll active" style="height:200px;overflow-y:scroll;overflow-x:hidden">

                              <div class="row share-media zoom-gallery">
                                <div class="col-4">
                                  <div class="media-small">
                                    <div class="overlay">
                                      <div class="border-portfolio">
                                        <a href="assets/images/gallery/4.jpg">
                                          <div class="overlay-background"><i class="ti-plus" aria-hidden="true"></i></div>
                                          <img class="img-fluid bg-img" src="assets/images/gallery/4.jpg" alt="portfolio-image"/></a>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="media-small  ">
                                    <div class="overlay">
                                      <div class="border-portfolio"><a href="assets/images/gallery/5.jpg">
                                          <div class="overlay-background"><i class="ti-plus" aria-hidden="true"></i></div>
                                          <img class="img-fluid bg-img" src="assets/images/gallery/5.jpg" alt="portfolio-image"/></a>
                                      </div>
                                    </div>
                                  </div>
                                </div>


                              </div>
                            </div>
                          </div>
                        </div>
                     </div>

                     <div class="col-sm-7">
                        <div class="personal-info-group">
                          <?php if($session_id == $user_profile_id){?>
                          <a class="icon-btn btn-primary float-right" style="margin-top:-18px" href="messenger.php?profile=<?php echo $user_profile_id ?>&edit=true">
                            <i data-feather="edit"></i>
                          </a>
                        <?php } ?>
                           <h3>contact info</h3>
   <?php if(isset($_GET['edit'])){
     if($_GET['edit'] == 'true'){
     if($session_id == $user_profile_id){?>
                           <ul class="basic-info custom-scroll active">
                              <li>
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="" value="">
                              </li>
                              <li>
                                <label for="name">Gender</label>
                                <select class="form-select form-control" name="gender">
                                  <option selected>Please select</option>
                                  <option value="male">Male</option>
                                  <option value="female">Female</option>
                                  <option value="others">Others</option>
                                </select>
                              </li>
                              <li>
                                <label for="contact__num">Contact Num.</label>
                                <input type="text" class="form-control" name="contact_num" value="">
                              </li>
                              <li>
                                <label for="name">Address</label>
                                <input type="text" class="form-control" name="address" value="">
                              </li>
                              <li>
                                <label for="name">Birthday</label>
                                <input type="date" class="form-control" name="birthday" value="">
                              </li>
                              <li>
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" name="" value="">
                              </li>
                              <li>
                                <input type="submit" class="btn-primary form-control " name="" value="Update">
                              </li>

                           </ul>
     <?php }
   }}else{ ?>
                           <ul class="basic-info">
                              <li>
                                 <h5>Name</h5>
                                 <h5 class="details" contenteditable="true"><?php echo $full_name ?></h5>
                              </li>
                              <li>
                                 <h5>gender</h5>
                                 <h5 class="details"><?php echo $gender ?></h5>
                              </li>
                              <li>
                                 <h5>Birthday</h5>
                                 <h5 class="details"><?php echo $birthday ?></h5>
                              </li>
                              <li>
                                 <h5>Personality</h5>
                                 <h5 class="details"><?php echo $personality ?></h5>
                              </li>
                              <li>
                                 <h5>address</h5>
                                 <h5 class="details"><?php echo $address ?></h5>
                              </li>
                              <li>
                                 <h5>mobile no</h5>
                                 <h5 class="details"><?php echo $mob_num ?></h5>
                              </li>
                           </ul>

                         <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end contact details -->
          <?php } ?>
         </div>
      </div>
      <script src="assets/js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"></script>
      <script src="assets/js/owl.carousel.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <script src="assets/js/tippy-bundle.iife.min.js"></script>
      <script src="assets/js/bootstrap.js"></script>
      <script src="assets/js/easytimer.min.js">        </script>
      <script src="assets/js/index.js">        </script>
      <script src="assets/js/feather-icon/feather.min.js"></script>
      <script src="assets/js/feather-icon/feather-icon.js"></script>
      <script src="assets/js/script.js?<?php echo time() ?>"></script>
      <script src="assets/js/user.js"></script>
      <?php
       if(isset($_GET['messages'])){
         echo '<script src="assets/js/chat.js"></script>';
       }
       ?>

       <script src="assets/js/jquery.magnific-popup.js"></script>
      <script src="assets/js/zoom-gallery.js"></script>
      <?php
      if(isset($_GET['profile'])){
        $user_profile_id = mysqli_real_escape_string($conn, $_GET['profile']);
        if($session_id == $user_profile_id){
          echo'<script src="assets/js/profile.js"></script>';
        }
      }

      ?>
   </body>
</html>
<script type="text/javascript">
function previewImage(data){
      $.magnificPopup.open({
        items: {
        src: data
      },
      type: 'image'
    });
}
</script>
