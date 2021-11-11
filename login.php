<?php
include"config/db-connection.php";
session_start();

if(isset($_SESSION["authenticated_user_id"]) && isset($_SESSION["authenticated_user_email"]) ){
  if($_SESSION["authenticated_user_id"] != '' && $_SESSION["authenticated_user_email"] != '' ){
    header('location:messenger.php');
  }
}


$useremail = $password = "";
$useremail_err = $password_err = "";
$token = 'f85f5584a5e2cb90ed19bd71a599b9c539acc549cb3c1efa89f015f26b723c971614855d267b8694b83233b18ad4c207aaa3966e86df46cd93c1f320550868c27a80c325ce422e32ed691bdf2aedd6c83691e67a19ce1f3f864b387ac10598a5750a9eb0';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["authorized-email"]))){
        $useremail_err = "please enter email.";
    } else{
        $useremail = trim($_POST["authorized-email"]);
        // $useremail = convert_string('encrypt', $useremail, $token);

        $sql = "SELECT auth_email from authentication where auth_email = '$useremail' AND is_verified = 0";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0) {
            $username_err = "your account is not activated !!, please contact administration. </br> for more info <a href='/test' class='text-info'>Here!</a>";
        }
    }
   //enter password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    //conditio to check if username and password are empty or not
    if(empty($useremail_err) && empty($password_err)){

        $sql = "SELECT `auth_id`, `password`,`is_verified` FROM `authentication` WHERE auth_email = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
           //bind the username selected from admintable
            mysqli_stmt_bind_param($stmt, "s", $param_useremail);

            $param_useremail = $useremail;

            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){

                    mysqli_stmt_bind_result($stmt, $id, $hashed_password, $is_verified);

                    if(mysqli_stmt_fetch($stmt)){

                        if(password_verify($password, $hashed_password)){
                          //test whether the user is verified or not
                          if($is_verified == '1'){
                            $_SESSION['user_logged_in_time'] = time();
                            $_SESSION["unique_token"] = $token;
                            $_SESSION["authenticated_user_id"] = sha1($id);
                            $_SESSION["authenticated_user_email"] = $useremail;
                            header('location:messenger.php');
                          // echo "login succided";
                          // add cookie to remember username password
                          if(!empty($_POST['remember'])){
                              $cookie_token = bin2hex(random_bytes(50));
                              $password = convert_string('encrypt', $password, $cookie_token);
                              $password = trim($password);
                              setcookie("authorized_user", $useremail, time()+(7 * 24 * 60 * 60));
                              setcookie("key", $password, time()+(7 * 24 * 60 * 60));
                              setcookie("token", $cookie_token, time()+(7 * 24 * 60 * 60));
                            } else {
                              $cookie_token = bin2hex(random_bytes(10));
                              if(isset($_COOKIE['authorized_user'])) {
                                setcookie("authorized_user","");
                              }
                              if(isset($_COOKIE['key'])) {
                                setcookie("key","");
                              }
                              setcookie("token", $cookie_token, time()+(7 * 24 * 60 * 60));
                            }
                          }else{
                            $_SESSION['register_danger_message'] = "<strong>Hello there, You are not verified yet. Please contact admin for further help !!</strong>";
                          }
                        } else{
                          $password_err = "incorrect password.";
                        }
                    }
                } else{
                    $useremail_err = "invalid email address.";
                    $password_err = "invalid password.";
                }
            } else{
              $useremail_err = "invalid email address.";
              $password_err = "invalid password.";
            }
        }

        mysqli_stmt_close($stmt);
    }


    mysqli_close($conn);
}

