<?php
 ob_start();
session_start();
$pageTitle = 'Category';
if(isset($_SESSION['UserName'])){
    include "init.php";

$do = isset($_GET['do'])? $_GET['do'] :'Manage';

if($do =='Manage'){

    $sort ='ASC';
    $sort_array =array('ASC' , 'DESC');
    if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
        $sort = $_GET['sort'];
    }
    $getOrder = "Ordering";
    $order_array = array('Ordring' , 'ID');
        if(isset($_GET['order']) &&  in_array($_GET['order'],$sort_array)){
            $getOrderVar = isset($_GET['order']);
        }
   
    
    // $getOrderVar = getOrder();

    $stmt = $db->prepare("SELECT * FROM category ORDER BY $getOrder $sort");
    $stmt->execute();
    $cats = $stmt->fetchAll();
    if(!empty($cats)){
    ?>
    <div class='container'>
    <div class="card cats">
            <div class="card-header">
                Latest Catecory
                <div class= 'option  float-right'>
                    Ordering bY Category Order:
                    <a href ='categories.php?sort=ASC&order=Ordering' class='<?php if($sort == 'ASC'){echo "active";}?>'> ASC </a>|
                    <a href ='categories.php?sort=DESC&order=Ordering' class='<?php if($sort == 'DESC'){echo "active";}?>' >DESC</a>
                  -  Ordering bY Category ID:
                    <a href ='categories.php?sort=ASC&order=ID' class='<?php if($sort == 'ASC'){echo "active";}?>'> ASC </a>|
                    <a href ='categories.php?sort=DESC&order=ID' class='<?php if($sort == 'DESC'){echo "active";}?>' >DESC</a>
                  -  View:
                    <span data-view='full'>Full</span> |
                    <span data-view='classic'>Classic</span>  
                </div>
            </div>
            <div class="card-body">
            <?php
                foreach($cats as $cat){
                    echo "<div class='cat'>";
                    echo "<div class='hidden-button'>";
                    echo "<a class='btn btn-success' style= 'text-decoration:none; color:#fff;' href='categories.php?do=Edit&catid=".$cat['ID']."'>Edit</a>";
                    echo "<a class='btn btn-danger' style = 'text-decoration:none; color:#fff;' href='categories.php?do=Delete&catid=".$cat['ID']."'>Delete</a>";
                    echo "</div>";
                    echo "<h3>".$cat['Name']."</h3>";
                    echo "<div class='fullView'>";
                    echo "<p>";if($cat['Description'] == ''){echo "this category not have Description";}else{echo $cat['Description'];}echo"<p>";
                    if($cat['Visibility']==1){ echo "<span class='vis'>Hidden</span>";}
                    if($cat['AllowComment']==1){ echo "<span class='com'>Comment Disable</span>";}
                    if($cat['AllowAds']==1){ echo "<span class='ads'>Ads Disable</span>";}
                    echo "</div>";
                    echo "</div>";
                    echo "<hr>";
                }
                ?>
            </div>
    </div>
    <a href="categories.php?do=Add"  class="btn btn-primary" style = "text-decoration:none; color:#fff; margin-top:20px !important;">Add New Category</a>
    </div>
    <?php
    }else{
      echo "<div class='container'>";
         echo "<div class='alert alert-info'> Not found Categories</div>";
         echo "<a href ='categories.php?do=Add' type='button' class='btn btn-primary' style = 'text-decoration:none; color:#fff;'><i class='fa fa-plus' style ='color:#fff; padding-right:3px;'></i>Add New Category</a>";
         echo "</div>";
    }

}elseif($do =='Add'){ ?>

    <h1 class ="text-center"> Add New Category</h1>
   <!-- <div class="container"> -->
   <form action="?do=Insert" method = "POST">
     <div class="form-group">
       <label for="exampleInputEmail1">Category</label>
       <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Category Name" name="category" required= "required" autocomplete="off">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Description</label>
       <input type="text" class="password form-control" id="exampleInputPassword1"  placeholder="Category Description"   name="description" autocomplete="new-password">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Ordering</label>
       <input type="text" class="form-control" id="exampleInputPassword1"   placeholder="Category Order" name="order">
     </div>
    <fieldset class="form-group">
            <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Visibility</legend>
            <div class="col-sm-10">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="visiplity" id="vis-yes" value="0" checked>
                <label class="form-check-label" for="vis-yes">
                    yes
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="visiplity" id="vis-no"  value="1">
                <label class="form-check-label" for="vis-no">No</label>
                </div>
            </div>
            </div>
    </fieldset>
    <fieldset class="form-group">
            <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Allow Commenting</legend>
            <div class="col-sm-10">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="comment" id="com-yes" value="0" checked>
                <label class="form-check-label" for="com-yes">
                    yes
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="comment" id="com-no"  value="1">
                <label class="form-check-label" for="com-no">No</label>
                </div>
            </div>
            </div>
    </fieldset>
    <fieldset class="form-group">
            <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Allow Ads</legend>
            <div class="col-sm-10">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="0" checked>
                <label class="form-check-label" for="ads-yes">
                    yes
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="ads" id="ads-no"  value="1">
                <label class="form-check-label" for="ads-no">No</label>
                </div>
            </div>
            </div>
    </fieldset>
     
     
     <button type="submit" class="btn btn-primary">Add new Category</button>
   </form>
     <!-- </div> -->
     <?php

}elseif($do =='Insert'){
    echo "<h1 class ='text-center'> Insert Category</h1>";
     echo "<div class ='container'>";
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $catName = $_POST['category'];
        $desc = $_POST['description'];
        $order = $_POST['order'];
        $vis = $_POST['visiplity'];
        $com = $_POST['comment'];
        $ads = $_POST['ads'];
        
        //update database
        
        if(!empty($catName)){
          $check = checkItem('Name' , 'category' , $catName);
          if($check == 1){
            $theMsg="<div class='alert alert-info'>this category exist </div>";
            redirecHome($theMsg,'back');
          }else{
        $stmt = $db->prepare("INSERT INTO category( Name, Description , Ordering , Visibility , AllowComment , AllowAds) 
                              VALUES( :name , :description , :order , :visiblity , :comment , :ads )");
        $stmt->execute(array(
        'name'        => $catName, 
        'description' => $desc, 
        'order'       => $order, 
        'visiblity'   => $vis,
        'comment'     => $com,
        'ads'         => $ads
    ));
        $theMsg= "<div class ='alert alert-success'>".$stmt->rowCount()."Updates</div>";
        redirecHome($theMsg,'back');

          }
        
      }


    }else{
      $theMsg="<div class='alert alert-danger'>you can't browse this page dirctly</div>";
      redirecHome($theMsg);
      echo "<div>";
    }
    
}elseif($do =='Edit'){
    echo "<h1 class ='text-center'> Edit Category</h1>";
    $isCatNum= isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;  //this condtion == above comment
    
    $stmt = $db->prepare("SELECT * FROM category WHERE ID =? ");
    $stmt->execute(array($isCatNum));
    $cat = $stmt->fetch();
    $count = $stmt->rowCount();
    if( $count >0){?>
<form action="?do=Update" method = "POST">
    <div class="form-group">
        <input type="hidden" class="form-control" id="exampleInputPassword1"   name="catid"   value= "<?php echo $isCatNum?>">
    </div>
     <div class="form-group">
       <label for="exampleInputEmail1">Category</label>
       <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"   value="<?php echo $cat['Name']?>" placeholder="Category Name" name="category" required= "required" autocomplete="off">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Description</label>
       <input type="text" class="password form-control" id="exampleInputPassword1"  value="<?php echo $cat['Description']?>" placeholder="Category Description"   name="description" autocomplete="new-password">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Ordering</label>
       <input type="text" class="form-control" id="exampleInputPassword1"   value="<?php echo $cat['Ordering']?>" placeholder="Category Order" name="order">
     </div>
    <fieldset class="form-group">
            <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Visibility</legend>
            <div class="col-sm-10">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="visiplity" id="vis-yes" value="0" <?php if($cat['Visibility']==0){echo "checked";}?> >
                <label class="form-check-label" for="vis-yes">
                    yes
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="visiplity" id="vis-no"  value="1" <?php if($cat['Visibility']==1){echo "checked";}?> >
                <label class="form-check-label" for="vis-no">No</label>
                </div>
            </div>
            </div>
    </fieldset>
    <fieldset class="form-group">
            <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Allow Commenting</legend>
            <div class="col-sm-10">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="comment" id="com-yes" value="0" <?php if($cat['AllowComment']==0){echo "checked";}?>>
                <label class="form-check-label" for="com-yes">
                    yes
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="comment" id="com-no"  value="1" <?php if($cat['AllowComment']==1){echo "checked";}?>>
                <label class="form-check-label" for="com-no">No</label>
                </div>
            </div>
            </div>
    </fieldset>
    <fieldset class="form-group">
            <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Allow Ads</legend>
            <div class="col-sm-10">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="0" <?php if($cat['AllowAds']==0){echo "checked";}?>>
                <label class="form-check-label" for="ads-yes">
                    yes
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="ads" id="ads-no"  value="1" <?php if($cat['AllowAds']==1){echo "checked";}?>>
                <label class="form-check-label" for="ads-no">No</label>
                </div>
            </div>
            </div>
    </fieldset>
     
     
     <button type="submit" class="btn btn-primary">Edit Category</button>
</form>
    ?>

   <?php }else{
     $theMsg= "<div class= 'alert alert-danger'>no id on</div>";
     redirecHome($theMsg,'back');
   }
}elseif($do =='Update'){

    echo "<h1 class ='text-center'> Update Category</h1>";
     echo "<div class ='container'>";
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $id = $_POST['catid'];
        $catName = $_POST['category'];
        $desc = $_POST['description'];
        $order = $_POST['order'];
        $vis = $_POST['visiplity'];
        $com = $_POST['comment'];
        $ads = $_POST['ads'];
        
        // validat the form
        $formError = array();
        if(strlen($catName)<3 ){
          $formError[]= "Username can't be less than 3char";
        }
        if(strlen($catName)>20 ){
          $formError[]= "Username can't be more than 15char";
        }
        if(empty($catName)){
          $formError[]= "Username can't be empty";
        }
        foreach ($formError as $error){
        $theMsg= "<div class ='alert alert-danger'>".$error ."</div>";
        redirecHome($theMsg,'back');
        }
        
        //update database
        if(empty($formError)){
        $stmt = $db->prepare("UPDATE category SET Name=? , Description=? , Ordering =? , Visibility =? , AllowComment=? , AllowAds=? WHERE ID =? ");
        $stmt->execute(array($catName , $desc , $order , $vis ,$com , $ads ,$id));
        $theMsg= "<div class ='alert alert-success'>".$stmt->rowCount()."Updates</div>";
        redirecHome($theMsg);
        }


    }else{
      $theMsg="<div class = 'alert alert-danger'>you can't browse this page dirctly</div>";
      redirecHome($theMsg);
      echo "<div>";
    }
  }elseif($do == 'Delete'){ // DELETE PAGE LIKE EDIT PAGE

    echo "<h1 class='text-center'> Delete Category</h1>";
    $isCatNum= isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;  //this condtion == above comment
    // $stmt = $db->prepare("SELECT * FROM items WHERE UserID =? LIMIT 1");
    // $stmt->execute(array($isUserNum));
    // $row = $stmt->fetch();
    // $count = $stmt->rowCount();
    $check=checkItem('ID' , 'category' , $isCatNum);
    if( $check >0){
      $stmt = $db->prepare("DELETE FROM category WHERE ID = :id ");
      $stmt->bindParam(":id", $isCatNum );
      $stmt->execute();
      echo "<div class='container'>";
      $theMsg= "<div class ='alert alert-success'>".$check ." Deleted</div>";
      redirecHome($theMsg , 'back');
    }else{
      $theMsg="<div class ='alert alert-danger'> This is id is not exist</div>";
      redirecHome($theMsg);
      echo "</div>";
    }
}
    
include $tps."footer.php";

}else{
    header("location:index.php");
    exit();
}
ob_end_flush();