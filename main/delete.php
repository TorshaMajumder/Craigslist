<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php 
        session_start();
        $username = $_SESSION['username'];
        $post_id = $_GET['postid'];
        $DBServer = 'localhost';
            $DBUser = 'root';
            $DBPasswd = 'root';
            $DBName = 'wpl_final_project';
            $conn = new mysqli($DBServer, $DBUser, $DBPasswd, $DBName);
            if ($conn->connect_error) {
                trigger_error('Database connection failed: ' .  $conn->connect_error, E_USER_ERROR);
            }
        $img = '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';
        //
        //
        //
        $sql = "UPDATE Posts SET Image_1 = '$img', Image_2 = '$img', Image_3 = '$img' WHERE Post_ID = '$post_id'";
        //
        //
        if (mysqli_query($conn, $sql)) {
            //echo "success";
            $last_inserted_id = $conn->insert_id;
            $affected_rows = $conn->affected_rows;
            } 
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        // Close MySQL connection
        mysqli_close($conn);
        // Redirect page to settings.php
        header('location:settings.php');

    	
    ?>







</body>
</html>