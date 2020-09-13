<?php 

 $title = 'Home';
 include 'init.php';


    

?>

<!-- Add New Group -->
<section class="join-group">
    <div class="container">
                <div class="join-group mt-5 p-4 bg-light">
                    <p class='text-center'>Join In Your group Now</p>
                    <form action="group.php?gTokin=<?php echo $gTokin; ?>" method='GET'>
                    <div class="form-group">
                    <input type="text" name='gTokin' class='form-control' placeholder='Pleas Wright Group Id Like: 235648'>
                    </div>
                    <button type='submit' class='position-absolute'>Join Group</button>
                    </form>
                </div>
    </div>
</section>
<?php
include $tpl.'/footer.php';
 ?>



    
