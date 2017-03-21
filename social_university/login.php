<?php
require_once 'user.php';
$db = new User();

$response = array("error" => FALSE);

if((isset($_POST["mail"])) && (isset($_POST["password"]))){

  $mail = $_POST["mail"];
  $password = $_POST["password"];

  $user = $db->userLogin($mail, $password);

  if($user != false){
    // kullanıcı bulundu ise
    $response["error"] = FALSE;
    $response["user"]["name"] = $user["name"];
    $response["user"]["mail"] = $user["mail"];
    $response["user"]["device"] = $user["device"];
    echo json_encode($response);
  }else{
        // girilen parametrelerde hata var
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
  }
}else{
  // değişkenler post edilemedi ise
  $response["error"] = TRUE;
  $response["error_msg"] = "Required parameters email or password is missing!";
  echo json_encode($response);
}
?>
