<?php

namespace adoms\src\oauth2;

use adoms\src\wireframe;

session_cache_limiter('');

if (!isset($_SESSION))
    session_start();
    

header("Cache-Control: max-age=31536");

date_default_timezone_set('America/Detroit');
require_once 'vendor/composer/autoload_classmap.php';

$db = new db('adoms/config/config.json');
$bool_user = false;

/// Collect information to see if a visitor is new or not
/// Next see how many times they have visited.
/// Cache the user to have a token for their IP
/// User token becomes their site_id in the database
print_r($_COOKIE);
//return;
$returned = $db->read(array("visitors" => ['hits', 'site_id', 'is_user']), '`IP` = "' . $_SERVER['REMOTE_ADDR'] . '"');
if (\is_array($returned) && \count($returned) > 0 || $_COOKIE['login'] == 1) {
    if ($returned[0]['site_id'] == '/') {
        $returned[0]['site_id'] = session_id();
    }
    $var = array (
        "hits" => ($returned[0]['hits'] + 1),
        "site_id" => $returned[0]['site_id'],
        "date" => date("H:i:s",time())
    );
    $db->update("visitors", $var, "`IP` = \"" . $_SERVER['REMOTE_ADDR'] . "\"");
    if (session_id() != $returned[0]['site_id']) {
        if (isset($_COOKIE['new'])) {
            $pass = $_COOKIE['password'];
            $user = $_COOKIE['username'];
            $email = $_COOKIE['email'];
        }

        if (strlen($pass) > 0) {
            setcookie('username',$user,(time()+3600));
            setcookie('password',$pass,(time()+3600));
            setcookie('email',$email,(time()+3600));
        }
    }
    setcookie("PHPSESSID", $returned[0]['site_id'], time() + (60 * 60 * 24 * 60));
    $bool_user = true;
}
else {
    $var = array(
        "id" => NULL,
        "IP" => $_SERVER['REMOTE_ADDR'],
        "hits" => 1,
        "site_id" => session_id(),
        "is_user" => 0,
        "date" => date("H:i:s",time())
    );

    $db->create($var,"visitors");
    setcookie("PHPSESSID", session_id(), time() + (60 * 60 * 24 * 60));
    \header("Location: 4jbl4vmciaj03i9661oijp4gmm/");
}
/// Get a JUMP target for the meantime
/// This will have the ability to change everytime
/// a user comes to the site. Then more than one
/// person can see the one JUMP and later another
/// gets a turn.
$got_it = [];
$count = $db->read(array("users" => ["id", "site_id"] ), "1");
if (count($count) > 0) {
    
    $rows = $count;
    srand(time());
    print_r($rows);
    $rand = rand(1, count($rows));
    for ($i = 0; $i <= $rand  && $i < $rows; $i++) {
        $got_it = $count[$i];
    }
    file_put_contents("random_target_jump",$got_it['site_id']);
    $_SESSION['RAND'] = $got_it['site_id'];
}
print_r($_COOKIE);
    /// SETUP NEW USER
    /// NOT FINISHED!

    if (isset($_COOKIE['password']) && isset($_COOKIE['email']) && isset($_COOKIE['username'])) {
        /* $db->create(["realm" => $_COOKIE['PHPSESSID'], "username" => $_COOKIE['username'], "password" => $_COOKIE['password'], "request" => "NEWUSER"],"oauth2");
        $rehash = $db->hashPassword($_COOKIE['password']); */
        $oauth = new OAuth2Owner();
        $login = $oauth2->login("../adoms/config/config.json", array("table" => "oauth2", "password" => $_COOKIE['password'], "username" => $_COOKIE['username'], "realm" => $_COOKIE['PHPSESSID']),0);
        $pass = $_COOKIE['password'];
        $oauth2->hashPassword($pass);

        $_SESSION['RAND'] = $got_it['site_id'];
        $vals = array (
            "id" => NULL,
            "username" => $_COOKIE['username'],
            "password" => $rehash,
            "email" => $_COOKIE['email'],
            "site_id" => $_COOKIE['PHPSESSID'],
            "grad_fee" => 0.00007,
            "month" => date("m",time()),
            "views_month" => 0,
            "fee" => 0,
            "refered_by" => NULL,
            "deal" => NULL,
            "views_total" => 0
        );
        $db->create($vals,"users");
        $returned = $db->read(array("users" => ['site_id']),'`username` = "' . $_COOKIE['username'] . '" AND `password` = "' . $rehash . '"');
        $var = array(
            "is_user" => 1
        );
        $db->update("visitors", $var, "`IP` = \"" . $_COOKIE['PHPSESSID'] . "\"");
        if (\is_array($returned) && \count($returned) > 0) {
            \setcookie('PHPSESSID',$returned[0]['site_id'],time() + (60 * 60 * 24 * 60));
            \header("Location: /" . $_COOKIE['PHPSESSID'] . "/");
        }
        else {
            \setcookie('PHPSESSID',\session_id(),time() + (60 * 60 * 24 * 60));
            \header("Location: 4jbl4vmciaj03i9661oijp4gmm/");
        }
    }    
    /// LOGIN FOR THE USERS WHO ARE ALREADY REGISTERED
    if (!isset($_COOKIE['new']) && isset($_COOKIE['username']) && isset($_COOKIE['password'])){
        $oauth = new OAuth2Owner();
        $login = $oauth2->login("../adoms/config/config.json", array("table" => "oauth2", "password" => $_COOKIE['password'], "username" => $_COOKIE['username'], "realm" => $_COOKIE['PHPSESSID']),0);
        $pass = $_COOKIE['password'];
        $oauth2->hashPassword($pass);
        $returned = $db->read(array("users" => ['site_id']),'`username` = "' . $_COOKIE['username'] . '" AND `password` = "' . $pass . '"');
        
        $_SESSION['RAND'] = $got_it['site_id'];
    }
    /// Already a user and I'm looking for the session they use
    /// They'll be taken to their own site. JUMPs will be on their page
    if (isset($_COOKIE['PHPSESSID'])) {
        $returned = $db->read(array("users" => ['site_id']),'`site_id` = "' . $_COOKIE['PHPSESSID'] . '"');
        
        if (\is_array($returned) && count($returned) > 0) {
            $_SESSION['RAND'] = $got_it['site_id'];
            \setcookie('PHPSESSID', $returned[0]['site_id'], time() + (60 * 60 * 24 * 60));
            \header("Location: /" . $_COOKIE['PHPSESSID'] . "/");
        }
        else {
            unset($_COOKIE['PHPSESSID']);
            \header("Location: redirect.php");
        }
    }
    /// NEW GUEST
    if ($bool_user != true && isset($returned[0]['site_id'])) {
        $var = ["is_user" => 1];
        $db->update("users",$var,"`site_id` = " . $returned[0]['site_id']);
        $_SESSION['RAND'] = $got_it['site_id'];
        \setcookie('PHPSESSID', $returned[0]['site_id'], time() + (60 * 60 * 24 * 60));
        \header("Location: /" . $_COOKIE['PHPSESSID'] . "/");
    }
    /// Last chance. Send them to the site's sign up page.
    $_SESSION['RAND'] = $got_it['site_id'];
    \header("Location: 4jbl4vmciaj03i9661oijp4gmm/");

?>