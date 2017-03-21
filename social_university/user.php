<?php


/**
 *
 */
class User
{
  private $conn;

  function __construct()
  {
    require_once 'connect.php';

    $db = new connect();
    $this->conn = $db->baglan();
  }

  //kullanıcı kayıt eden metodum
  public function userRegistration($name, $mail, $password, $device){
      $stmt =$this->conn->prepare("INSERT INTO users (users_name, users_mail, users_password, users_deviceid) VALUES (:name, :mail, :password, :device) ");
      $result = $stmt->execute(array(
          ':name' => $name,
          ':mail' => $mail,
          ':password' => md5($password),
          ':device' => $device
      ));
      if($result == true){
        //kaydolan kullanıcının bilgilerini array olarak gönderiyoruz
        $stmt = $this->conn->prepare("SELECT users_name, users_mail, users_deviceid FROM users WHERE users_mail = :mail");
        $stmt->execute(array(':mail' => $mail));

        $result = $stmt->fetchAll();
        $stmt = null;
        foreach ($result as $key) {
          $user["name"] = $key["users_name"];
          $user["mail"] = $key["users_mail"];
          $user["device"] = $key["users_deviceid"];
        }
        return $user;
      }else{
        //ters giden birşeyler oldu
        return false;
      }
  }

  //kayıt edilmek istenen email daha önce var ise kayıt etmiyoruz
  public function userControl($mail){
    $stmt = $this->conn->prepare("SELECT users_mail FROM users WHERE users_mail = :mail");
    $stmt->execute(array(':mail' => $mail));

    $result = $stmt->rowCount();


    $stmt = null;
    // bu mailde kullanıcı var
    if($result >0){
      return true;
    }else{
      //bu mailde kullanıcı yok
      return false;
    }
  }

  public function userLogin($mail, $password){
    $stmt = $this->conn->prepare("SELECT users_name, users_mail, users_password, users_deviceid FROM users WHERE users_mail = :mail");

    $stmt->execute(array(':mail' => $mail));
    $result = $stmt->fetchAll();

    $stmt = null;
    if($result){
        foreach ($result as $key) {
        $user["name"] = $key["users_name"];
        $user["mail"] = $key["users_mail"];
        $user["password"] = $key["users_password"];
        $user["device"] = $key["users_deviceid"];
      }

      //şifre doğrulama
      if(md5($password) == $user["password"]){
        return $user;
      }
    }else {
      return NULL;
    }
  }

  public function userListele(){
    $stmt =$this->conn->prepare("SELECT *FROM users");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
    $user = array();
    $user = $result;
    /*foreach ($result as $key ) {
      $user["name"] = $key["users_name"];
      $user["mail"] = $key["users_mail"];
      $user["password"] = $key["users_password"];
      $user["device"] = $key["users_deviceid"];
    }*/
    return $user;
  }

}


?>
