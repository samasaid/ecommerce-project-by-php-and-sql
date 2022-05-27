<?php  

session_start();
$pageTitle="signup";
include "init.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['signup'])){

        $formErorrs = array();
        $username= $_POST['username'];
        $full= $_POST['fullName'];
        $email = $_POST['email'];
        $password = $_POST['password1'];
        $hashpass = sha1($password);
        if(isset($username)){
            $filterdUser= filter_var($username , FILTER_SANITIZE_STRING);
            if(strlen($filterdUser)<3){
                $formErorrs[] = "Username must be lager than 3chars";
            }
        } 
        if(isset($full)){
            $filterdName= filter_var($full , FILTER_SANITIZE_STRING);
            if(strlen($filterdName)<4){
                $formErorrs[] = "Full Name must be lager than 4chars";
            }
        } 
        if(isset($email)){
            $filterdEmail= filter_var($email , FILTER_SANITIZE_EMAIL);
            if(filter_var( $filterdEmail , FILTER_VALIDATE_EMAIL != true)){
                $formErorrs[] = "this is email not valid";
            }
        } 
        if(isset($password) && isset($_POST['password2'])){
            if(empty($password)){
                echo "sorry password can't be empty";
            }
            $pass1= sha1($password);
            $pass2= sha1($_POST['password2']);
            if($pass1 !== $pass2){
                $formErorrs[] = "password is not match";
            }
        }
        if(empty($formErorrs)){
            $check = checkItem('UserName' , 'items' , $username);
            if($check ==1 ){
                echo '<div class="container">';
                echo "<div class='alert alert-danger'> this is username Exist</div>";
                echo "</div>";
            }else{
                $stmt = $db->prepare("INSERT INTO items(UserName,  FullName , Email ,  Password , RegStatus ,Date ) 
                                      VALUES(:User , :fullName , :email , :password , 0 , now())");
                $stmt->execute(array(
                'User'=> $username,
                'fullName'=> $full,
                'email'=> $email, 
                'password'=> $hashpass 
                ));
                echo '<div class="container">';
                echo "<div class ='alert alert-success'>Wellcome with you in our shop Admin will active You</div>";
                echo "</div>";
        
            }
        } 

    }
}


?>
<div class="container">
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <h2 class="text-center">Sign Up</h2>
            <div class="form-group">
                <label for="exampleInputEmail1">UserName</label>
                <input pattern=".{3,}" title="Username must be lager than 3chars" type="text" class="form-control" placeholder="Enter Your Username" name="username" required="required">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Full Name</label>
                <input pattern=".{4,}" title="Full Name must be lager than 3chars" type="text" class="form-control" placeholder="Enter Your Full Name" name="fullName" required="required">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email Address</label>
                <input type="email" class="form-control" placeholder="Enter Your Email" name="email" required="required">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" minlength="4" class="form-control" placeholder="Enter Password" name="password1" required="required">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input type="password" minlength="4" class="form-control" placeholder="Enter Password again " name="password2" required="required">
            </div>
            <button type="submit" class="btn btn-success btn-block" name="signup">Sign Up</button>
        </form>
</div>
    <!-- <div class="erorr-box">
        <?php
         foreach ($formErrors as $erorr){
                        echo $erorr;
                    }
        ?>

     </div>    -->

<?php  include $tps."footer.php";?>