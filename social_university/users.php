<?php
require_once 'user.php';
$db = new User();


$userlist = $db->userListele();
echo json_encode($userlist);
/*foreach ($user as $key) {
  echo json_encode($key);
}*/
