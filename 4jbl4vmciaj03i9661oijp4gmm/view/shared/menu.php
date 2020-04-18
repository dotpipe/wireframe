<html>
<head>

<script src="../Adoms/src/routes/pipes.js"></script>
<style>
a {
    opacity:0;
    transition: opacity 1.2s;
}
.menu > .dClass {
    border-spacing:2px;
    opacity:0px;
    width:37px;
    background: white;
    transition: width 2s, opacity 1.2s;
}
.menu > .dClass > a {
    font-size:18px;
    height:30px;
    background: white;
}
a:hover {
    opacity:1;
}
.menu > .dClass:hover {
    display:flex;
    opacity:1;
    width:110px;
}
</style>

</head>

<body>
    <table style="float:left;position:fixed;width:200px">
        <tr>
            <div class="menu"><div class="dClass"><a id="home-switch" insert-in="bg" ajax="view/shared/home.php">main</a></div></div>
        </tr>
        <tr>
            <div class="menu"><div class="dClass"><a id="login-switch" insert-in="bg" ajax="view/login/partials/body.php">login</a></div></div>
        </tr>
    </table>
</body>