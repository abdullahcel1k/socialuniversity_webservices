<?php

require_once 'user.php';
$db = new User();

$response = array('error' => FALSE);

if(isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['device']) ){

  $name = $_POST['name'];
  $mail = $_POST['mail'];
  $password = $_POST['password'];
  $device = $_POST['device'];

  if($db->userControl($mail)){
    //kayıtlı kullanıcı var ise hata mesajında bunu belirttik

    $response["error"] = TRUE;
    $response["error_msg"] = "User already existed with ". $mail;
    echo json_encode($response);
  }else{
    //kayıtlı kullanıcı yok ise yeni bir kullanıcı ekliyoruz
    $user = $db->userRegistration($name, $mail, $password, $device);
    if($user){
      //kayıt başarılı ise
      $response["error"] = FALSE;
      $response["user"]["name"] = $user["name"];
      $response["user"]["mail"] = $user["mail"];
      $response["user"]["device"] = $user["device"];
      echo json_encode($response);
    }else{
      //kayıt başarısız olmuş ise
      $response["error"] = TRUE;
      $response["error_msg"] = "Unknown error occurred in registration!";
      echo json_encode($response);
    }
  }
}else{
    //veriler post edilmemişse
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}

?>
