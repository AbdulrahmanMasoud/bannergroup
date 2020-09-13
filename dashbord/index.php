<?php 
session_start();
if(!isset($_SESSION['admin'])){ //هنا بقا بقوله لو اتسجل سيشن في يوزر نيم اللي انا عامله تحت حوله علي الصفحه اللي انا محددها دي
    header('Location: login.php');
    exit();
 }
 $title = 'Home';
 include 'init.php';


?>

<!-- Add New Group -->
<!--
<section class="add-group">
    <div class="container">
        <div class="row">
        
        <form action="" method="POST" class='m-auto' enctype="multipart/form-data">
            <h4 class='text-center'>Add New Group</h4>

            <div class="form-group"> 
                <input type="file" class="form-control" name='groupBanner'>
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name='groupName' placeholder = 'Group Name'>
            </div>
            <button type='submit' class="btn btn-info">Add Group</button>
        </form>
        </div>
    </div>
</section>
-->


<div class="container">
    <section class="group-page mt-5 p-4">
        <div class="group-add">
            <h4 class="text-center">Add New Group</h4>
            <div class="group-form  p-3 m-auto">
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group text-center m-0"> 
                        <input type="file" class="form-control d-none input-path" id="add-banner" name='groupBanner'>
                        <label for="add-banner" class="text-center input-label">
                            <i class="fas fa-upload"></i>
                           <br/><span>Add Group Banner</span> 
                        </label>
                    </div>
                    <div class="form-group">
                    <input type="text" class="form-control" name='groupName' placeholder = 'Group Name'>
                    </div>
                    <button type='submit' class="position-relative">Creat New Group</button>
                </form>
            </div>
            
        </div>
        <hr>
       

<?php 
// PHP Code For Creat New group
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Errors = array();
    
    $banerName = $_FILES['groupBanner']['name'];
    $banerSize = $_FILES['groupBanner']['size'];
    $banerTmp  = $_FILES['groupBanner']['tmp_name'];
    $banerType = $_FILES['groupBanner']['type'];
    $groupName = $_POST['groupName'];

   
    $allawExtentions = array("jpeg","jpg","png");
    $banerExtention = explode(".",$banerName);//make array by dot seberator
    $fineshBaner = strtolower(end($banerExtention));// set this text lowercase and get the end one

    if(empty($banerName)){$Errors[]='Pleas Add Img';}
    //if the img extention != my extentions
    if(!in_array($fineshBaner, $allawExtentions)){$Errors[] = 'This Not Img Pleas Add Valeid Image';}
    if($banerSize > 4194304){ $Errors[] = 'Your Img Is larger Than 4MB';}
    if(empty($groupName)){$Errors[] = "Pleas Add Group Name";}
    
    // If Errors Is Empty Make This Code.
    if(empty($Errors)){

        $groupFile = __DIR__."\groups\\".$groupName; //file Dir and add group name 
        if(!file_exists($groupFile)){
            mkdir($groupFile); //Make a new File If the File Not Existe 
        }else{
            $Errors[] = 'This Group Is Exist';
        }
                
        if(file_exists($groupFile)){
        $banerRandName = rand(0, 100000)."_". $banerName;
        // $groupBannerName = str_replace(' ','_',$banerRandName);
        move_uploaded_file($banerTmp, $groupFile .'\\'. $banerRandName);
        //echo $groupFile;
        }
        // $stmtFunc = $con->prepare("SELECT ranID FROM groups WHERE ranID = ?");
        // $stmt->execute(array('abdo'));
        $stmtGroup = $con->prepare("INSERT INTO  groups(groupName,  groupBanner, ranID, groupAdmin) 
                              VALUES(:gname, :gbanner, :granid, :gadmin)");
         $stmtGroup-> execute (array( 
            'gname'   => $groupName,
            'gbanner' => $banerRandName,
            'granid'  => rand(1000, 1000000),
            'gadmin'  => $_SESSION['id']           
         ));
    }
    foreach($Errors as $Error){
        echo '<div class="alert alert-danger">'.$Error.'</div>';
    }
 }
?>
        
<!--This For Get All Groups For This Admin-->
 <?php 
    
    $stmtAllGroups = $con->prepare("SELECT groups.*,admins.username
                                     FROM groups INNER JOIN admins ON admins.userID = groups.groupAdmin
                                     WHERE groupAdmin = ? ORDER BY groupID DESC");

    $stmtAllGroups->execute(array($_SESSION['id']));
    $allGroups = $stmtAllGroups->fetchAll();
    $count = $stmtAllGroups->rowCount();
    
    
    
    ?>
 <div class="groups w-100 p-4">
            <h4 class="text-center pb-4">Your Groups</h4>
            <?php
                if($count < 1){echo '<div class="alert alert-warning text-center">There Is No Groups.</div>';}
            ?>
            <div class="row">
           
                <?php foreach($allGroups as $group): ?>
                <div class="col-md-3 col-sm-6">
                    <figure class="overflow-hidden position-relative">
                        <a href="index.php?action=Delete&ID=<?php echo $group['groupID']; ?>" class="del-group text-center text-decoration-none position-absolute">
                            <i class="fas fa-trash"></i>
                        </a>
                         <div class="g-banner">
                             <img src="<?php echo 'groups\\'.$group['groupName'].'\\'.$group['groupBanner']; ?>" class="img-fluid">
                         </div>
                        <figcaption class="p-2 position-relative">
                            <div class="g-name text-center">
                                <h5>
                                    <a href="group.php?groupID=<?php echo $group['ranID']; ?>" class="text-decoration-none">
                                        <?php echo $group['groupName'];?>
                                    </a>
                                </h5>
                            </div>
                            <div class="g-id text-center ">
                                <p class="m-2"><?php echo $group['ranID'];?></p>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>




<?php
    // DELETE GROUPS
    if(isset($_GET['action']) == 'Delete'&& is_numeric($_GET['ID'])){//check the link

        //get group to use id and name fore group
        // $stmtG = $con->prepare("SELECT *FROM groups WHERE groupID = ?");
        // $stmtG->execute(array($_GET['ID']));
        // $allG = $stmtG->fetch();
        $allG = getData('*','groups','groupID',$_GET['ID'],'fetch');

        if(file_exists('groups\\'.$allG['groupName'])){//check if this file exists 
            $allFiles = scandir(__DIR__ .'\groups\\'. $allG['groupName']);//get all files from this path
           foreach ($allFiles as $file) {//make loop in this files
            unlink('groups\\'. $allG['groupName'] .'\\'.$file); //delete all files form this path
            rmdir('groups\\'. $allG['groupName']);//and finaly delete the folder :D

            //And here delete the group from database
            $stmtDel = $con->prepare("DELETE FROM groups WHERE groupID = ? LIMIT 1");
            $stmtDel->execute(array($_GET['ID']));
            header('location:index.php');//redirect me in index page
           }
        }
    }

?>

<?php include $tpl.'/footer.php'; ?>
