<?php

session_start();
$noNavbar='';
$pageTitle = 'login';
if(isset($_SESSION['UserName'])){
    header("Location:dashbord.php");
}
include "init.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashpass = sha1($password);
   
    $stmt = $db->prepare("SELECT UserID , UserName ,Password FROM items WHERE UserName =? AND Password =? AND GroupID =1 LIMIT 1");
    $stmt->execute(array($username , $hashpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count>0){
        $_SESSION['UserName'] = $username;
        $_SESSION['ID'] = $row['UserID'];
        header("Location:dashbord.php");
        exit();
    }
    

}
?>
<!-- start login form -->
<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4> Loin form </h4>
  <div class="form-group">
    <label for="exampleInputEmail1">User Name</label>
    <input type="text" class="form-control" name="user" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="User Name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="pass" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" class="form-check-input">
      Check me out
    </label>
  </div>
  <button type="submit" class="btn btn-primary">login</button>
</form>
 <!-- end login form -->

<?php
include $tps."footer.php"
?>