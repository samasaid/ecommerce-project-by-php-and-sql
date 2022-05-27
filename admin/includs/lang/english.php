<?php
    function lang($phrase){
       static $lang = array(
        //    nav bar phrases
          "home"=>"Dashboard",
          "items"=>"Items",
          "comments"=>"Comments",
          "categories"=>"Sections",
          "members"=>"Members",
          "logs"=>"Logs",

       );
       return $lang[$phrase];

    }