<?php

include "conect.php";

    $tps = "includs/temps/";
    $lag = "includs/lang/";
    $func= "includs/functions/";
    $css = "layout/css/";
    $js  = "layout/js/";
    $fonts = "layout/fonts/";


include $func."function.php";
include $lag."english.php";
include $tps."header.php";

if(!isset($noNavbar)){
    include $tps."navbar.php";
}


