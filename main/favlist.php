<!DOCTYPE html>
<html>
<head>
	<link href="css/favlist.css" rel="stylesheet">
</head>
<body>
    <?php
        session_start();
        session_start();
        $username = $_SESSION['username'];
        $post_id = $_GET['postid'];
        //
		// Connect to MySQL server
        //
        $DBServer = 'localhost';
        $DBUser = 'root';
        $DBPasswd = 'root';
        $DBName = 'wpl_final_project';
        $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
        //
        //
        if ($conn->connect_error) {
            trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
        }
        //
        //
        $sql = "SELECT * FROM Users WHERE Username = '$username'";
        $rs = $conn->query($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        $row = $rs->fetch_assoc();
        $user_id = $row['ID'];
        //
        //
        $sql = "SELECT * FROM favlist WHERE (USER_ID = $user_id AND Post_ID = $post_id)";
        $rs = $conn->query($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        if ($rs->num_rows >= 1) {
        echo"<div>";
        echo "<p>This product is already present in your Favorites!</p>";
        }
    	else{
    	$sql = "INSERT INTO favlist (User_ID, Post_ID) VALUES ($user_id, $post_id)";
        $rs = $conn->query($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        else{
        echo"<div>";
        echo "<p>Product added to your Favorites.</p>";
		}
	}
	$conn->close();
    echo "<p><a href='postdetails.php?postid=$post_id' class='btn btn-primary' role='button'>Back</a></p>";
    echo "</div>";
?>
</body>
</html>