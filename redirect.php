<?php

namespace Adoms\wireframe;
use Adoms\oauth2;
if (!isset($_SESSION))
    session_start();

require_once 'vendor/composer/autoload_classmap.php';

$db = new db();
$request = $db->read(["users" => ["site_id"]], "`site_id` = '" . $_COOKIE['PHPSESSID'] . "'");
\setcookie('PHPSESSID',$request[0]['site_id'],(time() + (30*24*60*60)));
$x = new PageControllers($_COOKIE['PHPSESSID']);
$y = new PageControllers($_COOKIE['PHPSESSID']);


$x->newView("login");
/*
$x->mvc['login']->addModelField("username");
$x->mvc['login']->addModelField("password");
$x->mvc['login']->addModelValid("username",'/[A-z0-9_]{3,}/', "Illegal Username, must be 3 chars long. Letters, numbers, and underscore");
$x->mvc['login']->addModelValid("password",'/[[A-z]{3,}[0-9]{3,}[_!@#$%^&*\(\)\\]{2,}]{9,}/', "9+ characters of 3+ letters, 3+ Numbers, 2+ punctuations from number keys or underscore");
$x->mvc['login']->addModelData("username", $upass);
$x->mvc['login']->addModelData("password", $upass);
*/

$x->mvc['login']->view->addshared("skeleton.php");
$x->mvc['login']->view->writePage("index");
$x->paginateModels("login","index.php");
$x->save();
$x = $x->loadJSON();
header("Location: " . $_COOKIE['PHPSESSID'] . "/index.php");

?>