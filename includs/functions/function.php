<?php


//
function getCat(){
    global $db;
    $statment1 = $db->prepare("SELECT * FROM category ORDER BY ID ASC");
    $statment1->execute();
    $cat = $statment1->fetchAll();
    return  $cat;
}
//
function getItem($where , $value){
    global $db;
    $statment1 = $db->prepare("SELECT * FROM itemtbl WHERE $where =? ORDER BY item_ID DESC");
    $statment1->execute(array($value));
    $item = $statment1->fetchAll();
    return  $item;
}
//
function checkUserStatus($user){
    global $db;
    $stmt = $db->prepare("SELECT  UserName , RegStatus FROM items WHERE UserName =? AND Regstatus =0 ");
    $stmt->execute(array($user));
    $status = $stmt->rowCount();
    return $status;
}
//    
function checkItem($select , $from , $value){
    global $db;
    $statment = $db->prepare("SELECT $select FROM $from WHERE $select=?");
    $statment->execute(array($value));
    $count = $statment->rowCount();
    return $count;
}
















// get title from page and set it in browser tab
function getTitle(){
    global $pageTitle;

    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo "default";
    }
}
//if user browse page directly will rturn his to home page
function redirecHome($theMsg , $url , $sec=3){
    if($url == null){
        $url = 'index.php';
    }else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==''){
        $url = $_SERVER['HTTP_REFERER'];
        }else{
            $url = 'index.php';
        }
    }
       echo $theMsg;
        echo "<div class='alert alert-info'> you will redirect to ".$url." after".$sec."</div>";
        header("refresh:$sec; url=$url");
        exit();

    }
//    
// function checkItem($select , $from , $value){
//     global $db;
//     $statment = $db->prepare("SELECT $select FROM $from WHERE $select=?");
//     $statment->execute(array($value));
//     $count = $statment->rowCount();
//     return $count;
// }
//
function itemNum($item , $table){
    global $db;
    $stmt2 = $db->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();

}

//
function getLatest($select , $from , $order , $limt ){
    global $db;
    $statment1 = $db->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limt");
    $statment1->execute();
    $latest = $statment1->fetchAll();
    return  $latest;
}



