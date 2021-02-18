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
if (!isset($_POST["sticker_sender"]) && !isset($_POST["sticker_receiver"])) {
    $output = json_encode(array('type' => 'error', 'text' => 'sender and receiver is not specified!!'));
    die($output);
}

$sender = filter_var(trim($_POST["sticker_sender"]), FILTER_SANITIZE_EMAIL);
$receiver = filter_var(trim($_POST["sticker_receiver"]), FILTER_SANITIZE_STRING);


$sql = "SELECT sticker, sent_by, message, link, media FROM `messages` WHERE `sent_by` = '$sender' AND `sent_to` = '$receiver' AND status=0 order by msg_id asc ";
//$sentMail = true;
$result = mysqli_query($conn, $sql);
$stickers = mysqli_fetch_all($result, MYSQLI_ASSOC);
$list = '';
foreach($stickers as $row){
	// $auth_id = $row['from_user_id'];
	// $sql = "SELECT auth_name,profile_pic FROM authentication as a, user_details as u WHERE a.auth_id = u.auth_id AND a.auth_id = $auth_id";
	// $result = mysqli_query($conn, $sql);
	// $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
	// foreach($users as $user){
    if($row['sticker'] != ''){
    	$list .= '
    		<li class="replies"> 
             	<div class="media"> 
             		<div class="profile mr-4 bg-size" style="background-image: url("../assets/images/contact/1.jpg"); background-size: cover; background-position: center center;">
             		</div>
             		<div class="media-body"> 
             			<div class="contact-name"> 
             				<h5>'. $row["sent_by"]. '</h5> 
             				<h6>01:42 AM</h6> 
             				<ul class="msg-box"> 
             					<li> <h5>'. $row["sticker"]. '</h5> </li>
             				</ul> 
             			</div>
             		</div>
             	</div>
             </li>
    	';
    }else if($row['message'] != '' && $row['message'] != 'Null'){
        $list .= '
        <li class="replies">
           <div class="media">
              <div class="profile mr-4 bg-size" style="background-image: url(&quot;assets/images/avtar/1.jpg&quot;); background-size: cover; background-position: center center; display: block;"><img class="bg-img" src="assets/images/avtar/1.jpg" alt="Avatar" style="display: none;"></div>
              <div class="media-body">
                 <div class="contact-name">
                    <h5>Shankar </h5>
                    <h6>11:40 AM</h6>
                    <ul class="msg-box">
                       <li class="msg-setting-main">
                          <div class="msg-dropdown-main">
                             <div class="msg-setting"><i class="ti-more-alt"></i></div>
                             <div class="msg-dropdown">
                                <ul>
                                   <li><a href="#"><i class="fa fa-clone"></i>copy</a></li>
                                   <li><a href="#"><i class="ti-trash"></i>delete</a></li>
                                </ul>
                             </div>
                          </div>
                       </li>
                       <li class="msg-setting-main">
                         <h5>'.$row["message"].'</h5>
                          <div class="badge badge-success sm ml-2"> R</div>
                          <div class="msg-dropdown-main">
                             <div class="msg-setting"><i class="ti-more-alt"></i></div>
                             <div class="msg-dropdown">
                                <ul>
                                   <li><a href="#"><i class="fa fa-share"></i>forward</a></li>
                                   <li><a href="#"><i class="fa fa-clone"></i>copy</a></li>
                                   <li><a href="#"><i class="ti-trash"></i>delete</a></li>
                                </ul>
                             </div>
                          </div>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
        </li>
        ';
    }else if($row['media'] != ''){
        $list .= '
        <li class="sent">
           <div class="media">
              <div class="profile mr-4 bg-size" style="background-image: url(&quot;assets/images/avtar/1.jpg&quot;); background-size: cover; background-position: center center; display: block;"><img class="bg-img" src="assets/images/avtar/1.jpg" alt="Avatar" style="display: none;"></div>
              <div class="media-body">
                 <div class="contact-name">
                    <h5>Josephin water</h5>
                    <h6>01:42 AM</h6>
                    <ul class="msg-box">
                       <li class="msg-setting-main">
                          <h5>'.$row["media"].'</h5>
                          <div class="msg-dropdown-main">
                             <div class="msg-setting"><i class="ti-more-alt"></i></div>
                             <div class="msg-dropdown">
                                <ul>
                                   <li><a href="#"><i class="fa fa-clone"></i>copy</a></li>
                                   <li><a href="#"><i class="ti-trash"></i>delete</a></li>
                                </ul>
                             </div>
                          </div>
                       </li>
                       <li class="msg-setting-main">
                          <ul class="auto-gallery">
                             <li><img class="bg-img" src="assets/images/media/2.jpg" alt="Avatar"/></li>
                          </ul>
                          <div class="refresh-block">
                             <div class="badge badge-outline-primary refresh sm ml-2"> <i data-feather="rotate-cw"></i></div>
                             <div class="badge badge-danger sm ml-2">F</div>
                          </div>
                          <div class="msg-dropdown-main">
                             <div class="msg-setting"><i class="ti-more-alt"></i></div>
                             <div class="msg-dropdown">
                                <ul>
                                   <li><a href="#"><i class="fa fa-clone"></i>copy</a></li>
                                   <li><a href="#"><i class="ti-trash"></i>delete</a></li>
                                </ul>
                             </div>
                          </div>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
        </li>
        ';
    }else if($row['link'] != ''){
        $list .= '
        <li class="replies">
           <div class="media">
              <div class="profile mr-4 bg-size" style="background-image: url(&quot;assets/images/avtar/1.jpg&quot;); background-size: cover; background-position: center center; display: block;"><img class="bg-img" src="assets/images/avtar/1.jpg" alt="Avatar" style="display: none;"></div>
              <div class="media-body">
                 <div class="contact-name">
                    <h5>Josephin water</h5>
                    <h6>01:42 AM</h6>
                    <ul class="msg-box">
                       <li class="msg-setting-main">
                          <h5><a class="text-dark" href="'.$row["link"].'" target="_blank">Click Here!!</a></h5>
                          <div class="msg-dropdown-main">
                             <div class="msg-setting"><i class="ti-more-alt"></i></div>
                             <div class="msg-dropdown">
                                <ul>
                                   <li><a href="#"><i class="fa fa-clone"></i>copy</a></li>
                                   <li><a href="#"><i class="ti-trash"></i>delete</a></li>
                                </ul>
                             </div>
                          </div>
                       </li>
                       <li class="msg-setting-main">
                          <ul class="auto-gallery">
                             <iframe src="'.$row["link"].'" width = "200" height = "200"></iframe>
                          </ul>
                          <div class="refresh-block">
                             <div class="badge badge-outline-primary refresh sm ml-2"> <i data-feather="rotate-cw"></i></div>
                             <div class="badge badge-danger sm ml-2">F</div>
                          </div>
                          <div class="msg-dropdown-main">
                             <div class="msg-setting"><i class="ti-more-alt"></i></div>
                             <div class="msg-dropdown">
                                <ul>
                                   <li><a href="#"><i class="fa fa-clone"></i>copy</a></li>
                                   <li><a href="#"><i class="ti-trash"></i>delete</a></li>
                                </ul>
                             </div>
                          </div>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
        </li>
        ';
    }else{
        $list .= '';
    }
	
}
echo json_encode(htmlspecialchars_decode($list));
}
 ?>

