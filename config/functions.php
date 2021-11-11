<?php
function convert_string($action, $string){
 $token = 'f85f5584a5e2cb90ed19bd71a599b9c539acc549cb3c1efa89f015f26b723c971614855d267b8694b83233b18ad4c207aaa3966e86df46cd93c1f320550868c27a80c325ce422e32ed691bdf2aedd6c83691e67a19ce1f3f864b387ac10598a5750a9eb0';
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
function make_thumb($src, $dest, $desired_width) {
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);
    $desired_height = $desired_width = 300;
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    imagejpeg($virtual_image, $dest);
}
 ?>
