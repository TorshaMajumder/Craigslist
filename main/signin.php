<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signin</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">
    <?php
        if ($_POST && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Connect to MySQL server
            $DBServer = 'localhost';
            $DBUser = 'root';
            $DBPasswd = 'root';
            $DBName = 'wpl_final_project';
            $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
            if ($conn->connect_error) {
                trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
            }
            // Look up all Users
            // TODO: figure out how to deal with SQL injection attach
            
            $sql = "SELECT * FROM Users WHERE Username='$username'";
            $rs = $conn->query($sql);
            if ($rs === false) {
                trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
            }
            $row = $rs->fetch_assoc();
            $hashed_password = $row['Password'];
            //echo $hashed_password1;
            if(password_verify($password, $hashed_password)){
                //echo "Passwords match";
                session_start();
                $_SESSION['auth'] = 'true';
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $row['Email'];
                // Redirect to add new post page
                header('location:postlists.php');
            }
            else{
                //echo "no match found";
                echo "<div id='alert'><div class='alert alert-danger alert-dismissible' role='alert'>\n";
                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\n";
                echo "<strong>Error!&nbsp&nbsp</strong>Wrong user name or password. Please try again.\n";
                echo "</div></div>\n";
            }

            
        }
    ?>
</head>
<body>
    <div class="container">
        <form class="form-signin" method="POST">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="username" id="inputUsername" name="username" class="form-control" placeholder="User Name" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" id="signin-btn">Log in</button>
        </form>
        <form class="form-signup" action="signup.php">
            <button class="btn btn-lg btn-info btn-block" type="submit" id="signup-btn">Sign up</button>
        </form>

    </div> <!-- /container -->
</body>
</html>
