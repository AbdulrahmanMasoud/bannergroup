<?php

 $title = 'Group Banner';

 include 'init.php';




 
 $gID = $_GET['gTokin'];
 
//  $stmt= $con->prepare("SELECT * FROM groups WHERE ranID = ? ");
//  $stmt->execute(array($gID));
//  $group = $stmt->fetch();
//  $count = $stmt->rowCount();
$group = getData('*','groups','ranID',$gID,'fetch');
 if($count > 0):
 $groupPath = 'dashbord\groups\\'.$group['groupName'];
    if(isset($_GET['gTokin']) && !empty($_GET['gTokin']) && is_numeric($_GET['gTokin'])): ?>
<div class="container">
    <section class="member mt-5 p-4">
        <div class="group-add">
            <h4 class="text-center">Join In <?php echo $group['groupName']; ?></h4>
            <div class="member-form p-3 m-auto">
                
                
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $Errors = array();

            $imgName = $_FILES['add-img']['name'];
            $imgSize = $_FILES['add-img']['size'];
            $imgTmp  = $_FILES['add-img']['tmp_name'];
            $imgType = $_FILES['add-img']['type'];

            $allawExtentions = array("jpeg","jpg","png");
            $imgExtention = explode(".",$imgName);
            $fineshImg = strtolower(end($imgExtention));

            if(empty($imgName)){$Errors[]='Pleas Add Img';}
            if(!in_array($fineshImg, $allawExtentions)){$Errors[] = 'This Not Img Pleas Add Valeid Image';}
            if($imgSize > 4194304){ $Errors[] = 'Your Img Is larger Than 4MB';}  
                
                if(empty($Errors)){
                    if(file_exists($groupPath)){
                        $imgRandName = rand(0, 100000)."_". $imgName;

                        move_uploaded_file($imgTmp, $groupPath .'\\'. $imgRandName);
                    }

                $stmtAddImg = $con->prepare("INSERT INTO  imgs(img, groupTokin) 
                                      VALUES(:gimg, :gtokin)");
                 $stmtAddImg-> execute (array( 
                    'gimg'   => $imgRandName,
                    'gtokin' => $gID,

                 ));
                    // if($stmtAddImg){
                    //     echo '<div class="alert alert-success">Add Img Done.</div>';
                    // }
                }

            }
        ?>
                 
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-member text-center m-0"> 
                        <input type="file" class="form-control d-none input-path" id="add-member" name='add-img'>
                        <label for="add-member" class="text-center input-label">
                            <i class="fas fa-upload"></i>
                           <br/><span>Select Image</span> 
                        </label>
                    </div>
                    
                    <button type='submit' class="position-relative">Upload</button>
                </form>
            </div>
        </div>
        
        <hr>
<!--  Imgs Members      -->
        <div class="members w-100 p-4">
            <h4 class="text-center pb-4">Group Members</h4>
            <div class="imgs">
                <?php
                if(isset($Errors)){
                foreach($Errors as $Error){
                    echo '<div class="alert alert-danger">'.$Error.'</div>';
                }}
                ?>
                <div class="row">
                    <?php
                        //  $stmtImg= $con->prepare("SELECT * FROM imgs WHERE groupTokin = ? ");
                        //  $stmtImg->execute(array($gID));
                        //  $imgs = $stmtImg->fetchAll();
                        //  $count = $stmtImg->rowCount();
                        $imgs = getData('*','imgs','groupTokin',$gID);
                        if($count > 0):
                            foreach($imgs as $img):
                    ?>
                    <div class="col-md-2 col-4 px-0 overflow-hidden img-container">
                        <img src="<?php echo $groupPath .'\\'. $img['img']; ?>" class="w-100 h-100">
                    </div>
                        <?php endforeach; ?>
                    <?php else: echo '<div class="alert alert-warning text-center w-100">There Is No Images</div>';?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

</div>



<?php endif; ?>
<?php else: echo  'Not This Found Group'; endif; ?>
<?php include  $tpl . 'footer.php';  ?>