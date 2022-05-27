<?php

session_start();
$pageTitle = 'Items';
if(isset($_SESSION['UserName'])){
    include "init.php";

$do = isset($_GET['do'])? $_GET['do'] :'Manage';

if($do =='Manage'){
   // manage page

      $stmt = $db->prepare("SELECT itemtbl.*, category.Name As category_Name ,items.UserName
                            FROM itemtbl
                            INNER JOIN category ON category.ID = itemtbl.Cat_ID
                            INNER JOIN items ON items.UserID = itemtbl.Member_ID
                            ORDER BY item_ID DESC
       ");
      $stmt->execute();
      $items = $stmt->fetchAll();
      // $count = $stmt->rowCount();
    
    if(!empty($items)){
    ?>
    <div class= "container">
      <h1 class="text-center">Manage Items Page</h1>
      <table class="table table-dark" style="margin-top:20px";>
  <thead>
    <tr class= "col-lg-8 col-sm-12">
      <th scope="col">#ID</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">price</th>
      <th scope="col">Category Name</th>
      <th scope="col">User Name</th>
      <th scope="col">Register Date</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody>
      <!-- <th scope="row">1</th> -->
      <?php 
      foreach($items as $item){
        echo "<tr class-'col-lg-8 col-sm-12'>";
        echo "<td>".$item['item_ID']."</td>";
        echo "<td>".$item['Name']."</td>";
        echo "<td>".$item['Description']."</td>";
        echo "<td>".$item['Price']."</td>";
        echo "<td>".$item['category_Name']."</td>";
        echo "<td>".$item['UserName']."</td>";
        echo "<td>".$item['Add_Date']."</td>";
        echo "<td><button type='button' class='btn btn-success' ><a href ='items.php?do=Edit&itemid=".$item['item_ID']."' style = 'text-decoration:none; color:#fff;'>Edit</a></button>
        <button type='button' class='btn btn-danger confrim'><a href ='items.php?do=Delete&itemid=".$item['item_ID']."' style = 'text-decoration:none; color:#fff;'>Delete</a></button>";
        if($item['Approve'] == 0){
          echo "<button type='button' class='btn btn-info confrim'><a href ='items.php?do=Approve&itemid=".$item['item_ID']."' style = 'text-decoration:none; color:#fff;'>Approve</a></button>";

        }
        echo "</td>";
        echo "</tr>";
      }?>
      </div>
    
  </tbody>
</table>
<button type="button" class="btn btn-primary"><a href="items.php?do=Add" style = "text-decoration:none; color:#fff;">Add New Member</a></button>
    

    <?php }else{
      echo "<div class='container'>";
         echo "<div class='alert alert-info'> Not found Item</div>";
         echo "<a href ='items.php?do=Add' type='button' class='btn btn-primary' style = 'text-decoration:none; color:#fff;'><i class='fa fa-plus' style ='color:#fff; padding-right:3px;'></i>Add New Item</a>";
         echo "</div>";
    }
   


}elseif($do =='Add'){  ?>

    <h1 class ="text-center"> Add New Item</h1>
   <!-- <div class="container"> -->
   <form action="?do=Insert" method = "POST">
     <div class="form-group">
       <label for="exampleInputEmail1">Item Name</label>
       <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Item Name" name="item" required= "required" >
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Description</label>
       <input type="text" class="password form-control" id="exampleInputPassword1"  placeholder="Item Description"   name="description"  required= "required" >
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Price</label>
       <input type="text" class="form-control" id="exampleInputPassword1"   placeholder="Item Price" name="price"  required= "required">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Country Made</label>
       <input type="text" class="form-control" id="exampleInputPassword1"   placeholder="Item Country" name="country">
     </div> 
     <div class="form-group">
        <label for="exampleFormControlSelect1">Status</label>
        <select class="form-control" id="exampleFormControlSelect1" name='status'>
        <option value='0'>Select Status</option>
        <option value='1'>New</option>
        <option value='2'>Like New</option>
        <option value='3'>Used</option>
        <option value='4'>Old</option>
       </select>
     </div>
     <div class="form-group">
        <label for="exampleFormControlSelect1">Member</label>
        <select class="form-control" id="exampleFormControlSelect1" name='member'>
        <option value='0'>Select Member</option>
        <?php
        $stmt=$db->prepare("SELECT * FROM items");
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach($users as $user){
          echo "<option value='".$user['UserID']."'>".$user['UserName']."</option>";
        }
        ?>
       </select>
     </div>
     <div class="form-group">
        <label for="exampleFormControlSelect1">Category</label>
        <select class="form-control" id="exampleFormControlSelect1" name='category'>
        <option value='0'>Select Category</option>
        <?php
        $stmt2=$db->prepare("SELECT * FROM category");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
        foreach($cats as $cat){
          echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
        }
        ?>
       </select>
     </div>

     <button type="submit" class="btn btn-primary">Add new Item</button>
   </form>
     <!-- </div> -->
     <?php

}elseif($do =='Insert'){
    echo "<h1 class ='text-center'> Insert Item</h1>";
    echo "<div class ='container'>";
     if($_SERVER['REQUEST_METHOD']=='POST'){
       $itemName = $_POST['item'];
       $desc = $_POST['description'];
       $price = $_POST['price'];
       $countryMade = $_POST['country'];
       $itemStatus = $_POST['status'];
       $member = $_POST['member'];
       $category = $_POST['category'];
      
       // validat the form
       $formError = array();
       if(strlen($itemName)<3 ){
         $formError[]= "Name can't be less than 3char";
       }
       if(strlen($itemName)>15 ){
         $formError[]= "Name can't be more than 15char";
       }
       if(empty($itemName)){
         $formError[]= "Name can't be empty";
       }
       if(empty($desc)){
         $formError[]= "Description can't be empty";
       }
       if(empty($price)){
         $formError[]= "price can't be empty";
       }
       if(empty($countryMade)){
         $formError[]= "Country Made can't be empty";
       }
       if($itemStatus == 0){
        $formError[]= "You can't choose empty status";
      }
      if($member == 0){
        $formError[]= "You can't choose empty member";
      }
      if($category == 0){
        $formError[]= "You can't choose empty category";
      }
       foreach ($formError as $error){
         echo "<div class ='alert alert-danger'>". $error ."</div>";
       }
       
       //update database
       
       if(empty($formError)){
        
       $stmt = $db->prepare("INSERT INTO itemtbl(Name,	Description , Price , 	Country_Made ,	Status ,	Add_Date , Cat_ID , Member_ID  ) 
                             VALUES(:name , :desc , :price , :country , :status , now() , :cat ,:member)");
       $stmt->execute(array(
       'name'=> $itemName, 
       'desc'=> $desc, 
       'price'=> $price, 
       'country'=> $countryMade,
       'status'=> $itemStatus,
       'cat'=> $category,
       'member'=> $member

    
    ));
       $theMsg= "<div class ='alert alert-success'>".$stmt->rowCount()."Updates</div>";
       redirecHome($theMsg,'back');

         
       
     }


   }else{
     $theMsg="<div class='alert alert-danger'>you can't browse this page dirctly</div>";
     redirecHome($theMsg);
     echo "<div>";
   }

    
}elseif($do =='Edit'){

  $isItemNum= isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0; 
    
  $stmt = $db->prepare("SELECT * FROM itemtbl WHERE item_ID =? ");
  $stmt->execute(array($isItemNum));
  $itm = $stmt->fetch();
  $count = $stmt->rowCount();
  if( $count >0){

  ?>
  <h1 class ="text-center"> Edit Item</h1>
   <!-- <div class="container"> -->
   <form action="?do=Update" method = "POST">
     <div class="form-group">
       <label for="exampleInputEmail1">Item Name</label>
       <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value ="<?php echo $itm['Name'] ?>"  placeholder="Item Name" name="item" required= "required" >
     </div>
     <div class="form-group">
    <input type="hidden" class="form-control" id="exampleInputPassword1"   name="itemID"   value= "<?php echo $isItemNum?>" >
  </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Description</label>
       <input type="text" class="password form-control" id="exampleInputPassword1"  value ="<?php echo $itm['Description'] ?>" placeholder="Item Description"   name="description"  required= "required" >
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Price</label>
       <input type="text" class="form-control" id="exampleInputPassword1" value ="<?php echo $itm['Price'] ?>"  placeholder="Item Price" name="price"  required= "required">
     </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Country Made</label>
       <input type="text" class="form-control" id="exampleInputPassword1" value ="<?php echo $itm['Country_Made'] ?>"  placeholder="Item Country" name="country">
     </div> 
     <div class="form-group">
        <label for="exampleFormControlSelect1">Status</label>
        <select class="form-control" id="exampleFormControlSelect1" name='status'>
        <option value='0'>Select Status</option>
        <option value='1' <?php if($itm['Status']==1){echo "selected";}?>>New</option>
        <option value='2' <?php if($itm['Status']==2){echo "selected";}?>>Like New</option>
        <option value='3' <?php if($itm['Status']==3){echo "selected";}?>>Used</option>
        <option value='4' <?php if($itm['Status']==4){echo "selected";}?>>Old</option>
       </select>
     </div>
     <div class="form-group">
        <label for="exampleFormControlSelect1">Member</label>
        <select class="form-control" id="exampleFormControlSelect1" name='member'>
        <option value='0'>Select Member</option>
        <?php
        $stmt=$db->prepare("SELECT * FROM items");
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach($users as $user){
          echo "<option value='".$user['UserID']."'";
          if($itm['Member_ID'] == $user['UserID']){echo "selected";}
          echo ">".$user['UserName']."</option>";
        }
        ?>
       </select>
     </div>
     <div class="form-group">
        <label for="exampleFormControlSelect1">Category</label>
        <select class="form-control" id="exampleFormControlSelect1" name='category'>
        <option value='0'>Select Category</option>
        <?php
        $stmt2=$db->prepare("SELECT * FROM category");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
        foreach($cats as $cat){
          echo "<option value='".$cat['ID']."'";
          if($itm['Cat_ID'] == $cat['ID']){echo "selected";}
          echo ">".$cat['Name']."</option>";
        }
        ?>
       </select>
     </div>
     <button type="submit" class="btn btn-primary">Save</button>
   </form>
   <?php
    $stmt2 = $db->prepare("SELECT comments.*, items.UserName
    FROM comments
    INNER JOIN items ON items.UserID = comments.userid
    WHERE item_ID=? ");
    $stmt2->execute(array($isItemNum));
    $coms = $stmt2->fetchAll();
    // $count = $stmt->rowCount();
  
  
  
  if(!empty($coms)){
    ?>
  <div class= "container">
    <h1 class="text-center">Manage <?php echo $itm['Name']?> Page</h1>
    <table class="table table-dark" style="margin-top:20px";>
<thead>
  <tr class= "col-lg-8 col-sm-12">
    <th scope="col">UserName</th>
    <th scope="col">Comment</th>
    <th scope="col">Register Date</th>
    <th scope="col">Control</th>
  </tr>
</thead>
<tbody>
    <!-- <th scope="row">1</th> -->
    <?php 
    foreach($coms as $com){
      echo "<tr class-'col-lg-8 col-sm-12'>";
      echo "<td>".$com['UserName']."</td>";
      echo "<td>".$com['Comment']."</td>";
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

  <?php }
  }
    
}elseif($do =='Update'){
  echo "<h1 class ='text-center'> Update Item</h1>";
  echo "<div class ='container'>";
   if($_SERVER['REQUEST_METHOD']=='POST'){
     $id = $_POST['itemID'];
     $itemName = $_POST['item'];
     $desc = $_POST['description'];
     $price = $_POST['price'];
     $country = $_POST['country'];
     $itemStatus = $_POST['status'];
     $member = $_POST['member'];
     $category = $_POST['category'];
    
    
     $formError = array();
     if(strlen($itemName)<3 ){
       $formError[]= "Name can't be less than 3char";
     }
     if(strlen($itemName)>20 ){
       $formError[]= "Name can't be more than 20char";
     }
     if(empty($itemName)){
       $formError[]= "Name can't be empty";
     }
     if(empty($desc)){
       $formError[]= "Description can't be empty";
     }
     if(empty($price)){
       $formError[]= "Price can't be empty";
     }
     if($itemStatus ==0){
      $formError[]= "Status can be choose";
    }
    if( $member == 0){
      $formError[]= "Member can be choose";
    }
    if( $category == 0){
      $formError[]= "Category can be choose";
    }
     foreach ($formError as $error){
     $theMsg= "<div class ='alert alert-danger'>".$error ."</div>";
     redirecHome($theMsg,'back');
     }
     
     //update database
     if(empty($formError)){
     $stmt = $db->prepare("UPDATE itemtbl SET 	Name =? , Description =? , Price =? , Country_Made =? , Status =? , Cat_ID =? ,	Member_ID =? WHERE item_ID =? ");
     $stmt->execute(array($itemName , $desc , $price ,$country ,$itemStatus , $category , $member , $id));
     $theMsg= "<div class ='alert alert-success'>".$stmt->rowCount()."Updates</div>";
     redirecHome($theMsg , 'back');
     }


 }else{
   $erorrMsg = "<div class = 'alert alert-danger'>you can't browse this page dirctly</div>";
   redirecHome($erorrMsg);
   echo "<div>";
 }
    
}elseif($do =='Delete'){
  echo "<h1 class='text-center'> Delete Item</h1>";
  $isItemNum= isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;  //this condtion == above comment
  // $stmt = $db->prepare("SELECT * FROM items WHERE UserID =? LIMIT 1");
  // $stmt->execute(array($isUserNum));
  // $row = $stmt->fetch();
  // $count = $stmt->rowCount();
  $check=checkItem('item_ID' , 'itemtbl' , $isItemNum);
  if( $check >0){
    $stmt = $db->prepare("DELETE FROM itemtbl WHERE item_ID = :id ");
    $stmt->bindParam(":id", $isItemNum );
    $stmt->execute();
    echo "<div class='container'>";
    $theMsg= "<div class ='alert alert-success'>".$check ." Deleted</div>";
    redirecHome($theMsg , 'back');
  }else{
    $theMsg="<div class ='alert alert-danger'> This is id is not exist</div>";
    redirecHome($theMsg);
    echo "</div>";
  }
    
}elseif($do =='Approve'){
  echo "<h1 class='text-center'> Approve Item</h1>";
  $isItemNum= isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;  //this condtion == above comment
  $check=checkItem('item_ID' , 'itemtbl' , $isItemNum);
  if($check >0){
    $stmt = $db->prepare("UPDATE itemtbl SET Approve = 1 WHERE item_ID= ? ");
    $stmt->execute(array($isItemNum));
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