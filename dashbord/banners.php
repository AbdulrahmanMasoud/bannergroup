<?php

session_start();
if(!isset($_SESSION['admin'])){
    header('Location: login.php');
    exit();
 }
 $title = 'Banners';
 include 'init.php';
?>
 <div class="container">
    <section class="banners mt-5 p-4 bg-light">
        <h4 class="text-center">Your Banners</h4>
        <div class="row">
        <?php $banners = getData('*','groups','groupAdmin',$_SESSION['id']); 
            if($count < 1){echo '<div class="alert alert-warning text-center">There Is No Banners.</div>';}
            foreach($banners as $banner):
        ?>
        
            <div class="col-md-6 col-xs-12 my-3">
                <a href="banner.php?Banner=<?php echo $banner['ranID'];?>">
                    <div class="group position-relative overflow-hidden">
                        <img src="./groups/<?php echo $banner['groupName'].'/'.$banner['groupBanner']; ?>" class="w-100">
                        <h4 class="position-absolute"><?php echo $banner['groupName'];?></h4>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
            
           
        </div>
    </section>

</div>

<?php include $tpl.'/footer.php'; ?>
