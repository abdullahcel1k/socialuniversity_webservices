<?php
$result  = array('name'  => 'test', 'age' => 21);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Juk 1996 05:00:00 GMT');

header('Content-type: application/json');

echo json_encode($result);
?>
