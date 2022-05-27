<?php

ini_set('error_reporting', E_ALL);

$sessionUser="";
if(isset($_SESSION['user'])){
    $sessionUser = $_SESSION['user'];
}

include "admin/conect.php";

    $tps = "includs/temps/";
    $lag = "includs/lang/";
    $func= "includs/functions/";
    $css = "layout/css/";
    $js  = "layout/js/";
    $fonts = "layout/fonts/";


include $func."function.php";
include $lag."english.php";
include $tps."header.php";




