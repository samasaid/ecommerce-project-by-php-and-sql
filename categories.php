<?php  
session_start();
$pageTitle="categories";

include "init.php";

?>

<div class="container">
    <h1 class='text-center'><?php echo str_replace('-' , ' ', $_GET['pagename']) ?></h1>
    <div class="row">
        <?php
            foreach(getItem( 'Cat_ID' , $_GET['pageid']) as $item){
                echo "<div class='col-lg-4 col-md-6 col-sm-12'>";
                echo '<div class="card item-box" style="width: 18rem;">';
                echo '<span class="price-area">$'.$item['Price'].'</span>';
                echo '<img src="img.png" class="card-img-top" alt="...">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$item['Name'].'</h5>';
                echo '<p class="card-text">'.$item['Description'].'</p>';
                echo  '</div>';
                echo  '</div>';

                echo "</div>";

            }
        ?>
    </div>
</div>
<?php include $tps."footer.php";?>