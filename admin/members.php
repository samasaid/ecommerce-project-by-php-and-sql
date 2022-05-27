<?php

// member page code
session_start();
$pageTitle = 'Members';
if(isset($_SESSION['UserName'])){
    include "init.php";

    // if(isset($_GET['do'])){
    //     $do = $_GET['do'];
    // }else{
    //     $do = 'Manage';
    // }

    $do = isset($_GET['do'])? $_GET['do'] :'Manage'; //this condtion == above comment
        // start members pages
    if($do =='Manage'){ // manage page


      $show = "";
      if(isset($_GET['page']) && $_GET['page']=='Pinding'){
        $show = 'AND RegStatus = 0';
      }
      $stmt = $db->prepare("SELECT * FROM items WHERE GroupID !=1 $show  ORDER BY UserID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();
      // $count = $stmt->rowCount();
    
    if(!empty($rows)){
    ?>
    <div class= "container">
      <h1 class="text-center">Manage Page</h1>
      <table class="table table-dark" style="margin-top:20px";>
  <thead>
    <tr class= "col-lg-8 col-sm-12">
      <th scope="col">#ID</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Full Name</th>
      <th scope="col">Register Date</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody>
      <!-- <th scope="row">1</th> -->
      <?php 
      foreach($rows as $row){
        echo "<tr class-'col-lg-8 col-sm-12'>";
        echo "<td>".$row['UserID']."</td>";
        echo "<td>".$row['UserName']."</td>";
        echo "<td>".$row['Email']."</td>";
        echo "<td>".$row['FullName']."</td>";
        echo "<td>".$row['Date']."</td>";
        echo "<td><button type='button' class='btn btn-success' ><a href ='members.php?do=Edit&userid=".$row['UserID']."' style = 'text-decoration:none; color:#fff;'><i class='fa fa-edit' style ='color:#fff; padding-right:2px;'></i>Edit</a></button>
        <button type='button' class='btn btn-danger confrim'><a href ='members.php?do=Delete&userid=".$row['UserID']."' style = 'text-decoration:none; color:#fff;'><i class='fa fa-times' style ='color:#fff; padding-right:2px;'></i>Delete</a></button>";
        if($row['RegStatus'] == 0){
          echo "<button type='button' class='btn btn-info confrim'><a href ='members.php?do=Approve&userid=".$row['UserID']."' style = 'text-decoration:none; color:#fff;'><i class='fa fa-plus' style ='color:#fff; padding-right:2px;'></i>Approve</a></button>";

        }
        echo "</td>";
        echo "</tr>";
      }?>
    
  </tbody>
</table>
<a href="members.php?do=Add"  type="button" class="btn btn-primary" style = "text-decoration:none; color:#fff;"><i class="fa fa-plus" style = "color:#fff; padding-right:2px;"></i>Add New Member</a>
    </div>

    <?php  }else{
      echo "<div class='container'>";
         echo "<div class='alert alert-info'> Not found User</div>";
         echo "<a href ='members.php?do=Add' type='button' class='btn btn-primary' style = 'text-decoration:none; color:#fff;'><i class='fa fa-plus' style ='color:#fff; padding-right:3px;'></i>Add New User</a>";
         echo "</div>";
    }

    }elseif($do == 'Add'){ //Add page  // this is page like Update page

      ?>
      <h1 class ="text-center"> Add New Member</h1>
   <!-- <div class="container"> -->
   <form action="?do=Insert" method = "POST">
     <div class="form-group">
       <label for="exampleInputEmail1">Username</label>
       <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="username" name="username" required= "required" autocomplete="off">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Password</label>
       <input type="password" class="password form-control" id="exampleInputPassword1"  placeholder="Password"  required= "required" name="new-password" autocomplete="new-password">
       <i class"show-pass fa fa-eye-slash"></i>
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Email</label>
       <input type="email" class="form-control" id="exampleInputPassword1"  required= "required" placeholder="your email" name="email">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Full Name</label>
       <input type="text" class="form-control" id="exampleInputPassword1"  required= "required" placeholder="Full Name" name="full">
     </div>
     
     <button type="submit" class="btn btn-primary"><i class="fa fa-plus" style = "color:#fff; padding-right:2px;">Add new Member</button>
   </form>
     <!-- </div> -->
     <?php

    }elseif($do == 'Insert'){ // this is page like Update page
      // echo $_POST['username']." ".$_POST['email']." ".$_POST['new-password']." ".$_POST['full'];
      echo "<h1 class ='text-center'> Insert Member</h1>";
     echo "<div class ='container'>";
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = $_POST['username'];
        $pass = $_POST['new-password'];
        $email = $_POST['email'];
        $fullName = $_POST['full'];
        $hashpass = sha1($pass);
        //password 
          // if(empty($_POST["new-password"])){
          //   $pass = $_POST['old-password'];
          // }else{
          //   $pass =sha1($_POST['new-password']);
          // }
        // $pass=empty($_POST["new-password"])? $_POST['old-password']:sha1($_POST['new-password']); //this condtion == above comment
        // validat the form
        $formError = array();
        if(strlen($username)<3 ){
          $formError[]= "Username can't be less than 3char";
        }
        if(strlen($username)>15 ){
          $formError[]= "Username can't be more than 15char";
        }
        if(empty($username)){
          $formError[]= "Username can't be empty";
        }
        if(empty($pass)){
          $formError[]= "Password can't be empty";
        }
        if(empty($email)){
          $formError[]= "email can't be empty";
        }
        if(empty($fullName)){
          $formError[]= "full name can't be empty";
        }
        foreach ($formError as $error){
          echo "<div class ='alert alert-danger'>". $error ."</div>";
        }
        
        //update database
        
        if(empty($formError)){
          $check = checkItem('UserName' , 'items' , $username);
          if($check == 1){
            $theMsg="<div class='alert alert-danger'>this user exist </div>";
            redirecHome($theMsg,'back');
          }else{
        $stmt = $db->prepare("INSERT INTO items(UserName, Password , Email , FullName , RegStatus ,Date ) 
                              VALUES(:User , :password , :email , :fullname , 1 , now())");
        $stmt->execute(array(
        'User'=> $username, 
        'password'=> $hashpass, 
        'email'=> $email, 
        'fullname'=> $fullName));
        $theMsg= "<div class ='alert alert-success'>".$stmt->rowCount()."Updates</div>";
        redirecHome($theMsg,'back');

          }
        
      }


    }else{
      $theMsg="<div class='alert alert-danger'>you can't browse this page dirctly</div>";
      redirecHome($theMsg);
      echo "<div>";
    }

    }elseif($do =='Edit'){ // Edit page
    
    // if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
    //   echo intval($_GET['userid']);
    // }else{
    //   echo 0;
    // }

    $isUserNum= isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;  //this condtion == above comment
    
    $stmt = $db->prepare("SELECT * FROM items WHERE UserID =? LIMIT 1");
    $stmt->execute(array($isUserNum));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if( $count >0){

    ?>
   <h1 class ="text-center"> Edit Member</h1>
<!-- <div class="container"> -->
<form action="?do=Update" method = "POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value= "<?php echo $row['UserName']?>" placeholder="username" name="username" required= "required" autocomplete="off">
  </div>
  <div class="form-group">
    <input type="hidden" class="form-control" id="exampleInputPassword1"   name="userid"   value= "<?php echo $isUserNum?>" autocomplete="new-password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="hidden" class="form-control" id="exampleInputPassword1"  value="<?php echo $row['Password']?>"  name="old-password" autocomplete="new-password">
    <input type="password" class="form-control" id="exampleInputPassword1"  placeholder="Password" name="new-password" autocomplete="new-password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Email</label>
    <input type="email" class="form-control" id="exampleInputPassword1" value= "<?php echo $row['Email']?>"  required= "required"placeholder="your email" name="email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Full Name</label>
    <input type="text" class="form-control" id="exampleInputPassword1" value= "<?php echo $row['FullName']?>" required= "required" placeholder="Full Name" name="full">
  </div>
  
  <button type="submit" class="btn btn-primary"><i class="fa fa-bookmark" aria-hidden="true" style = "color:#fff; padding-right:4px;"></i>Save</button>
</form>
  <!-- </div> -->

   <?php }else{
     $theMsg = "<div class= 'alert alert-danger'>no id on</div>";
     redirecHome($theMsg,'back');
   }
    }elseif($do == "Update"){  // update page

     echo "<h1 class ='text-center'> Update Member</h1>";
     echo "<div class ='container'>";
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $id = $_POST['userid'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $fullName = $_POST['full'];
        //password 
          // if(empty($_POST["new-password"])){
          //   $pass = $_POST['old-password'];
          // }else{
          //   $pass =sha1($_POST['new-password']);
          // }
        $pass=empty($_POST["new-password"])? $_POST['old-password']:sha1($_POST['new-password']); //this condtion == above comment
        // validat the form
        $formError = array();
        if(strlen($username)<3 ){
          $formError[]= "Username can't be less than 3char";
        }
        if(strlen($username)>15 ){
          $formError[]= "Username can't be more than 15char";
        }
        if(empty($username)){
          $formError[]= "Username can't be empty";
        }
        if(empty($email)){
          $formError[]= "email can't be empty";
        }
        if(empty($fullName)){
          $formError[]= "full name can't be empty";
        }
        foreach ($formError as $error){
        $theMsg= "<div class ='alert alert-danger'>".$error ."</div>";
        redirecHome($theMsg,'back');
        }
        
        //update database
        if(empty($formError)){
          $stmt2 = $db->prepare("SELECT * FROM items WHERE UserName =? AND UserID !=?");
          $stmt2->execute(array($username,$id));
          $row = $stmt2->fetch();
          if($row ==1){
            echo "<div class='alert alert-danger'>Sorry this is User Exist</div>";
          }else{
        $stmt = $db->prepare("UPDATE items SET UserName =? , Email =? , Password =? , FullName =? WHERE UserID =? ");
        $stmt->execute(array($username , $email , $pass , $fullName ,$id));
        $theMsg= "<div class ='alert alert-success'>".$stmt->rowCount()."Updates</div>";
        redirecHome($theMsg,'back');
          }
        }


    }else{
      $erorrMsg = "<div class = 'alert alert-danger'>you can't browse this page dirctly</div>";
      redirecHome($erorrMsg);
      echo "<div>";
    }
  }elseif($do == 'Delete'){ // DELETE PAGE LIKE EDIT PAGE

    echo "<h1 class='text-center'> Delete Members</h1>";
    $isUserNum= isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;  //this condtion == above comment
    // $stmt = $db->prepare("SELECT * FROM items WHERE UserID =? LIMIT 1");
    // $stmt->execute(array($isUserNum));
    // $row = $stmt->fetch();
    // $count = $stmt->rowCount();
    $check=checkItem('UserID' , 'items' , $isUserNum);
    if( $check >0){
      $stmt = $db->prepare("DELETE FROM items WHERE UserID = :id ");
      $stmt->bindParam(":id", $isUserNum );
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
    echo "<h1 class='text-center'> Approve Members</h1>";
    $isUserNum= isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;  //this condtion == above comment
    $check=checkItem('UserID' , 'items' , $isUserNum);
    if( $check >0){
      $stmt = $db->prepare("UPDATE items SET RegStatus = 1 WHERE UserID= ? ");
      $stmt->execute(array($isUserNum));
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