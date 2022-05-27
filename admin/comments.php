<?php

session_start();
$pageTitle = 'Comments';
if(isset($_SESSION['UserName'])){
    include "init.php";

$do = isset($_GET['do'])? $_GET['do'] :'Manage';

if($do =='Manage'){
    
    $stmt = $db->prepare("SELECT comments.*, itemtbl.Name As item_Name ,items.UserName
    FROM comments
    INNER JOIN itemtbl ON itemtbl.item_ID = comments.item_ID
    INNER JOIN items ON items.UserID = comments.userid
");
    $stmt->execute();
    $coms = $stmt->fetchAll();
    // $count = $stmt->rowCount();
  
  if(!empty($coms)){
  ?>
  <div class= "container">
    <h1 class="text-center">Manage Comments Page</h1>
    <table class="table table-dark" style="margin-top:20px";>
<thead>
  <tr class= "col-lg-8 col-sm-12">
    <th scope="col">#ID</th>
    <th scope="col">UserName</th>
    <th scope="col">Comment</th>
    <th scope="col">Item</th>
    <th scope="col">Register Date</th>
    <th scope="col">Control</th>
  </tr>
</thead>
<tbody>
    <!-- <th scope="row">1</th> -->
    <?php 
    foreach($coms as $com){
      echo "<tr class-'col-lg-8 col-sm-12'>";
      echo "<td>".$com['Com_ID']."</td>";
      echo "<td>".$com['UserName']."</td>";
      echo "<td>".$com['Comment']."</td>";
      echo "<td>".$com['item_Name']."</td>";
      echo "<td>".$com['Date']."</td>";
      echo "<td><button type='button' class='btn btn-success' ><a href ='comments.php?do=Edit&comid=".$com['Com_ID']."' style = 'text-decoration:none; color:#fff;'><i class='fa fa-edit' style ='color:#fff; padding-right:2px;'></i>Edit</a></button>
      <button type='button' class='btn btn-danger confrim'><a href ='comments.php?do=Delete&comid=".$com['Com_ID']."' style = 'text-decoration:none; color:#fff;'><i class='fa fa-times' style ='color:#fff; padding-right:2px;'></i>Delete</a></button>";
      if($com['Status'] == 0){
        echo "<button type='button' class='btn btn-primary confrim'><a href ='comments.php?do=Approve&comid=".$com['Com_ID']."' style = 'text-decoration:none; color:#fff;'><i class='fa fa-plus' style ='color:#fff; padding-right:2px;'></i>Approve</a></button>";

      }
      echo "</td>";
      echo "</tr>";
    }?>
  
</tbody>
</table>
  </div>

<?php }else{
      echo "<div class='container'>";
         echo "<div class='alert alert-info'> Not found comments</div>";
         echo "</div>";
    }

}elseif($do =='Edit'){
    $isComNum= isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;  //this condtion == above comment
    
    $stmt = $db->prepare("SELECT * FROM comments WHERE Com_ID =? LIMIT 1");
    $stmt->execute(array($isComNum));
    $com = $stmt->fetch();
    $count = $stmt->rowCount();
    if( $count >0){

    ?>
   <h1 class ="text-center"> Edit Comment</h1>
<!-- <div class="container"> -->
<form action="?do=Update" method = "POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Comment</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value= "<?php echo $com['Comment']?>" placeholder="your comment" name="comment" required= "required" autocomplete="off">
  </div>
  <div class="form-group">
    <input type="hidden" class="form-control" id="exampleInputPassword1"   name="comid"   value= "<?php echo $isComNum?>" >
  </div>
  
  
  <button type="submit" class="btn btn-primary"><i class="fa fa-bookmark" aria-hidden="true" style = "color:#fff; padding-right:4px;"></i>Save</button>
</form>
  <!-- </div> -->

   <?php }else{
     $theMsg = "<div class= 'alert alert-danger'>no id on</div>";
     redirecHome($theMsg,'back');
   }
    
}elseif($do =='Update'){
    echo "<h1 class ='text-center'> Update Comment</h1>";
    echo "<div class ='container'>";
     if($_SERVER['REQUEST_METHOD']=='POST'){
       $id = $_POST['comid'];
       $comment = $_POST['comment'];
       
      
       // validat the form
    
       if(!empty($comment)){
        $stmt = $db->prepare("UPDATE Comments SET Comment =?  WHERE Com_ID =? ");
       $stmt->execute(array($comment,$id));
       $theMsg= "<div class ='alert alert-success'>".$stmt->rowCount()."Updates</div>";
       redirecHome($theMsg ,'back');
       }else{
       $theMsg= "<div class ='alert alert-danger'>Comment can't be empty </div>";
       redirecHome($theMsg,'back');
       }
       


   }else{
     $erorrMsg = "<div class = 'alert alert-danger'>you can't browse this page dirctly</div>";
     redirecHome($erorrMsg);
     echo "<div>";
   }
    
}elseif($do =='Delete'){
    echo "<h1 class='text-center'> Delete Comment</h1>";
    $isComNum= isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;  //this condtion == above comment
    
    $check=checkItem('Com_ID' , 'comments' , $isComNum);
    if( $check >0){
      $stmt = $db->prepare("DELETE FROM comments WHERE Com_ID = :id ");
      $stmt->bindParam(":id", $isComNum );
      $stmt->execute();
      echo "<div class='container'>";
      $theMsg= "<div class ='alert alert-success'>".$check ." Deleted</div>";
      redirecHome($theMsg , 'back');
    }else{
      $theMsg="<div class ='alert alert-danger'> This is id is not exist</div>";
      redirecHome($theMsg);
      echo "</div>";
    }
}elseif($do == 'Approve'){ //like delete page
    echo "<h1 class='text-center'> Approve Comment</h1>";
    $isComNum= isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;  //this condtion == above comment
    $check=checkItem('Com_ID' , 'comments' , $isComNum);
    if( $check >0){
      $stmt = $db->prepare("UPDATE comments SET Status = 1 WHERE Com_ID= ? ");
      $stmt->execute(array($isComNum));
      echo "<div class='container'>";
      $theMsg="<div class ='alert alert-success'>".$check ." Approved</div>";
      redirecHome($theMsg,'back');
    }else{
      $theMsg="<div class ='alert alert-danger'> This is id is not exist</div>";
      redirecHome($theMsg , 'back');
      echo "</div>";
    }

  }

include $tps."footer.php";

}else{
    header("location:index.php");
    exit();
}