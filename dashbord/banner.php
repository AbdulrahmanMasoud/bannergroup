<?php

session_start();
if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit();
 }
 $title = 'Banners';
 $bannerHere = true;
 include 'init.php';
?>

<?php 
if(isset($_GET['Banner']) && !empty($_GET['Banner']) && is_numeric($_GET['Banner'])):
$groupTokin = $_GET['Banner'];
//  $imgsBanner = getData('*','imgs','groupTokin',$groupTokin); 
$stmtBanner = $con->prepare("SELECT imgs.*,groups.groupName
                            FROM imgs 
                            INNER JOIN groups 
                            ON groups.ranID = imgs.groupTokin
                            WHERE groupTokin = ?");

$stmtBanner->execute(array($groupTokin));
$imgsBanner = $stmtBanner->fetchAll();
$count = $stmtBanner->rowCount();


?>

<div class="container">
    
    <section class="banner mt-5 p-4 bg-light">
    <?php  if($count < 1){echo '<div class="alert alert-warning text-center">There Is No Imags In This Group.</div>';} ?>
   
        <div class="all-imgs" id="banner">
            <?php foreach($imgsBanner as $img): ?>
            <img src="groups/<?php echo $img['groupName'].'/'.$img['img']; ?>" class="img-fluid">
            <?php endforeach; ?>
            
        </div>
        <button onclick="talkScreen()" class="position-absolute">Take Photo</button>
    </section>
    <section class="bnnImg mt-5 p-4 bg-light" id='bnnImg'>
        <p class="text-center">You Can Download It Now</p>
    </section>
<a href="" id="img-banner" download></a>
</div>
<?php else: header('Location:banners.php'); endif; ?>




<?php include $tpl.'/footer.php'; ?>