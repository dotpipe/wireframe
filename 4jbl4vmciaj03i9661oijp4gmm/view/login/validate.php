<?php
namespace Adoms\oauth2;

require_once ('../vendor/composer/autoload_classmap.php');
?>
<br><Br><Br><br><br>
<?php

$crud = new OAuth2Owner();

$record = $crud->login("../Adoms/config/config.json", ["table" => "users", "username" => $_COOKIE['username'], "password" => $_POST['password']]);

if ($record->num_rows != 1) {
    session_destroy();
    setcookie("PHPSESSID","",time() + 1);
    setcookie("username","",time() + 1);
    session_start();
    
    header("Location: login.php?g=3");
}
else {
    $user = $_COOKIE['username'];
    $db = new db('../Adoms/config/config.json');
    $receive = $db->read(["users" => ["site_id"], "visitors" => []],"`users`.`site_id` = `visitors`.`site_id` AND `users`.`username` = '$user'");
    setcookie("COOKIE",$receive,time() + (60 * 60 * 24 * 60));
}
    header("Location: ../index.php");

?>
