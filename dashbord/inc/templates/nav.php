    <?php
    
    $user = getData('username','admins','userID',$_SESSION['id'],'fetch');

    ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container">
                <a class="navbar-brand logo" href="#">Group Banner</a>
                <div class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </div>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                         <li class="nav-item">
                            <a href="banners.php" class="nav-link">Banners</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">Groups</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $user['username']; ?>
                        </a>
                        <div class="dropdown-menu py-1" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item px-2" href="logout.php">
                                Log Out 
                                <i class="fas fa-sign-out-alt logicon"></i>
                            </a>
                        </div>
                    </li>
                    
                    </ul>
                </div>
            </div>
          </nav>
    </header>