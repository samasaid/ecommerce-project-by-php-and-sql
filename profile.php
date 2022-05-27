<?php
session_start();
$pageTitle="profile";
include "init.php";
if(isset($_SESSION['user'])){
    $getUser = $db->prepare("SELECT * FROM items WHERE UserName=?");
    $getUser->execute(array( $sessionUser));
    $User = $getUser->fetch();
?>
<div class="container">
    <div class="card info">
            <div class="card-header">
                Personal Information
            </div>
            <div class="card-body">
                <p class="card-text"><i class="fa fa-unlock-alt"></i><span>Username</span> : <?php echo  $User['UserName']; ?></p>
                <p class="card-text"><i class="fa fa-user"></i><span>Full Name</span> : <?php echo  $User['FullName']; ?></p>
                <p class="card-text"><i class="far fa-envelope"></i><span>Email</span> : <?php echo  $User['Email']; ?></p>
                <p class="card-text"><i class="fas fa-calendar-alt"></i><span>Register Date</span> : <?php echo  $User['Date']; ?></p>
                <p class="card-text"><i class="fa fa-tag"></i><span>Favourite Category</span> : </p>
            </div>
    </div>
    <div class="card ads">
            <div class="card-header">
                My Ads
            </div>
            <div class="card-body">
                <?php
                if(!empty(getItem( 'Member_ID' , $User['UserID']) )){
            foreach(getItem( 'Member_ID' , $User['UserID']) as $item){
                echo "<div class='col-lg-4 col-md-6 col-sm-12'>";
                echo '<div class="card item-box" style="width: 18rem;">';
                echo '<span class="price-area">$'.$item['Price'].'</span>';
                echo '<img src="img.png" class="card-img-top" alt="...">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$item['Name'].'</h5>';
                echo '<p class="card-text">'.$item['Description'].'</p>';
                echo  '</div>';
                echo  '</div>';
                echo  '</div>';
            }
        }else{
            echo "<div class='alert alert-info'>there is no Ads, Create <a href='newad.php'>New Ad</a></div>";
        }
                ?>
            </div>
    </div>
    <div class="card comment">
        <div class="card-header">
            My Comments
        </div>
        <div class="card-body">
            <?php
                $stmt = $db->prepare("SELECT Comment FROM comments WHERE userid	=?");
                $stmt->execute(array($User['UserID']));
                $coms = $stmt->fetchAll();
                if(!empty($coms)){
                foreach($coms as $com){
                    echo '<p>'. $com['Comment'].'</p>';
                }
            }else{
               echo "<div class='alert alert-info'>there is no Comments</div>";
            }
            ?>
        </div>
    </div>
</div>
<?php }else{
    header("Location:login.php");
}
?>
<?php include $tps."footer.php";?>