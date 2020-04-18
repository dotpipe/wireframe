<?php
    include_once("view/shared/header.php");
    echo "<center>";
    include_once("view/register/front.php");
    
    if (isset($_GET['g']) && $_GET['g'] == 1) {
        echo "<br><br><br><br><br><h2>Username is being used by another user.</h2>Did you forget your password?";
    }
    if (isset($_GET['g']) && $_GET['g'] == 0)
    {
        echo "<br><br><br><br><br><h2>You're using the same IP as someone else.</h2>Did you forget your password?";
        echo "<h2>This will be marked for the owner of that IP.</h2><br>Try again?";
    }
    echo "</center>";
?>