<!DOCTYPE html>  
    <head>
        <title>Welcome to Crowdfunding!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="./css/styles.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="./css/bootstrap.css">
        <!-- Boostrap JS dependencies -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="./js/bootstrap.js"></script>
    </head>
    
    <body>
        <?php
            session_start();
            
            // to make sure user can only get here if he is logged in
            if (!isset($_SESSION[userid])) {
                header("Location: index.php");
            }
        ?>
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"><img src="./docs/logo.png" width="30" height="30" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addproject.php">Add your own Project</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="account.php">Account settings <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <span class="navbar-text" style="margin-right: 1%" >
                    <?php 
                        echo "Logged in as"." $_SESSION[userid]";
                    ?>
                </span>
                <form name="display" class="form-inline" action="main.php" method="POST">
                    <button class="btn btn-outline-danger" type="submit" name="logout_submit">Logout</button>
                </form>
            </div>
        </nav>
        
        <div class="container">
            <div class="text-center">
                <h1>Account Settings</h1>
                <br>
            </div>
            
            <form action="account.php" method="POST">
                <div class="form-group row">
                    <div class="col-lg-3"></div>
                    <label for="change_password" class="col-lg-2 col-form-label text-right">New password: </label>
                    <div class="col-lg-3">
                        <input name="change_password" type="password" class="form-control" placeholder="Password" required/>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <div class="form-group text-center">
                   <button class="btn btn-primary" type="submit" name="changepwd_submit">Change Password</button>
                </div>
            </form>

            <div class="text-center">
                <?php
                    // connect to the database
                    $db = pg_connect("host=localhost port=5432 dbname=project1 user=postgres password=test");	

                    if (isset($_POST[logout_submit])) {
                        session_unset();
                        session_destroy();
                        header("Location: index.php");
                    }
                    
                    if (isset($_POST[changepwd_submit])) {
                        $query = "UPDATE account SET password = '$_POST[change_password]' WHERE userid = '$_SESSION[userid]'";
                        $result = pg_query($db, $query);
                        if (!$result) {
                            echo "Failed to change password.";
                        }
                        else {
                            echo "Password updated!";
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>