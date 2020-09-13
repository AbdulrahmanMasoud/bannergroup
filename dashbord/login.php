<?php
session_start(); // هنا انا عمل سيشن جديده
$title = 'Login';
$noNav = '';
if(isset($_SESSION['admin'])){
    header('Location: index.php');
    exit();
}

?>
               
<?php
    include 'init.php';
/******** Logi Admin **********/
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
        $logError = array();
        $user = $_POST['admin'];
        $pass = $_POST['pass'];
        $hashed_pass = sha1($pass);
        // //echo $user .' ' . $hashed_pass;

        // if(isset($user) && !empty($user)){$cleanUser = filter_var($user, FILTER_SANITIZE_STRING);}
        // if(empty($user)){$logError[] = 'Pleas Write UserName';}
        // if(sha1($pass) === sha1('')){$logError[] = 'Pleas Add Password';}


        $stmt = $con->prepare("SELECT * FROM admins WHERE username = ? AND `password` = ? LIMIT 1");
        $stmt->execute(array($user,$hashed_pass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
         if($count > 0){
            $_SESSION['admin'] = $user; 
            $_SESSION['id'] = $row['userID'];
            header('Location: index.php');
            exit();
            
            }
    }

/*************** Register Admin ******************/
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
    $Errors = array();
    $userName = $_POST['rUsername'];
    $fullName = $_POST['rFullname'];
    $password = $_POST['rPassword'];
/**
 * Check the inputs
 */
    if(isset($userName) && !empty($userName)){
        $cleanUser = filter_var($userName, FILTER_SANITIZE_STRING);
        if(strlen($cleanUser) < 4){
            $Errors[] = 'User Name Is Shorter Than 4';
        }
    }else{$Errors[] = 'Pleas Add UserName';}

    if(isset($fullName) && !empty($fullName)){
        $cleanName = filter_var($fullName, FILTER_SANITIZE_STRING);
        if(strlen($cleanName) < 8){
            $Errors[] = 'Your Name Is Shorter Than 8';
        }
    }else{$Errors = 'Pleas Add Full Name';}
    if(sha1($password) == sha1('')){
        $Errors[] = 'Pleas Add Password';
    }
    // print_r($Errors);
    // if(!empty($Errors)){
    //     foreach($Errors as $Error){
    //         echo $Error;
    //     }
    // }


    /**
     * 
     * insart Into database
     */
    if(empty($Errors)){
        $stmtUser = $con->prepare("INSERT INTO  admins(`name`,  username, `password`) VALUES(:rname, :ruser, :rpass)");
        $stmtUser-> execute (array(
            'rname' => $fullName,
            'ruser' => $userName,
            'rpass' => sha1($password)
            
        ));
        echo "<div class='alert alert-success text-center' >You Can Login Now</div>";
    }
}



    ?>
       




<div class="container">
    <section class="reg-log d-flex position-relative">
<div class="overlay position-relative">
    <span class="position-absolute reg-show" id="reg-show" ><i class="fas fa-user-plus ico"></i></span>
    <span class="position-absolute log-show" id="log-show" ><i class="fas fa-sign-in-alt ico"></i></span>
    <div class="overlay-login">
        <h4 class="py-3">SignIn To Banner Group</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
             Ipsa enim veniam aliquam veritatis, necessitatibus modi.</p>
             <button class="reg-show position-relative">Register</button>

    </div>
    <div class="overlay-register d-none">
        <h4 class="py-3">Join With Us</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
             Ipsa enim veniam aliquam veritatis, necessitatibus modi.</p>
             <button  class="log-show position-relative ml-4">Login</button>
    </div>

</div>
<!--  Login Section      -->
        <div class="login position-relative">
            <h3 class="py-4">Login</h3>
            <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
                <div class="form-group m-0">
                    <i class="fas fa-user icform "></i>
                    <input  type="text" class="form-control pr-4" name='admin' autocomplete="off" placeholder="Enter UserName">
                </div>
                <div class="form-group">
                    <i class="fas fa-unlock icform "></i>
                    <input  type="password" class="form-control" name='pass' autocomplete="new-password" placeholder="Enter Password">
                </div>
                <button type="submit" name='login' class="position-relative">Login</button>
            </form>
        </div>
        
        
<!--   Registr Section     -->
        <div class="register position-absolute">
            <h3 class="pb-4 pt-2">Register</h3>
            <?php 
           
            ?>
            <form action="" method="post">
                <div class="form-group m-0">
                    <i class="fas fa-user icform "></i>
                    <input name='rUsername'  type="text" class="form-control" placeholder="Enter UserName">
                </div>
                <div class="form-group m-0">
                    <i class="fas fa-user icform "></i>
                    <input name='rFullname' type="text" class="form-control" placeholder="Enter Full Name">
                </div>
                <div class="form-group">
                    <i class="fas fa-unlock icform "></i>
                    <input name='rPassword' type="password" class="form-control" placeholder="Enter Password">
                </div>
                <button type="submit" name='register' class="position-relative">Register</button>
            </form>
        </div>
    
        

        
        
                
    </section>
</div>












   
  <?php include ('./inc/templates/footer.php'); ?>