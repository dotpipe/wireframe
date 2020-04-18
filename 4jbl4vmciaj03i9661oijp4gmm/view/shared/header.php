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
.column { display: inline-block;  text-decoration:bold;}
.lnk0{ float:left; display: inline-block; width: 5%; }
.lnk1{ float:left; display: inline-block; width: 20%; }
.lnk2{ float:right; display: inline-block; width: 10%; }
.lnk3{ float:right; display: inline-block; width: 10%; }
.lnk4{ float:right; display: inline-block; width: 10%; }
.lnk5{ float:right; display: inline-block; width: 10%; }

</style>
<script src="<?php echo "../Adoms/src/routes/pipes.js"; ?>"></script>
</head>
<body style="horizontal-align:center;border-spacing:10px;margin-left:0px;margin-right:0px;margin-top:-5px;margin-bottom:0px;">

<div style="height:20px;border-bottom:3px lightblue solid;z-index:3;width:100%;position:fixed;vertical-align:center;color:lightblue;padding:12px;background:#040d45">
    <div class="margin-left:0px;border-bottom:3px lightblue solid;">
        <div>
            <a class="lnk0" href="http://www.anthzm.com/<?=$_COOKIE['PHPSESSID']?>" style="color:lightblue;margin-top:0px;opacity:1;text-decoration:none;font-family:SegoeScript;font-size:18px"><i><b>Anthzm</b></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b class="lnk1" contenteditable style="display:flex;color:black;background:lightblue;border-bottom:2px lightblue solid;border-spacing:5px;border:0px;padding:2px;font-size:18px;height:20px;max-width:200px" id="search">Search</b>&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;<img class="lnk1" id="search" style="background:lightblue;border:2px lightblue solid;display:flex;max-width:30px;height:20px" src="view/pictures/searchglass.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b class="lnk2"><?php if (isset($_COOKIE['username'])) { echo "Welcome, " . $_COOKIE['username']; } ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="lnk3" href="../<?php echo file_get_contents("../random_target_jump") ?>" style="color:lightblue;text-decoration:none;cursor:pointer;">Jump</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="lnk4" href="login.php" style="color:lightblue;text-decoration:none;cursor:pointer;">Sign in</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="lnk5" href="register.php" style="color:lightblue;text-decoration:none;cursor:pointer;">Register</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </div>
</div>

</body></html>