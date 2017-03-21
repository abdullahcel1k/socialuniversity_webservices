<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="login.php" method="post">
      <table>
          <td>Kullanıcı mail:</td>
          <td><input type="text" name="mail" /></td>
        </tr>
        <tr>
          <td>Kullanıcı şifre:</td>
          <td><input type="text" name="password" /></td>
        </tr>
      </table>
      <button type="submit" name="kullanicikaydet">Güncelle</button>
    </form>
  </body>
</html>
<?php
require_once "user.php";

$user = new User();
if(isset($_POST["kullanicikaydet"])){
  $users = $user->userRegistration(($_POST["name"]),($_POST["mail"]),($_POST["password"]),($_POST["device"]));

  if($users == true){
    echo "<pre>".json_encode($users). "</pre>";
  }else{
    echo "kayıt başarısız";
  }
}

?>
