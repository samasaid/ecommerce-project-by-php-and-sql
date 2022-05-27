<?php

ob_start();

session_start();
if(isset($_SESSION['UserName'])){
    $pageTitle = 'Dashboard';
    include "init.php";
    // بيحسب عدد الكولمن الموجوده فى الداتا بيز او عدد ال members
    // $stmt2 = $db->prepare('SELECT COUNT(UserID) FROM items');
    // $stmt2->execute();
    // $count= $stmt2->fetchColumn();
    // echo $count;
    ?>
        <div class='container'>
            <div class="row cards">
                    <div class="col-md-3 col-sm-12">
                        <div class="card">
                        <div class="card-body member">
                            <i class="fa fa-users"></i>
                            <h4 class="card-title">Total Member</h4>
                            <p class="card-text"><?php echo itemNum('UserID' , 'items')?></p>
                            <a href="members.php?do=Manage">Go to Members</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                        <div class="card-body pMember">
                        <i class="fa fa-user-plus"></i>
                            <h4 class="card-title">Pinding Member</h4>
                            <p class="card-text"><?php echo checkItem('RegStatus' , 'items' , 0) ?></p>
                            <a href="members.php?page=Pinding">Pinding Member</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                        <div class="card-body item">
                        <i class="fa fa-tag"></i>
                            <h4 class="card-title">Total Items</h4>
                            <p class="card-text"><?php echo itemNum('item_ID' , 'itemtbl') ?></p>
                            <a href="items.php?page=Manage">Go To Items</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                        <div class="card-body comment">
                        <i class="fa fa-comments"></i>
                            <h4 class="card-title">Total Comments</h4>
                            <p class="card-text"><?php echo itemNum('Com_ID' , 'comments') ?></p>
                            <a href="comments.php">Go Comments</a>
                        </div>
                        </div>
                    </div>
            </div>
           
            <div class='row leasts'>
                <div class='col-md-6 col-sm-12'>
                    <div class="card">
                        <?php $UserNum = 3; ?>
                        <div class="card-header">
                            <i class="fa fa-user"></i>
                            Latest <?php echo $UserNum; ?> Members
                            <span class="toggle-info float-right">
                                <i class="fa fa-minus fa-lg"></i>
                            </span>
                        </div>
                            <div class="card-body">
                                <div class="card-text">
                                    <?php $LatestUsers= getLatest('*' , 'items', 'UserID' , $UserNum );
                                    if(!empty( $LatestUsers)){
                                    foreach($LatestUsers as $users){
                                    echo "<li>".$users['UserName']."<a href = 'members.php?do=Edit&userid=".$users['UserID']."' type='button' class='btn btn-success  float-right'>
                                    <i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit</a>";
                                    if($users['RegStatus'] == 0){
                                            echo "<a href ='members.php?do=Approve&userid=".$users['UserID']."' type='button' class='btn btn-info  float-right confrim' style = 'text-decoration:none; color:#fff;'>Approve</a>";
                                
                                        }
                                        echo "</li>";
                                    }
                                    }else{
                                        echo "<div class='alert alert-info'> Not found latest Users</div>";
                                    }
                                ?></div>
                            </div>    
                    </div>
                </div>
                <div class='col-md-6 col-sm-12'>
                    <div class="card">
                        <?php $ItemNum = 3; ?>
                        <div class="card-header">
                            <i class="fa fa-tag"></i>
                            Latest <?php echo $ItemNum; ?> Items
                            <span class="toggle-info float-right">
                                <i class="fa fa-minus fa-lg"></i>
                            </span>
                        </div>
                        <div class="card-body">
                                <div class="card-text">
                                    <?php $LatestItem= getLatest('*' , 'itemtbl', 'item_ID' , $ItemNum );
                                    if(!empty( $LatestItem)){
                                    foreach( $LatestItem as $Item){
                                        echo "<li>".$Item['Name']."<a href = 'items.php?do=Edit&itemid=".$Item['item_ID']."' type='button' class='btn btn-success  float-right'>
                                        <i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit</a>";
                                        if($Item['Approve'] == 0){
                                                echo "<a href ='items.php?do=Approve&itemid=".$Item['item_ID']."' type='button' class='btn btn-info  float-right confrim' style = 'text-decoration:none; color:#fff;'>Approve</a>";
                                    
                                            }
                                            echo "</li>";
                                        }
                                    }else{
                                        echo "<div class='alert alert-info'> Not found latest Item</div>";
                                    }
                                        ?>
                                </div>
                        </div>    
                    </div>    
                </div>
           </div> 
           <div class='row leasts'>
                <div class='col-md-6 col-sm-12'>
                        <div class="card">
                                <?php $commentsNum = 2; ?>
                                <div class="card-header">
                                    <i class="fa fa-comments"></i>
                                    Latest <?php echo $commentsNum; ?> Comments
                                    <span class="toggle-info float-right">
                                        <i class="fa fa-minus fa-lg"></i>
                                    </span>
                                </div>
                                    <div class="card-body">
                                        <div class="card-text">
                                        <?php
                                            $stmt2 = $db->prepare("SELECT comments.*, items.UserName
                                            FROM comments
                                            INNER JOIN items ON items.UserID = comments.userid
                                            ORDER BY Com_ID DESC
                                            LIMIT $commentsNum");
                                            $stmt2->execute();
                                            $coms = $stmt2->fetchAll();
                                            if(!empty($coms)){
                                            foreach( $coms as $com){
                                               echo "<div class='comment-box'>";
                                               echo "<span class='member-n'>".$com['UserName']."</span>";
                                               echo "<p class='member-c'>".$com['Comment']."</p>";
                                               echo "</div>";
                                                }
                                            }else{
                                                echo "<div class='alert alert-info'> Not found latest Comment</div>";
                                            }
                                                ?>
                                        
                                        </div>
                                    </div>    
                                    
                        </div>    
                </div>
            </div> 
        </div>     
    
   <?php
    include $tps."footer.php";
}else{
    header("location:index.php");
    exit();
}
ob_end_flush();