<?php
session_start();
$pageTitle=" Create New item";
include "init.php";
if(isset($_SESSION['user'])){
// if($_SERVER['REQUEST_METHOD']=='POST'){
//     $itemName= filter_var($_POST['item'] , FILTER_SANITIZE_STRING);
//     $itemDesc= filter_var($_POST['description'] ,FILTER_SANITIZE_STRING);
//     $itemPrice= filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
//     $itemCountry= filter_var($_POST['country'],FILTER_SANITIZE_STRING);
//     $itemStatus= filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
//     $itemCategory=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
    

//     $formErrors = array();
//        if(strlen($itemName)<3 ){
//          $formErrors[]= "Name can't be less than 3chars";
//        }
//        if(strlen($itemName)>20 ){
//          $formErrors[]= "Name can't be more than 15chars";
//        }
//        if(empty($itemName)){
//          $formErrors[]= "Name can't be empty";
//        }
//        if(strlen($itemDesc)<10 ){
//         $formErrors[]= "Description can't be less than 10chars";
//       }
//        if(empty($itemDesc)){
//          $formErrors[]= "Description can't be empty";
//        }
//        if(empty($itemPrice)){
//          $formErrors[]= "price can't be empty";
//        }
//        if(strlen($itemCountry)<2){
//         $formErrors[]= "Country Made can't be less than 2chars";
//       }
//        if(empty($itemCountry)){
//          $formErrors[]= "Country Made can't be empty";
//        }
//        if($itemStatus == 0){
//         $formErrors[]= "You can't choose empty status";
//       }
//       if($itemCategory == 0){
//         $formErrors[]= "You can't choose empty category";
//       }
//        //update database
       
//        if(empty($formErrors)){
        
//        $stmt = $db->prepare("INSERT INTO itemtbl(Name,	Description , Price , 	Country_Made ,	Status , Add_Date , Cat_ID , Member_ID) 
//                              VALUES(:name , :desc , :price , :country , :status , now() , :cat , :member)");
//        $stmt->execute(array(
//        'name'=> $itemName, 
//        'desc'=> $itemDesc, 
//        'price'=> $itemPrice, 
//        'country'=> $itemCountry,
//        'status'=> $itemStatus,
//        'cat'=> $itemCategory,
//        'member'=>$_SESSION['u-ID']
    
//     ));
//         echo '<div class="container">';
//        echo "<div class ='alert alert-success'>success!<br>Your Will active from Admin</div>"; 
//        echo'</div>';  
//      }

// }
   
?>
<div class="container">
    <h1 class="text-center"> <?php echo $pageTitle ?> </h1>
    <div class="card info">
            <div class="card-header">
                <?php echo $pageTitle ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                    <form  action="<?php echo $_SERVER['PHP_SELF']?>" method = "POST">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Item Name</label>
                            <input type="text" class="form-control live-name" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Item Name" name="item" required= "required" >
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <input type="text" class="form-control live-desc" id="exampleInputPassword1"  placeholder="Item Description"   name="description"  required= "required" >
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Price</label>
                            <input type="text" class="form-control live-price" id="exampleInputPassword1"   placeholder="Item Price" name="price"  required= "required">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Country Made</label>
                            <input type="text" class="form-control" id="exampleInputPassword1"   placeholder="Item Country" name="country" required= "required">
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

                            <button type="submit" class="btn btn-primary" style="margin:10px;">Add new Item</button>
                    </form>

                    </div>
                    <div class="col-md-4 col-sm-12 item-box live-preview">
                        <span class="price-area">$0</span>
                        <img src="img.png" class="card-img-top" alt="...">
                        <div class="caption">
                            <h5 class="card-title">Title</h5>
                            <p class="card-text">Description</p>
                        </div>
                    </div>
                </div>   
                <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $itemName= filter_var($_POST['item'] , FILTER_SANITIZE_STRING);
        $itemDesc= filter_var($_POST['description'] ,FILTER_SANITIZE_STRING);
        $itemPrice= filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $itemCountry= filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $itemStatus= filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $itemCategory=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
        
    
        $formErrors = array();
           if(strlen($itemName)<3 ){
             $formErrors[]= "Name can't be less than 3chars";
           }
           if(strlen($itemName)>20 ){
             $formErrors[]= "Name can't be more than 15chars";
           }
           if(empty($itemName)){
             $formErrors[]= "Name can't be empty";
           }
           if(strlen($itemDesc)<10 ){
            $formErrors[]= "Description can't be less than 10chars";
          }
           if(empty($itemDesc)){
             $formErrors[]= "Description can't be empty";
           }
           if(empty($itemPrice)){
             $formErrors[]= "price can't be empty";
           }
           if(strlen($itemCountry)<2){
            $formErrors[]= "Country Made can't be less than 2chars";
          }
           if(empty($itemCountry)){
             $formErrors[]= "Country Made can't be empty";
           }
           if($itemStatus == 0){
            $formErrors[]= "You can't choose empty status";
          }
          if($itemCategory == 0){
            $formErrors[]= "You can't choose empty category";
          }
           //update database
           
           if(empty($formErrors)){
            
           $stmt = $db->prepare("INSERT INTO itemtbl(Name,	Description , Price , 	Country_Made ,	Status , Add_Date , Cat_ID , Member_ID) 
                                 VALUES(:name , :desc , :price , :country , :status , now() , :cat , :member)");
           $stmt->execute(array(
           'name'=> $itemName, 
           'desc'=> $itemDesc, 
           'price'=> $itemPrice, 
           'country'=> $itemCountry,
           'status'=> $itemStatus,
           'cat'=> $itemCategory,
           'member'=>$_SESSION['u-ID']
        
        ));
            echo '<div class="container">';
           echo "<div class ='alert alert-success'>success!<br>Your Will active from Admin</div>"; 
           echo'</div>';  
         }else{
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
        }
    
    }
       
    ?> 
                
            </div>
    </div>
    <?php
    // if($_SERVER['REQUEST_METHOD']=='POST'){
    //     $itemName= filter_var($_POST['item'] , FILTER_SANITIZE_STRING);
    //     $itemDesc= filter_var($_POST['description'] ,FILTER_SANITIZE_STRING);
    //     $itemPrice= filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
    //     $itemCountry= filter_var($_POST['country'],FILTER_SANITIZE_STRING);
    //     $itemStatus= filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
    //     $itemCategory=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
        
    
    //     $formErrors = array();
    //        if(strlen($itemName)<3 ){
    //          $formErrors[]= "Name can't be less than 3chars";
    //        }
    //        if(strlen($itemName)>20 ){
    //          $formErrors[]= "Name can't be more than 15chars";
    //        }
    //        if(empty($itemName)){
    //          $formErrors[]= "Name can't be empty";
    //        }
    //        if(strlen($itemDesc)<10 ){
    //         $formErrors[]= "Description can't be less than 10chars";
    //       }
    //        if(empty($itemDesc)){
    //          $formErrors[]= "Description can't be empty";
    //        }
    //        if(empty($itemPrice)){
    //          $formErrors[]= "price can't be empty";
    //        }
    //        if(strlen($itemCountry)<2){
    //         $formErrors[]= "Country Made can't be less than 2chars";
    //       }
    //        if(empty($itemCountry)){
    //          $formErrors[]= "Country Made can't be empty";
    //        }
    //        if($itemStatus == 0){
    //         $formErrors[]= "You can't choose empty status";
    //       }
    //       if($itemCategory == 0){
    //         $formErrors[]= "You can't choose empty category";
    //       }
    //        //update database
           
    //        if(empty($formErrors)){
            
    //        $stmt = $db->prepare("INSERT INTO itemtbl(Name,	Description , Price , 	Country_Made ,	Status , Add_Date , Cat_ID , Member_ID) 
    //                              VALUES(:name , :desc , :price , :country , :status , now() , :cat , :member)");
    //        $stmt->execute(array(
    //        'name'=> $itemName, 
    //        'desc'=> $itemDesc, 
    //        'price'=> $itemPrice, 
    //        'country'=> $itemCountry,
    //        'status'=> $itemStatus,
    //        'cat'=> $itemCategory,
    //        'member'=>$_SESSION['u-ID']
        
    //     ));
    //         echo '<div class="container">';
    //        echo "<div class ='alert alert-success'>success!<br>Your Will active from Admin</div>"; 
    //        echo'</div>';  
    //      }
    
    // }
       
    // if(!empty($formError)){
    //     foreach($formError as $error){
    //         echo '<div class="alert alert-danger">'.$error.'</div>';
    //     }
    // }
    ?> 
</div>
<?php }else{
    header("Location:login.php");
}
?>
<?php include $tps."footer.php";?>