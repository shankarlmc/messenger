<?php
    session_start();
    include_once "db-connection.php";
    include'functions.php';
    $current_user = $_SESSION['authenticated_user_id'];
    $typing_user = mysqli_real_escape_string($conn, $_POST['currentuser']);

    $output = '
      <li class="sent last typing-m">
        <div class="media">
          <div class="profile mr-4 bg-size" >
            <img class="bg-img" src="assets/images/contact/2.jpg" alt="Avatar" style="display: block;">
            </div>
            <div class="media-body">
              <div class="contact-name">
                <h5>Josephin water</h5>
                <h6>01:42 AM</h6>
                <ul class="msg-box">
                  <li> <h5>
                    <div class="type">
                      <div class="typing-loader"></div>
                    </div></h5>
                  </li>
                </ul>
            </div>
          </div>
        </div>
       </li>
    ';

    echo $output;
?>
