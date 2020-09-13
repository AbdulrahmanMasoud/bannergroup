<?php

session_start();
if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit();
 }
 $title = 'Group Mange';
 include 'init.php';






if(isset($_GET['groupID']) && !empty($_GET['groupID']) && is_numeric($_GET['groupID'])): ?>


<div class="container">
    <section class="add-member mt-5 p-4">
        <div class="group-add">
            <h4 class="text-center">Add New Member</h4>
            <div class="add-member-form  p-3 m-auto">
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-member text-center m-0"> 
                        <input type="file" class="form-control d-none input-path" id="add-member" name='add-member'>
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
     


<?php 
$gID = $_GET['groupID'];

$group = getData('*','groups','ranID',$gID,'fetch');

// $stmt= $con->prepare("SELECT * FROM groups WHERE ranID = ? ");
// $stmt->execute(array($gID));
// $group = $stmt->fetch();


 if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Errors = array();
    
    $memberName = $_FILES['add-member']['name'];
    $memberSize = $_FILES['add-member']['size'];
    $memberTmp  = $_FILES['add-member']['tmp_name'];
    $memberType = $_FILES['add-member']['type'];


   
    $allawExtentions = array("jpeg","jpg","png");
    $memberExtention = explode(".",$memberName);
    $fineshMember = strtolower(end($memberExtention));

    if(empty($memberName)){$Errors[]='Pleas Add Img';}
    if(!in_array($fineshMember, $allawExtentions)){$Errors[] = 'This Not Img Pleas Add Valeid Image';}
    if($memberSize > 4194304){ $Errors[] = 'Your Img Is larger Than 4MB';}    
    // If Errors Is Empty Make This Code.
    if(empty($Errors)){

       
        $groupFile = __DIR__ .'\groups\\'. $group['groupName'];
        if(file_exists($groupFile)){
        $memberRandName = rand(0, 100000)."_". $memberName;
       
        move_uploaded_file($memberTmp, $groupFile .'\\'. $memberRandName);
        }
        
        $stmtImg = $con->prepare("INSERT INTO  imgs(img, groupTokin) 
                              VALUES(:gimg, :gtokin)");
         $stmtImg-> execute (array( 
            'gimg'   => $memberRandName,
            'gtokin' => $gID,
                      
         ));
    }
    foreach($Errors as $Error){
        echo '<div class="alert alert-danger">'.$Error.'</div>';
    }
 }
?>
  
 <?php 
    // $stmtAllImgs = $con->prepare("SELECT * FROM imgs WHERE groupTokin = ? ");

    // $stmtAllImgs->execute(array($gID));
    // $imgs = $stmtAllImgs->fetchAll();
    $imgs = getData('*','imgs','groupTokin',$gID,'fetchAll');
    // $count = $stmtAllImgs->rowCount();
     if($count > 0){
    
?>
        
   <div class="members-imgs w-100 p-4">
            <h4 class="text-center pb-4">Group Members</h4>
            <div class="imgs">
                <div class="row">
                    <?php foreach($imgs as $img): ?>
                    <div class="col-md-2 col-4 px-0 overflow-hidden img-container">
                        <img src="groups\<?php echo $group['groupName'].'\\'.$img['img'];?>" class="w-100 h-100">
                        <a href='group.php?groupID=<?php echo $gID;?>&delete=<?php echo $img['imgID'];?>' class="del-img text-center position-absolute">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </section>
</div>        



<?php 

if(isset($_GET['delete']) && is_numeric($_GET['delete'])){


    $stmtDel = $con->prepare("DELETE FROM imgs WHERE imgID = ? LIMIT 1");
    $stmtDel->execute(array($_GET['delete']));
    header('location:group.php?groupID='.$gID);

    //   if(file_exists('groups\\'.$group['groupName'].'\\'.$img['img'])){echo 'yes';
    //     unlink('groups\\'.$group['groupName'].'\\'.$img['img']);
    //     header('location:group.php?groupID='.$gID);
    // }else{
    //     echo 'no img to delete';
    // }
        // $xx = scandir(__DIR__ .'\groups\\'. $group['groupName']);
        // print_r($xx);

}


     }else{ echo '<div class="alert alert-info text-center">No Img To Show</div>';};
?>
 


<?php   endif; ?>

<?php include $tpl.'/footer.php'; ?>
