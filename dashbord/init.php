<?php
include 'conect.php';
$tpl = 'inc/templates/'; // templates directory
$css = 'layout/css/'; // css directory
$js = 'layout/js/'; // js directory
$fonts = 'layout/fonts/'; // fonts directory
$func = 'inc/functions/';



// Important Files
include $func . 'functions.php';
include  $tpl . 'header.php'; 

if(!isset($noNav)){
   include  $tpl . 'nav.php';  
}

 



?>