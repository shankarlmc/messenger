<?php
session_start();

include"config/db-connection.php";

$fullname = $username = $email = $password = "";
$fullname_err = $username_err = $email_err = $password_err = "";
$token = 'f85f5584a5e2cb90ed19bd71a599b9c539acc549cb3c1efa89f015f26b723c971614855d267b8694b83233b18ad4c207aaa3966e86df46cd93c1f320550868c27a80c325ce422e32ed691bdf2aedd6c83691e67a19ce1f3f864b387ac10598a5750a9eb0';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(empty(trim($_POST["full__name__"]))){
        $fullname_err="Please enter your full name";
    }elseif(strlen(trim($_POST["full__name__"])) < 4){
        $fullname_err = "Name is too Short";
    }elseif(strlen(trim($_POST["username"])) > 25){
        $fullname_err = "Name is too long";
    } else{
        $fullname = trim($_POST["full__name__"]);
        $fullname = ucwords($fullname);
    }
    if(empty(trim($_POST["username"]))){
         $username_err="username should not be empty !!.";
    } elseif(strlen(trim($_POST["username"])) < 4){
        $username_err = "username is too Short";
    }elseif(strlen(trim($_POST["username"])) > 12){
        $username_err = "username is too long";
    } else{
        $username = trim($_POST["username"]);
        $username = convert_string('encrypt', $username, $token);
        $sql = "SELECT auth_name FROM details WHERE auth_name='$username'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0) {
            $username_err = "this username is already taken!!.";
        }

    }

    //insert email if is not already in system
    if(empty(trim($_POST["email"]))){
        $email_err="email should not be empty !!.";
    } else {
        $email = trim($_POST["email"]);
        $sql = "SELECT auth_email FROM authentication WHERE auth_email='$email'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0) {
            $email_err = "this email is already taken!!.";
        }
    }

    //set password
    if(empty(trim($_POST["password"]))){
        $password_err = "password should not be empty !!.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
        $password = "";
    } else{
        $password = trim($_POST["password"]);
    }

    //check whether error is occur or not
    if(empty($username_err) && empty($email_err) && empty($password_err)){
        $sql = "INSERT INTO `authentication`(`auth_email`, `password`, `is_verified`) VALUES (?,?,?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_email ,$param_password,$param_status);
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            $param_status = "0";

            if(mysqli_stmt_execute($stmt)){

              $_SESSION['register_success_message'] = "Hi <strong>". $fullname . "</strong>, You Are Registered As User. You Will Need Admin Approval For Login !!!!!";

              $get_max_user_id = "SELECT max(auth_id) as max from authentication";
              $result =mysqli_query($conn,$get_max_user_id);
              if(mysqli_num_rows($result)>0){
                   while($row = mysqli_fetch_array($result)) {
                    $max_user_id = $row['max'];
                    $max_user_id = sha1($max_user_id);
                    mysqli_query($conn,"INSERT INTO `details`(`auth_id`,`auth_name`,`full_name`,`profile_pic`)VALUES
                    ('{$max_user_id}','{$username}','{$fullname}','/assets/images/avtar/avatar.jpg')");
              }}


              $username = $email = $password = $fullname = '';

              header('location:login.php');
            } else{
                echo "Something went wrong. Please try again later.";
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
  if($action == 'encrypt'){
   $output = openssl_encrypt($string, $encrypt_method, $key, 0, $initialization_vector);
   $output = base64_encode($output);
  }
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
    <title>Register to chat room</title>
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
  </head>
  <body class="dark">
    <div class="login-page1">
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12">
            <div class="login-contain-main">
              <div class="left-page">
                <div class="login-content">
                  <?php if(empty($fullname_err) OR empty($username_err) OR empty($email_err) OR empty($password_err)){
                    echo '
                    <h3>Private Chatting room</h3>
                    <h4>Wellcome to private chat room, We provide end to end encrypted chatting system <br> Create your account here.</h4>';
                  }?>

                  <form class="form1" id="registerUser" method="POST" >
                    <div class="form-group">
                      <label class="col-form-label" for="inputUserFullname">Full Name</label>
                      <input class="form-control <?php if(!empty($fullname_err)){ echo 'has-error';} ?>" id="inputUserFullname" type="text" placeholder="" name="full__name__" value="<?php echo convert_string('decrypt', $fullname, $token) ?>">
                      <?php
                        if(!empty($fullname_err)){
                          echo '<span class="help-block text-danger">'.$fullname_err.'</span>';
                        }
                       ?>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label" for="inputUsername">Username</label>
                      <input class="form-control <?php if(!empty($username_err)){ echo 'has-error';} ?>" id="inputUsername" type="text" placeholder="" name="username" value="<?php echo convert_string('decrypt', $username, $token) ?>">
                      <?php
                        if(!empty($username_err)){
                          echo '<span class="help-block text-danger">'.$username_err.'</span>';
                        }
                       ?>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label" for="inputEmail">Email Address</label>
                      <input class="form-control <?php if(!empty($email_err)){ echo 'has-error';} ?>" id="inputEmail" type="email" placeholder="" name="email" value="<?php echo convert_string('decrypt', $email, $token) ?>">
                      <?php
                        if(!empty($email_err)){
                          echo '<span class="help-block text-danger">'.$email_err.'</span>';
                        }
                       ?>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label" for="inputPassword">Password</label><span> </span>
                      <input class="form-control <?php if(!empty($password_err)){ echo 'has-error';} ?>" id="inputPassword" type="password" placeholder="" name="password">
                      <?php
                      if(isset($password_err)){
                        if(!empty($password_err)){
                          echo '<span class="help-block text-danger">'.$password_err.'</span>';
                        }

                      }
                       ?>
                    </div>

                    <div class="form-group text-center">
                      <div class="buttons">
                        <input type="submit" class="btn btn-primary button-effect btn-block register-user" value="Register">
                      </div><br>
                      <h6><a class="text-center" href="login.php">Already have an account?</a></h6>
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
                    <div class="right-circle1"></div><img class="heart-logo" src="assets/images/login_signup/5.png" alt="login logo"/>
                    <img class="has-logo" src="assets/images/login_signup/4.png" alt="login logo"/>
                    <img class="login-img" src="assets/images/login_signup/1.png" alt="login logo"/>
                    <img class="boy-logo" src="assets/images/login_signup/6.png" alt="login boy logo"/>
                    <img class="girl-logo" src="assets/images/login_signup/7.png" alt="girllogo"/>
                    <img class="cloud-logo" src="assets/images/login_signup/2.png" alt="login logo"/>
                    <img class="cloud-logo1" src="assets/images/login_signup/2.png" alt="login logo"/>
                    <img class="cloud-logo2" src="assets/images/login_signup/2.png" alt="login logo"/>
                    <img class="cloud-logo3" src="assets/images/login_signup/2.png" alt="login logo"/>
                    <img class="cloud-logo4" src="assets/images/login_signup/2.png" alt="login logo"/>
                    <img class="has-logo1" src="assets/images/login_signup/4.png" alt="login logo"/>
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
<script>

</script>
