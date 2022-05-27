<?php

session_start();
$pageTitle = 'Members';
if(isset($_SESSION['UserName'])){
    include "init.php";

$do = isset($_GET['do'])? $_GET['do'] :'Manage';

if($do =='Manage'){

}elseif($do =='Add'){

}elseif($do =='Insert'){
    
}elseif($do =='Edit'){
    
}elseif($do =='Updata'){
    
}elseif($do =='Delete'){
    
}
include $tps."footer.php";

}else{
    header("location:index.php");
    exit();
}