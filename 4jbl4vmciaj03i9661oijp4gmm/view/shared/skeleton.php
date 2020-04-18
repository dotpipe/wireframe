<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['login'] = false;
}
?>
<html>
<title>Anthzm - Your avenue to distributed content</title>
<head>
<style>
.zoom {
    zoom: 1.1;
}
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
</style>

<script data-ad-client="ca-pub-1005898633128967" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>

<body class="" style="horizontal-align:center;border-spacing:10px;margin-left:0px;margin-right:0px;margin-top:-5px;margin-bottom:0px;">

<?php require_once('view/shared/header.php'); ?>

<div id="content" style="margin-left:100px;width:70%;float:center;height:100%">

    <?php require('view/shared/body.php'); ?>

</div>

<?php require_once('view/shared/footer.php'); ?>

</body></html>