function convert_string($action, $string, $token){
  $output = '';
  $encrypt_method = "AES-256-CBC";
  $secret_iv = '407f3eda247cc86e42c0ccd89c553c08';
  $key = hash('sha256', $token);
  $initialization_vector = substr(hash('sha256', $secret_iv), 0, 16);
  if($string != ''){
    //encrypt
    if($action == 'encrypt'){
       $output = openssl_encrypt($string, $encrypt_method, $key, 0, $initialization_vector);
       $output = base64_encode($output);
    }
    // decrypt
    if($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $initialization_vector);
    }
  }
 return $output;
}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login to chat room</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen" id="color">
  </head>
  <body class="dark">
    <div class="login-page1">
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12">
            <div class="login-contain-main">
              <div class="left-page">
                <div class="login-content">
                  <h3>Private Chatting room</h3>
                  <?php
                  if(isset($_SESSION['register_success_message'])){
                    echo '
                    <div class="mt-2 alert alert-info fade show text-danger" role="alert">
                      '.$_SESSION['register_success_message'].'
                    </div>';
                    unset($_SESSION['register_success_message']);
                  }else{
                    echo '<h4>Wellcome, We provide encrypted chatting system <br> Create your account here.</h4>';
                  }
                  if(isset($_SESSION['register_danger_message'])){
                    echo '
                    <div class="mt-2 alert alert-info fade show text-danger" role="alert">
                      '.$_SESSION['register_danger_message'].'
                    </div>';
                    unset($_SESSION['register_danger_message']);
                  }
                   ?>
                  <form class="form1" method="POST">
                    <div class="form-group">
                      <label class="col-form-label" for="inputEmail">Email Address</label>
                      <input class="form-control <?php if(!empty($useremail_err)){ echo 'has-error';} ?>" id="inputEmail" name="authorized-email" type="email" placeholder="" value="<?php
                      if(isset($_COOKIE['authorized_user'])) {
                        echo $_COOKIE['authorized_user'];
                        }
                       ?>">
                      <?php
                        if(!empty($useremail_err)){
                          echo '<span class="help-block text-danger">'.$useremail_err.'</span>';
                        }
                       ?>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label" for="inputPassword3">Password</label><span> </span>
                      <input class="form-control <?php if(!empty($password_err)){ echo 'has-error';} ?>" id="inputPassword3" type="password" placeholder="" name="password"  value="<?php
                      if(isset($_COOKIE['key'])) {
                        echo trim(convert_string('decrypt',$_COOKIE['key'], $_COOKIE['token']));

                        }
                       ?>">
                      <?php
                        if(!empty($password_err)){
                          echo '<span class="help-block text-danger">'.$password_err.'</span>';
                        }
                       ?>
                    </div>
                    <div class="form-group">
                      <div class="rememberchk">
                        <div class="form-check">
                          <input class="form-check-input" id="gridCheck1" type="checkbox" name="remember" <?php if(isset($_COOKIE['token'])){ echo 'checked';} ?>>
                          <label class="form-check-label" for="gridCheck1">Remember Me.</label>
                          <h6>Forgot Password?</h6>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="buttons"><button type="submit" class="btn btn-primary button-effect" >Login</button><a class="btn button-effect btn-signup" href="register.php">SignUp</a></div>
                    </div>
                  </form>
                  <div class="termscondition">
                    <h4 class="mb-0"><span>*</span>Terms and condition<b>&amp;</b>Privacy policy</h4>
                  </div>
                </div>
              </div>
              <div class="right-page">
                <div class="right-login animat-rate">
                  <div class="animation-block">
                    <div class="bg_circle">
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                    </div>
                    <div class="cross"></div>
                    <div class="cross1"></div>
                    <div class="cross2"></div>
                    <div class="dot"></div>
                    <div class="dot1"></div>
                    <div class="maincircle"></div>
                    <div class="top-circle"></div>
                    <div class="center-circle"></div>
                    <div class="bottom-circle"></div>
                    <div class="bottom-circle1"></div>
                    <div class="right-circle"></div>
                    <div class="right-circle1"></div><img class="heart-logo" src="assets/images/login_signup/5.png" alt="login logo"/><img class="has-logo" src="assets/images/login_signup/4.png" alt="login logo"/><img class="login-img" src="assets/images/login_signup/1.png" alt="login logo"/><img class="boy-logo" src="assets/images/login_signup/6.png" alt="login boy logo"/>
                    <img class="girl-logo" src="assets/images/login_signup/7.png" alt="girllogo"/><img class="cloud-logo" src="assets/images/login_signup/2.png" alt="login logo"/><img class="cloud-logo1" src="assets/images/login_signup/2.png" alt="login logo"/><img class="cloud-logo2" src="assets/images/login_signup/2.png" alt="login logo"/>
                    <img class="cloud-logo3" src="assets/images/login_signup/2.png" alt="login logo"/><img class="cloud-logo4" src="assets/images/login_signup/2.png" alt="login logo"/><img class="has-logo1" src="assets/images/login_signup/4.png" alt="login logo"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
