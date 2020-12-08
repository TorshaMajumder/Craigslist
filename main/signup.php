<!DOCTYPE html>
<html lang="en">
<head>
    <title>signup</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="signup.css" rel="stylesheet">
    <?php
        if ($_POST && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmpassword'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $cpassword = $_POST['confirmpassword'];
            $email = $_POST['email'];
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                echo "<div id='alert'><div class='alert alert-danger alert-dismissible' role='alert'>\n";
                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\n";
                echo "<strong>Error!&nbsp&nbsp</strong>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.\n";
                echo "</div></div>\n"; 
            }
            else{
                    //
                    // Connect to MySQL server
                    //
                    $DBServer = 'localhost';
                    $DBUser = 'root';
                    $DBPasswd = 'root';
                    $DBName = 'wpl_final_project';
                    $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
                    if ($conn->connect_error) {
                        trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
                    }
                    //
                    // Query to check username duplication
                    //
                    $sql = "SELECT * FROM Users WHERE Username='$username'";
                    $rs = $conn->query($sql);
                    if ($rs === false) {
                        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
                    }
                    //
                    // Query to check email duplication
                    //
                    $email_sql = "SELECT * FROM Users WHERE Email='$email'";
                    $email_rs = $conn->query($email_sql);
                    if ($email_rs === false) {
                        trigger_error('Wrong SQL: ' . $email_sql . ' Error: ' . $conn->error, E_USER_ERROR);
                    }
                    if ($rs->num_rows >= 1) {
                        echo "<div id='alert'><div class='alert alert-danger alert-dismissible' role='alert'>\n";
                        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\n";
                        echo "<strong>Error!&nbsp&nbsp</strong>Username is already in use. Please try another one.\n";
                        echo "</div></div>\n";
                    } 
                    elseif($email_rs->num_rows >= 1){
                    echo "<div id='alert'><div class='alert alert-danger alert-dismissible' role='alert'>\n";
                        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\n";
                        echo "<strong>Error!&nbsp&nbsp</strong>Email is already in use. Please try another one.\n";
                        echo "</div></div>\n";
                    }
                    elseif (strcmp($password, $cpassword)) {
                        echo "<div id='alert'><div class='alert alert-danger alert-dismissible' role='alert'>\n";
                        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\n";
                        echo "<strong>Error!&nbsp&nbsp</strong>Password doesn't match confirm password.\n";
                        echo "</div></div>\n";               
                        }
                        else{
                        //
                        // Insert to table
                        //
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        
                        $sql = "INSERT INTO Users (Username, Password, Email) VALUES ('$username', '$hashed_password', '$email')";
                        $rs = $conn->query($sql);
                        if ($rs === false) {
                            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
                        }
                        session_start();
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        header('location:signin.php');
                    }
                }        

        }


            
            
        
        ?>
</head>
<body>
    <div class="container">
        <form class="form-signup" method="POST">
            <h2 class="form-signup-heading">Sign up</h2>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="username" id="inputUsername" name="username" class="form-control" placeholder="User Name" required autofocus>
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            <label for="confirmPassword" class="sr-only">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmpassword" class="form-control" placeholder="Enter password again" required>
            <div class="checkbox">
            </div>
            <button class="btn btn-lg btn-info btn-block" type="submit" id="signup-btn">Sign up</button>
        </form>

    </div> 
</body>
</html>
