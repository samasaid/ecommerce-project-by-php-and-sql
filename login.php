<?php 
        session_start();
        $pageTitle="login";
        if(isset($_SESSION['user'])){
            header("Location:index.php");
        }
        include "init.php";
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['login'])){
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashpass = sha1($pass);
           
            $stmt = $db->prepare("SELECT UserID , UserName , Password FROM items WHERE UserName =? AND Password =? ");
            $stmt->execute(array($user , $hashpass));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count>0){
                $_SESSION['user'] = $user;
                $_SESSION['u-ID'] = $row['UserID'];
                header("Location:index.php");
                exit();
            }
            // $userNameErrors=array();
            //      if(empty($user)){$userNameErrors[]= "<span class='erorr'>this feiled can't be empty</span><br>";} 
            //      if(strlen($user)<3){$userNameErrors[]= "<span class='erorr'>Username can't be latest than 3char</span><br>";} 
            //      if(strlen($user)>15){$userNameErrors[]= "<span class='erorr'>Username can't be large than 15char</span><br>";}
            //      if(empty($userNameErrors)){
            //         $stmt = $db->prepare("SELECT  UserName , Password FROM items WHERE UserName =? AND Password =? ");
            //         $stmt->execute(array($user , $hashpass));
            //         $row = $stmt->fetch();
            //         $count = $stmt->rowCount();
            //         if($count>0){
            //             $_SESSION['user'] = $user;
            //             header("Location:index.php");
            //             exit();
            //         }
            //      }else{
            //         foreach ($userNameErrors as $erorr){
            //             global $erorr;
            //         }
            //      }
        }
    }
        
        
        
?>
    <div class="container">
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <h2 class="text-center">Login</h2>
            <div class="form-group">
                <label for="exampleInputEmail1">UserName</label>
                <input type="text" class="form-control" placeholder="Enter Your Username" name="username" required="required">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" placeholder="Enter Your Password" name="password" required="required">
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
        </form>
    </div>
    
    <?php  include $tps."footer.php";?>