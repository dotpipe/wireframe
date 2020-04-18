<?php
namespace Adoms\oauth2;
use Adoms\oauth2;

require_once("../vendor/composer/autoload_classmap.php");

if (!isset($_SESSION)) {
    session_start();
    $_SESSION['login'] = false;
}

?>
<html>
<title>Anthzm - Your avenue to distributed content</title>
<head>
<style>
html {
background: url('view/pictures/bg.gif') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
body {
    height:100%;
    vertical-align:top;
}
.bg {
    text-align:justify;
    cursor:pointer;
}
input {
    cursor:pointer;
}
td > h3 {
  overflow:hidden;
  transition:max-height 2s ease-in; // note that we're transitioning max-height, not height!
  height:auto;
  max-height:600px; // still have to hard-code a value!
}
</style>

<script src="../Adoms/src/routes/pipes.js"></script>

<script data-ad-client="ca-pub-1005898633128967" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>

<body style="horizontal-align:center;border-spacing:10px;margin-left:0px;margin-right:0px;margin-top:-5px;margin-bottom:0px;">
<?php
    include_once('view/shared/header.php');
?>

<div id="login-frame" style="margin-left:100px;vertical-align:50%;width:70%;float:center;height:100%">
    <?php

        if (!isset($_GET['g'])) {
            require('view/login/username.php');
        }
        else if (isset($_GET['g']) && $_GET['g'] == 1) {
            require('view/login/pass.php');
        }
        else if (isset($_GET['g']) && $_GET['g'] == 0) {
            require('view/login/validate.php');
        }
        else if (isset($_GET['g']) && $_GET['g'] == 3) {
            ?><br><br><br><br><br>
            <h2>Login Unsuccessful</h2>
            <?php
            require('view/login/username.php');
        }

    ?>
</div>

<?php require_once('view/shared/footer.php'); ?>

</body></html>