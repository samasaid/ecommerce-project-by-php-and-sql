<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $css?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css?>animate.css">
    <link rel="stylesheet" href="<?php echo $css?>all.css">
    <link rel="stylesheet" href="<?php echo $css?>style.css">
    <link rel="stylesheet" href="<?php echo $fonts?>@fortawesome/fontawesome-free-webfonts/css/fontawesome.css">
    <link rel="stylesheet" href="<?php echo $fonts?>@fortawesome/fontawesome-free-webfonts/css/fa-solid.css">
    <link rel="stylesheet" href="<?php echo $fonts?>@fortawesome/fontawesome-free-webfonts/css/fa-regular.css">
    <link rel="stylesheet" href="<?php echo $fonts?>@fortawesome/fontawesome-free-webfonts/css/fa-brands.css">
    <title><?php echo getTitle();?></title>
</head>
<body>

    <div class="container">
      <div class="row">
            <?php
                if(isset($_SESSION['user'])){
                 echo '<div class="col-sm-6 upper-bar">';
                 echo "wellcome ".$sessionUser ;
                 echo "<a href='profile.php'> My Profile </a>"." - ";
                 echo "<a href='newad.php'>New Ad</a>"." - ";
                 echo "<a href='logout.php'> Logout</a>";
                
                
                 $userStatus = checkUserStatus($_SESSION['user']);
                 if( $userStatus  ==1){

                 }else{}
                 echo "</div>";
              } else{ ?>
              <div class="col-sm-6">
              </div>
            <div class="col-sm-6">
              <div class="text-right upper-bar">
             <a href="login.php"><button type="button" class="btn btn-primary">Login</button></a>
             <a href="Sign.php"> <button type="button" class="btn btn-success">Sign Up</button></a>
              </div>
            </div>
      </div><?php } ?>
    </div> 
  </div>

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php
        foreach(getCat() as $cat){
            echo "<li class='nav-item'><a class='nav-link' href='categories.php?pageid=".$cat['ID']."&pagename=".str_replace(' ','-',$cat['Name'])."'>".$cat['Name']."</a></li>";
        }
      ?>
      
     </ul>
  </div>
      </div>
</nav>
    
