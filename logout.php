<?php 
require_once "app/config/config.php";
require_once "app/classes/User.php";

$user = new User();
$user->logout();

header('Location: login.php');
exit();
?> 