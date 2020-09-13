 
    
     
     
     
     
     
     
 
 <script src="<?php echo $js ?>jQuery3.js"></script>
 <script src="<?php echo $js ?>bootstrap.min.js"></script>
 <script src="<?php echo $js ?>all.min.js"></script>
 <?php if(isset($bannerHere) && $bannerHere == true):?>
   <script src="<?php echo $js ?>html2canvas.js"></script>
 <?php endif; ?>
 <script src="<?php echo $js ?>main.js"></script>
 

 </body>
 </html>
 <?php ob_end_flush(); ?>