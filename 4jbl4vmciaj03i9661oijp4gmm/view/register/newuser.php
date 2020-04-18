<?php
    namespace Adoms\oauth2;

    include_once("../../../vendor/composer/autoload_classmap.php");

    if (!isset($_SESSION))
        session_start();

    $db = new db("../../../Adoms/config/config.json");
    
    $result = $db->read(["users" => ["username", "site_id"]], "`username` = \"" . $_POST['username'] . "\"");

    $cookie = $_COOKIE['PHPSESSID'];
    if (count($result) > 0) {
        foreach ($result as $key) {
            if ($_POST['username'] == $key['username']) {
                \setcookie('PHPSESSID', $key['site_id'], time() + (60 * 60 * 24 * 60));
                header("Location: wireframe/$cookie/index.php");
            }
        }
    }
    else {
        $pass = $_POST['password'];
        $oauth = new OAuth2Owner();
        $UserController = new UserController();
        $token = $oauth->createTokenizer();
        //$db->create(array("id" => NULL, "password" => $pass, "username" => $_POST['username'], "realm" => $_COOKIE['PHPSESSID'], "token" => $token, "request" => "NEWUSER", "expiry" => 0), "oauth2");
        $grad = 0.00007;
        $vals = array (
            "id" => NULL,
            "username" => $_POST['username'],
            "password" => $pass,
            "email" => $_POST['email'],
            "grad_fee" => 0.00007,
            "site_id" => $_COOKIE['PHPSESSID'],
            "month" => date("m",time()),
            "views_month" => 0,
            "fee" => 0,
            "refered_by" => NULL,
            "deal" => NULL,
            "views_total" => 0
        );
        $UserController->newUser("../../../Adoms/config/config.json", $vals, "users");
        $vals_new_oauth = [
            "id" => NULL,
            "password" => $pass,
            "username" => $_POST['username'],
            "realm" => $_COOKIE['PHPSESSID'],
            "token" => NULL,
            "request" => "NEWUSER",
            "expiry" => 0
        ];
        $UserController->newUser("../../../Adoms/config/config.json", $vals, "users");
        
        //$db->create($vals,"users");
        $returned = $db->read(array("users" => ['site_id']),'`username` = "' . $_POST['username'] . '" AND `password` = "' . $rehash . '"');
        $var = array(
            "is_user" => 1
        );
        $db->update("visitors", $var, "`IP` = \"" . $_COOKIE['PHPSESSID'] . "\"");
        if (\is_array($returned) && \count($returned) > 0) {
            \setcookie('PHPSESSID', $returned[0]['site_id'],time() + (60 * 60 * 24 * 60));
            \header("Location: /" . $_COOKIE['PHPSESSID'] . "/");
        }
        else {
            \setcookie('PHPSESSID', \session_id(),time() + (60 * 60 * 24 * 60));
            \header("Location: ../../../4jbl4vmciaj03i9661oijp4gmm/");
        }
    }

?>