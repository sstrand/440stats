        <nav class="navbar navbar-expand-lg navbar-team-color-primary">
            <a class="navbar-brand navbar-team-color-primary" href="Homepage.php">Sport Statistic Website</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto navbar-team-color-primary">

                    <li class="nav-item active">
                        <a class="nav-link navbar-team-color-primary" href="PlayerDatabase.php?year=2019">Player Database</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link navbar-team-color-primary" href="TeamDatabase.php?year=2019">Team Database</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-team-color-primary" href="#" id="dropCompare" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Comparison
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropCompare">
                            <a class="dropdown-item" href="PlayerComparison.php">Player</a>
                            <a class="dropdown-item" href="TeamComparison.php">Team</a>
                        </div>
                    </li>
                </ul>
           
                <form class="form-inline my-2 my-lg-0" action = "searchResults.php" method="GET">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" name = "searched" aria-label="Search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit" onclick = "submit" value = "submit">Search</button>
                </form>

                <?php if (isset($_SESSION['user_id'])) { ?>
                
                    <div class="">
                        <a class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle navbar-team-color-primary add-space btn btn-navbar" href="Settings.php" id="navbarSettings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">     
                                <?php echo $_SESSION['user_name']; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarSettings">
                                <a class="dropdown-item" href="Settings.php">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a> 
                            </div>
                        </a>
                    </div>

                <?php 
                } else { 
                ?>

                <a class="nav-link navbar-team-color-primary" href="login.php">Login</a> |
                <a class="nav-link navbar-team-color-primary" href="register.php">Sign Up</a>
                <?php 
                } 
                ?>
            </div>
        </nav>
